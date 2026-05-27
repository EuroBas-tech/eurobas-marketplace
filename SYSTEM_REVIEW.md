# API System Review — beyond the parity document

A full audit of the `api/v1` layer for web↔API behavioural divergence, caching,
performance, security, and correctness (the concerns Hasan raised). Below is what
was found, what was fixed, and what is recommended/deferred (with reasons).

All changes are covered by the test suite (`php artisan test` — 111 passing).

---

## Fixed

### 1. Seller PII leak on public ad endpoints (security — highest priority)
Public ad responses serialized the **raw seller `user` relation** (email, phone,
country/city, postal/street, lat/long, `cm_firebase_token`, `social_id`) and the
ad's own `contact_phone_number`/`phone_code` — **ignoring the seller's visibility
flags**. The website only renders these behind `show_phone_number` /
`show_email_address` / `show_location_data` in Blade, so this was an API-only leak
on unauthenticated endpoints (`ads/show`, `ads/by-category`, `ads/filter`,
`users/{id}/ads`, `models/{id}/ads`).

- `GET ads/show/{ad}` now builds the redacted `seller` (via `publicSellerProfile`)
  and **drops the raw `user` relation** from the `ad` payload.
- List endpoints constrain the `user` eager-load to `id, name, image` (the seller
  card data) instead of the full record.
- `Ad::toArray()` now redacts `contact_phone_number`/`phone_code` for non-owners
  when `show_phone_number = 0`; the ad's owner still sees their own contact info.

(Tests: `test_public_ad_show_does_not_leak_seller_pii`, `test_owner_sees_own_contact_phone`,
`test_filter_does_not_leak_seller_contact_fields`.)

### 2. `popular_categories` counted inactive ads
`Category::withCount('ads')` counted **all** ads (any status), so the "popular"
ordering and counts diverged from what's actually visible. Now counts only
`status = 1` ads and orders by that.

### 3. Indefinite caches could serve stale data (caching consistency)
The API's `api_home_categories` and `api_list_values_grouped` were
`rememberForever`. Admin cache-clears target the **website's** keys
(`categories`, `home_categories`, `brands`, …), not these, so a category/attribute
change would never reach the app. Both are now bounded to a **6-hour TTL** so they
self-heal without depending on admin hooks. (The website's own `adding_brands` /
`adding_models` / `list_values` forever-caches have the same latent staleness —
see recommendations.)

---

## Recommended / deferred (not changed — to avoid scope creep or changing
## pre-existing website behaviour; flagged for a decision)

- **Home-feed query cost.** `GET v1/home` eager-loads every active ad per category
  then trims to 20 in PHP — a faithful port of the website's `HomeController@index`,
  which is itself heavy. Recommend caching the `/home` payload (short TTL) or
  applying a per-category DB limit (`staudenmeir/eloquent-eager-limit`). No
  behavioural change, purely performance.
- **Sponsor flags on every ad row.** `home()` appends `has_first_results` /
  `has_urgent_sale_sticker`; other ad lists don't. The app can already derive these
  from the `sponsor[]` array each ad carries, so this is cosmetic — recommend a
  single `Ad` accessor (guarded by `relationLoaded('sponsor')`) if uniform flags
  are wanted.
- **Website catalogue caches.** `adding_brands` / `adding_models` / `list_values`
  (used by the website's post-ad form) are `rememberForever` and only cleared by a
  full `Cache::flush()` on language switch. Recommend adding targeted
  `Cache::forget()` in `Admin\BrandController` / `ModelController` /
  `ListController` / `AttributeController` on save. This is a website concern (not
  API), so left untouched here.
- **Banner locale.** `GET v1/banners` returns all published banners of a type; the
  website picks by locale (`lang == current ?? 'Both'`). Minor; the app can filter.
- **`ChatController@list`** loads full chat history to dedupe partners in PHP, with
  a per-conversation unread count query. Fine for now; revisit if chat volume grows.
- **`CategoryController@get_products`** is dead/legacy (queries the old `Product`
  model, not routed). Recommend deleting.

---

## Confirmed correct (not bugs)
- Price filtering uses parameterised bindings (safer than the website's `whereRaw`).
- `get_ads_by_category` adds active-filter + pagination + sponsored-first ordering
  the website page lacks — an improvement.
- Offer/auction/asking-price flows mirror the website guards and add the
  chat-coupled message for parity.
- Listing publish timing matches the website exactly (free → immediate; paid →
  only after payment).
- Static-page slugs use the same BusinessSetting `type` keys as the website.
- All mutating/customer endpoints are behind `auth:api`; only intentional
  endpoints are public.
