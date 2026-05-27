# Website ↔ API Parity — Implementation

Actions the client's `website_api_parity.pdf` asked for. Everything in §§3–6 is
implemented; §7 is credentials only the account owners can issue (see the bottom).

All new authenticated routes use `auth:api` (Laravel Passport bearer tokens),
exactly like the existing API. Multipart endpoints accept `multipart/form-data`.

---

## §3 — Listing lifecycle (create / edit / delete)

`app/Http/Controllers/api/v1/AdController.php`

| Method | Route | Notes |
|---|---|---|
| `POST` | `v1/ads` | Create. Multipart: `image` (thumbnail) + `images[]` (gallery) as files, plus the full `store()` field set. Optional sponsor packages (`urgent_sale_sticker_sponsor`, `appear_on_first_results_sponsor`, `promotional_video_sponsor`). |
| `PUT`/`POST` | `v1/ads/{id}` | Update, owner-scoped. Accepts `old_images[]` to retain existing gallery images, plus new `images[]`/`image`. |
| `DELETE` | `v1/ads/{id}` | Delete, owner-scoped. Cleans up thumbnail + gallery files. |
| `GET` | `v1/ads/create-options?category_id=` | Form bootstrap — categories (filtered by `category_type`), brands (+category ids), vehicle models (+category ids), attribute `fields`, active sponsor packages, image/video limits. |
| `GET` | `v1/categories/{id}/fields` | Per-category attribute field definitions + allowed values, built from `ListAttribute`/`ListValue`. Values are now backend-driven, so the app no longer needs to hard-code them. |

**Create response** — `{ success, with_payment, message, ad, payment[] }`. When a
paid sponsor package is attached, the `SponsoredAd` rows are created **unpaid** and
returned in `payment[]` (`{ model_type:"sponsor", model_id, price, type }`) for the
app to push through `POST v1/payment/initiate` (§4). Free packages activate
immediately. Mirrors `Web\AdController@store/@update/@delete`.

**Publish timing (website parity).** Free / no-promotion listings are published
immediately (`status=1`). A listing created with a **paid** promotion stays
unpublished (`status=0`) and is published only when the payment succeeds —
`PaymentController` does this in `verify`/`callback`, mirroring
`Multiple*Payment@executePayment` (`$models[0]->ad->status = 1`). Multi-promotion
listings publish only once every paid promotion is settled.

> Note on per-category fields: the website decides *which* attribute groups apply
> from the category's `category_type` (presentation logic); the *allowed values*
> now come from the API so they can change server-side without an app release.

---

## §4 — Promotions & payments

`PromotionController`, `PaymentController`, `MuxController`,
`app/Services/{PaypalPayment,StripePayment}.php` (now accept optional
return/cancel URLs — backward compatible with the web flow).

| Method | Route | Notes |
|---|---|---|
| `GET` | `v1/subscription-packages?type=…` | Catalogue: `id, type{id,name}, price (EUR), duration_in_days, is_free, status, features[]`. |
| `POST` | `v1/customer/paid-banners` | Multipart `banner_image`, `category_id`, `package_id`, `redirect_to_ads`, `ad_id`. Returns banner + `payment` when price > 0. |
| `GET`/`DELETE` | `v1/customer/paid-banners` , `…/{id}` | Manage my banners. |
| `POST` | `v1/customer/sponsors` | `ad_id`, `type`, `package_id`, `video_id` (promotional_video only). Returns sponsor + `payment`. |
| `GET`/`DELETE` | `v1/customer/sponsors` , `…/{id}` | Manage my sponsors. |
| `POST` | `v1/payment/initiate` | `{ model_type: paid_banner\|sponsor, model_id, method: paypal\|stripe }` → `{ checkout_url }`. **Self-contained — no web session.** |
| `GET` | `v1/payment/callback/{method}` | Stateless gateway redirect target; verifies and marks paid. (public) |
| `GET` | `v1/payment/verify` | `{ model_type, model_id }` → `{ is_paid, payment_transaction_id }`. Also finalizes if the app captured the redirect itself (pass `method` + gateway params). |
| `POST` | `v1/mux/create-upload` | Returns `{ url, upload_id }` for the direct upload (free). |
| `GET` | `v1/mux/video?upload_id=` | Polls Mux; once ready persists a `SponsorVideo` and returns `{ video_id, video_url }` to pass into the sponsor create call. |

`/config` now returns a `payment_gateways` flag: `{ paypal: bool, stripe: bool }`
(based on `addon_settings.is_active`).

---

## §5 — Offers & report

`AdController`

| Method | Route | Notes |
|---|---|---|
| `POST` | `v1/ads/auction` | Existing — now **also writes the seller-facing chat message** (parity with the web `messages_store`), so the seller sees the bid in their inbox. |
| `DELETE` | `v1/ads/auction/{id}` | Delete own auction bid. |
| `POST` | `v1/ads/asking-price` | `{ ad_id, price }` → creates the `AdAskingPrice` row **+ the chat message**. |
| `DELETE` | `v1/ads/asking-price/{id}` | Delete own asking-price offer. |
| `POST` | `v1/ads/report` | `{ id, message }`. Can't report own ad / can't report twice. |

`GET v1/ads/show/{ad}` now includes `auctions[]` and `asking_price[]` offer lists
(`id, user_id, name, image, price, created_at`) so the detail page's offer panels
render. (Chat-coupling fix: `AdAuction`/`AdAskingPrice` are written with
`new + save`, since those models are fully guarded.)

---

## §6 — Other parity gaps

**6.1 Chat** (`ChatController`, migration adds `chattings.ad_id`):
`send-message` accepts `image[]` (multipart) and an optional `ad_id` context;
`get-messages/{id}` auto-marks-seen, returns `attachment_images` + the `ad`
reference (`id, slug, title, thumbnail`); `chat/list` rows carry
`unseen_message_count` + `last_message`/`last_message_time`; new
`GET v1/customer/chat/unread-count` and `POST v1/customer/chat/mark-seen`.

**6.2 Public seller profile** (`CustomerController@show`, `Helpers::publicSellerProfile`):
`GET v1/users/{id}` now returns `categories[]`, `brands[]`, an `ads[]` preview and
gated `postal_code`/`street_address`. New `GET v1/users/{id}/ads` (paginated), and
`POST v1/ads/filter` now honours `profile_id`/`user_id`. `ads_count` reconciled —
both the API and the website profile now count **active** ads.

**6.3 Browse/discovery** (`AdController`, `BrandController`):
`GET v1/home` (per-category sponsored-first rows + home banners, ordered by
`UserCategoryInterest`); `GET v1/ads/load-home-ads` (load-more);
`GET v1/ads/by-category/{id}` fixed (active filter, pagination, sponsor ordering);
`POST v1/ads/filter-count`; `GET v1/brands`, `GET v1/brands/{id}`,
`GET v1/models/{id}/ads` (per-category, uncapped, `?with_models=1` for the
cascading dataset).

**6.4 Smaller gaps** (`CustomerController`): `DELETE v1/customer/wish-list/clear`;
`DELETE v1/customer/support-ticket/{id}`; support-ticket `create`/`reply` now
accept `image[]` attachments.

**6.6 Config & static content** (`ConfigController`, `PageController`):
`base_urls.customer_image_url` fixed (`cloudfront('profile/images')`) and a new
`cover_image_url` (`cloudfront('profile/covers')`), plus `ad_*`/`chat`/`paid_banner`
image base URLs. New `GET v1/pages/{slug}` covering all six pages (about-us,
privacy-policy, terms-conditions, instructions-for-use, return-policy,
cancellation-policy) → `{ title, content }`.

**6.5 Profile / cover image upload** (`UpdateProfileRequest`, `CustomerController@update_profile`):
`image` and `cover_image` are now validated as **files** and stored to
`profile/images/` and `profile/covers/` (was validated as a string and dropped).
Also fixed a latent data-loss bug: `update_profile` previously overwrote *every*
profile field from the request, so a partial update from the app wiped the fields
it didn't send. It now only updates fields actually present in the request
(`name`/`email` remain required by the form request).

**6.7 Translation keys** (migration `…_add_parity_translation_keys`):
seeds `joined_today`, `joined_yesterday`, `joined_n_days_ago`,
`joined_n_months_ago`, `joined_n_years_ago` (`:count` placeholder) and
`view_profile` for `en`.

**6.8 Deep links** (`AdController@show_by_slug`):
`GET v1/ads/show-by-slug/{slug}`.

---

## Deploy notes

```bash
php artisan migrate          # chattings.ad_id + parity translation keys
```

The translations migration busts the `en` file-cache key; if you keep translations
warm elsewhere, also run your usual translation cache flush so the new keys serve.

---

## §7 — Platform credentials (NOT code — cannot be actioned here)

These require access to the EuroBas Google Cloud / Facebook / Google Maps accounts
and must be issued by the account owners, then handed to the mobile team:

- **Google Sign-In** — OAuth client IDs (iOS bundle `com.eurobas.app`, Android
  package + the three SHA-1s, Web client) in the existing Google Cloud project.
- **Facebook Login** — `FACEBOOK_APP_ID` + `FACEBOOK_CLIENT_TOKEN`; add iOS/Android
  platforms with the provided key hashes; enable Login (email, public_profile).
- **Google Maps API keys** — working, correctly-restricted iOS + Android keys
  (the app is currently on the developer's personal keys; billing/ownership must
  move to EuroBas before release).

The social-login *endpoint* already verifies provider tokens server-side
(`SocialAuthController`), so it works the moment valid credentials are supplied.
