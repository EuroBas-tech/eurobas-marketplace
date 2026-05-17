# Mobile API Changes — Milestone 1 Closeout

Addresses mobile developer feedback (13 May 2026) covering social login,
user-details fetching, ad-details composition, and the translations API.

All endpoints below are public unless explicitly marked `auth:api`.
Bearer tokens are Laravel Passport access tokens — pass them as
`Authorization: Bearer <token>` exactly like `/api/v1/auth/login` already
returns.

---

## 1. Social login — `POST /api/v1/auth/social-login`

**Why it changed.** The previous endpoint required the client to send
`token`, `unique_id`, `email`, and `medium` separately. Email/unique_id
were trusted blindly, so a malicious client could log in as any user
whose email they knew. The new shape accepts a single provider-issued
`id_token` (or Facebook `access_token`) which the backend verifies
against the provider before issuing a bearer token. Also makes the route
strictly `POST` (was `Route::any`).

**Request**

```http
POST /api/v1/auth/social-login
Content-Type: application/json

{
  "provider": "google" | "facebook" | "apple",
  "id_token": "<JWT or access token from the provider SDK>",
  "email":    "<optional, only used as Apple fallback>",
  "first_name": "<optional, Apple only — first-sign-in name>",
  "last_name":  "<optional, Apple only — first-sign-in name>"
}
```

Notes:
- **Google:** send the `id_token` returned by Google Sign-In. The backend
  hits `https://oauth2.googleapis.com/tokeninfo` to verify.
- **Apple:** send the `id_token` from "Sign in with Apple". The backend
  verifies the JWT signature against Apple's JWKS. Apple only includes
  the user's email/name on the *first* sign-in, so subsequent logins may
  need `email` (and optionally `first_name` / `last_name`) supplied
  again — Apple's `sub` claim is still the source of truth for identity.
- **Facebook:** the field is named `id_token` for symmetry, but the
  Facebook SDK actually returns an `access_token`. Send the access token
  in `id_token`. The backend calls Graph API
  (`https://graph.facebook.com/me?fields=id,name,email`) to verify.

**Response — success (200)**

```json
{
  "token": "eyJ0eXAiOiJKV1Qi...",
  "profile_complete": true,
  "message": "login_successful"
}
```

- `token` is the Passport bearer token. Use it as
  `Authorization: Bearer <token>` for every subsequent authenticated
  call (e.g. `/api/v1/customer/profile`, `/api/v1/ads/auction`,
  `/api/v1/customer/wish-list/add`).
- `profile_complete` is `true` when the user has `phone_code`, `phone`,
  `country`, `city`, and `native_language` set. Mobile should send the
  user through the profile-completion flow if it is `false` (the same
  shape `Helpers::prevent_if_profile_incomplete()` enforces on web).

**Response — validation/auth error (4xx)**

Identical envelope to `/api/v1/auth/login`:

```json
{
  "errors": [
    { "code": "auth-social-001", "message": "wrong_credential" }
  ]
}
```

Error codes:
- `auth-social-001` — token verification failed (network error, expired
  token, wrong signature). HTTP 401.
- `auth-social-002` — provider did not return an email or `sub`. HTTP
  401.
- `auth-001` — user exists but is suspended. HTTP 401.

**Files**

- [`app/Http/Controllers/api/v1/auth/SocialAuthController.php`](app/Http/Controllers/api/v1/auth/SocialAuthController.php) — rewritten.
- [`routes/api/v1/api.php`](routes/api/v1/api.php) — `Route::any` → `Route::post`.

---

## 2. User details by id — `GET /api/v1/users/{id}`

**Why.** Mobile asked for a way to look up a user given the id, so they
can render the seller card on the ad-details page without needing a
separate authenticated call.

**Request**

```http
GET /api/v1/users/42
```

Public — no bearer required.

**Response — success (200)**

```json
{
  "user": {
    "id": 42,
    "name": "John Doe",
    "image": "1234.jpg",
    "cover_image": "5678.jpg",
    "bio": "Selling family car",
    "account_type": "individual",
    "country": "FR",
    "city": "Paris",
    "native_language": "fr",
    "phone": "+33612345678",
    "phone_code": "+33",
    "email": null,
    "is_phone_verified": true,
    "is_email_verified": true,
    "show_phone_number": true,
    "show_email_address": false,
    "show_location_data": true,
    "ads_count": 7,
    "member_since": "2025-09-01T08:11:32.000000Z"
  }
}
```

Visibility flags are respected — `phone` / `email` / `country` / `city`
are returned as `null` when the user has hidden them in their profile
settings (`show_phone_number`, `show_email_address`,
`show_location_data`). The boolean flags are still returned so the
client knows the user chose to hide the value (vs. simply not setting
it).

`ads_count` counts only active (`status = 1`) ads.

**Response — not found (404)**

```json
{
  "errors": [
    { "code": "user-001", "message": "user_not_found" }
  ]
}
```

**Files**

- [`app/Http/Controllers/api/v1/CustomerController.php`](app/Http/Controllers/api/v1/CustomerController.php) — added `show($id)`.
- [`app/CPU/helpers.php`](app/CPU/helpers.php) — added `Helpers::publicSellerProfile($user)`, the single source of truth for the public user shape (shared with the ad-details `seller` key, see §3).
- [`routes/api/v1/api.php`](routes/api/v1/api.php) — added `GET v1/users/{id}`.

---

## 3. Seller embedded in ad details — `GET /api/v1/ads/show/{ad}`

**Why.** Mobile wanted seller details inside ad-details so they don't
have to make a second round-trip per ad view. Same shape as §2 so a
single mobile renderer handles both.

**What changed.** Two things in the existing endpoint:

1. The `user` relation is now eager-loaded on the ad
   (`Ad::with(['category', 'brand', 'model', 'sponsor', 'user'])`), so
   `ad.user` is populated in the response.
2. A new top-level `seller` key is added containing the curated profile
   shape from §2 (with visibility flags applied). This is the same
   payload `GET /api/v1/users/{id}` returns under its `user` key.

**Response — additive, existing keys unchanged**

```json
{
  "ad": {
    "id": 123,
    ...,
    "user": { /* raw user row, eager-loaded */ }
  },
  "seller": {
    "id": 42,
    "name": "John Doe",
    "image": "1234.jpg",
    ...
  },
  "wishlist_status": false,
  "count_wishlist": 12,
  "related_ads": [...],
  "ad_promotional_video": null,
  "gallery_images_number": 5,
  "more_ads_from_user": [...],
  "paid_banners": [...],
  "ad_views_number": 87,
  "is_dimensions_and_sizes_empty": true,
  "is_environmental_information_empty": true,
  "is_battery_information_empty": true,
  "is_additional_information_empty": true
}
```

Mobile should prefer the top-level `seller` key — it respects the
seller's visibility flags. `ad.user` is the raw eager-loaded model and
exposes everything the user fillable allows; use it only if you
specifically need a field not in `seller`.

**Files**

- [`app/Http/Controllers/api/v1/AdController.php`](app/Http/Controllers/api/v1/AdController.php) — added `user` to `with()`, added `'seller'` to the response.

---

## 4. Translations API — `/api/v1/locale/translations/{locale}`

**Why.** Mobile dev reported translations appearing stale / inconsistent
with the web. The translation source of truth is the
`languages_translations` table; the web's `translate()` helper reads
through a per-locale cache key (`translations_{locale}`); the mobile
API was reading the same cache but returning no freshness signal, so
clients couldn't tell when their local copy was stale.

**Changes**

- Route now accepts both `GET` and `POST` (was `POST` only).
  Mobile can use whichever is convenient; web is unaffected.
- Response now includes a `version` string. It is the unix timestamp of
  the most recent `updated_at` in `languages_translations` for that
  locale. Mobile can store this alongside its cached translations and
  poll the lightweight version endpoint (below) instead of pulling the
  full payload every launch.
- Translations are returned as a JSON object (always), never as an
  array, so JS/Swift/Kotlin clients can index by key without runtime
  type checks even when the locale has no rows yet.
- A new endpoint
  `GET /api/v1/locale/translations/{locale}/version` returns just the
  version string — use it for cheap polling.

**Full translations response**

```http
GET /api/v1/locale/translations/en
```

```json
{
  "locale": "en",
  "version": "1715620912",
  "translations": {
    "login": "Login",
    "search": "Search",
    "sorry_this_product_not_shipped": "Sorry, this product is not shipped to your country"
  }
}
```

`X-Translations-Version` is also echoed as a response header for clients
that want to read it from headers rather than the body.

**Lightweight version-check response**

```http
GET /api/v1/locale/translations/en/version
```

```json
{
  "locale": "en",
  "version": "1715620912"
}
```

**Single source of truth.** Both web and mobile now read from the same
`languages_translations` table and the same `translations_{locale}`
cache key. When an admin edits a translation via the admin UI
(`/admin/business-settings/languages/translate-submit`), the cache is
flushed and the new value propagates to both clients on their next
read. Mobile sees the change as soon as it next hits
`/locale/translations/{locale}` or detects a version change via the
lightweight endpoint.

**Files**

- [`app/Http/Controllers/api/v1/LocaleController.php`](app/Http/Controllers/api/v1/LocaleController.php) — rewritten with version metadata + version-only endpoint.
- [`routes/api/v1/api.php`](routes/api/v1/api.php) — accepts GET as well as POST; added `/translations/{locale}/version`.

---

## Route diff summary

```diff
  Route::group(['prefix' => 'auth', 'namespace' => 'auth'], function () {
-     Route::any('social-login', 'SocialAuthController@social_login');
+     Route::post('social-login', 'SocialAuthController@social_login');
      Route::post('update-phone', 'SocialAuthController@update_phone');
  });

  Route::group(['prefix' => 'locale'], function() {
-     Route::post('translations/{locale}', 'LocaleController@translations');
+     Route::match(['get', 'post'], 'translations/{locale}', 'LocaleController@translations');
+     Route::get('translations/{locale}/version', 'LocaleController@version');
  });

+ Route::get('users/{id}', 'CustomerController@show');
```

## Backwards compatibility

| Endpoint | Breaking? | Notes |
|---|---|---|
| `POST /auth/social-login` | **Yes** for old payload shape | Old fields (`token`, `unique_id`, `email`, `medium`) are no longer accepted; the previous endpoint was unsafe and not used by any web flow (web uses session-based Socialite redirects). Mobile must use the new payload. |
| `GET/POST /locale/translations/{locale}` | No | Old POST shape still works; response now has an extra `version` field that old clients can ignore. |
| `GET /ads/show/{id}` | No | Existing keys unchanged; `ad.user` and `seller` are additive. |
| `GET /users/{id}` | New | New endpoint, nothing to break. |

## How to test

```bash
# Social login (mock — replace id_token with a real Google ID token)
curl -X POST https://eurobas.example/api/v1/auth/social-login \
  -H 'Content-Type: application/json' \
  -d '{"provider":"google","id_token":"<google id_token>"}'

# User by id
curl https://eurobas.example/api/v1/users/42

# Ad details (note seller key)
curl https://eurobas.example/api/v1/ads/show/123 | jq '.seller'

# Translations (full + version)
curl https://eurobas.example/api/v1/locale/translations/en | jq '.version, (.translations | length)'
curl https://eurobas.example/api/v1/locale/translations/en/version
```
