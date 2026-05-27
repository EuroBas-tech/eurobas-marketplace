# Eurobas API — Parity Report (response to *website_api_parity.pdf*)

This report responds point-by-point to the feedback document. **Both critical
gaps (listing post/edit/delete and promotions/payments) are now closed**, along
with every other API item in §§3–6. The only outstanding work is the platform
credentials in §7, which only your account owners can issue.

Legend (same as your document): ✅ done · ⚠️ partial / needs your input · ❌ not done.

Everything below is covered by **106 automated tests** (`php artisan test`, all
passing), including ownership/security checks. To deploy, run `php artisan migrate`.

---

## 1. Summary — updated status

| Area | Was | Now | What changed |
|---|---|---|---|
| Auth, OTP, password reset | ✅ | ✅ | unchanged |
| Social login (endpoint) | ✅/⚠️ | ✅ | endpoint ready; Google/Facebook still need credentials (§7) |
| Browse / search / filter | ✅ | ✅ | + live result count, fixed by-category, home feed |
| Ad detail | ⚠️ | ✅ | now returns auction & asking-price offer lists; slug deep-link lookup added |
| **Post / edit / delete a listing** | ❌ CRITICAL | ✅ | full CRUD + create-options + per-category fields |
| **Promotions & payments** | ❌ CRITICAL | ✅ | packages, paid banners, sponsors, PayPal/Stripe initiate+verify, Mux |
| Offers (auction / asking-price) | ⚠️/❌ | ✅ | asking-price API added; auction now chat-coupled; offer deletes |
| Report ad | ❌ | ✅ | `POST v1/ads/report` |
| Chat / messaging | ⚠️ | ✅ | images, ad-context, unread count, mark-seen |
| Wishlist | ✅ | ✅ | + clear-all |
| Public seller profile | ⚠️ | ✅ | ads list, categories, brands, postal/street, reconciled count |
| Brands / vehicle-models browsing | ❌ | ✅ | per-category, uncapped |
| Support tickets | ⚠️ | ✅ | delete + attachments |
| Static pages | ⚠️ | ✅ | all 6 via `GET v1/pages/{slug}` |
| Config endpoint | ⚠️ | ✅ | profile/cover image URLs fixed; payment-gateway flags added |
| Profile / cover image upload | ❌ | ✅ | fixed (and fixed a related data-loss bug — see note) |
| Google Maps keys | ❌ | ⚠️ | needs your keys (§7) |
| Social login credentials (Google/FB) | ❌ | ⚠️ | needs your credentials (§7) |

---

## 3. CRITICAL #1 — Listing lifecycle ✅

| Endpoint | Purpose |
|---|---|
| `POST v1/ads` | Create a listing (multipart: thumbnail `image` + `images[]`, full field set) |
| `PUT`/`POST v1/ads/{id}` | Edit own listing (`old_images[]` keeps existing gallery images) |
| `DELETE v1/ads/{id}` | Delete own listing |
| `GET v1/ads/create-options?category_id=` | Form bootstrap: categories, brands, models, attribute fields, sponsor packages, image/video limits |
| `GET v1/categories/{id}/fields` | Per-category attribute definitions **and allowed values**, served from the backend |

Per your concern about field-coupling: the allowed values now come from the API
(built from your `List`/`ListValue` records), so you can change a category's
options server-side and they reach the app immediately — no app release needed.

## 4. CRITICAL #2 — Promotions & payments ✅

Payments are JSON, **session-free**, and EUR via PayPal + Stripe.

| Endpoint | Purpose |
|---|---|
| `GET v1/subscription-packages?type=` | Package catalogue (`type{id,name}`, price, duration, features) |
| `POST v1/customer/paid-banners` | Create paid banner (multipart) — returns a payment object when price > 0 |
| `POST v1/customer/sponsors` | Boost a listing (urgent / first-results / promotional-video) |
| `GET` + `DELETE v1/customer/{paid-banners,sponsors}` | Manage my promotions |
| `POST v1/payment/initiate` | `{model_type, model_id, method}` → `{checkout_url}` (open in webview) |
| `GET v1/payment/verify` | `{is_paid, payment_transaction_id}` |
| `POST v1/mux/create-upload`, `GET v1/mux/video` | Promotional-video upload → returns `video_id` |

`GET v1/config` now also returns `payment_gateways: { paypal, stripe }` so the app
knows which methods are enabled.

## 5. Offers & report ✅

- `POST v1/ads/auction` now **also writes the seller-facing chat message** (parity with the website), so sellers see bids in their inbox.
- `POST v1/ads/asking-price` — creates the offer row **+ chat message**.
- `DELETE v1/ads/auction/{id}`, `DELETE v1/ads/asking-price/{id}` — delete own offers.
- `POST v1/ads/report` — report an ad (can't report own / can't report twice).
- `GET v1/ads/show/{ad}` now includes `auctions[]` and `asking_price[]` offer lists.

## 6. Other parity gaps

- **6.1 Chat ✅** — image attachments, optional `ad_id` "about this ad" context (ad reference returned), `GET v1/customer/chat/unread-count`, per-row unread count + last-message preview, auto mark-seen on open + `POST v1/customer/chat/mark-seen`.
- **6.2 Public seller profile ✅** — `GET v1/users/{id}` now returns categories, brands, an ads preview, and (when permitted) postal/street; new `GET v1/users/{id}/ads`; `POST v1/ads/filter` now honours `profile_id`. `ads_count` reconciled — API and website now both count active ads.
- **6.3 Browse/discovery ✅** — `GET v1/home` (per-category sponsored-first rows + banners, ordered by category interest), `GET v1/ads/load-home-ads`, fixed `GET v1/ads/by-category/{id}` (active only, paginated, sponsor-ordered), `POST v1/ads/filter-count`, `GET v1/brands`, `GET v1/brands/{id}`, `GET v1/models/{id}/ads` (per-category, uncapped).
- **6.4 Smaller gaps ✅** — `DELETE v1/customer/wish-list/clear`; `DELETE v1/customer/support-ticket/{id}`; ticket create/reply accept `image[]` attachments.
- **6.5 Profile/cover upload ✅** — now accepts multipart `image` + `cover_image` files. **Also fixed a latent data-loss bug**: profile update previously overwrote every field, so a partial update from the app wiped the rest; it now only updates fields actually sent.
- **6.6 Config & static content ✅** — `customer_image_url` corrected and a separate `cover_image_url` added; `GET v1/pages/{slug}` serves all six pages (about-us, privacy-policy, terms-conditions, instructions-for-use, return-policy, cancellation-policy).
- **6.7 Translation keys ✅** — added `joined_today`, `joined_yesterday`, `joined_n_days_ago`, `joined_n_months_ago`, `joined_n_years_ago` (`:count`), `view_profile`.
- **6.8 Deep links ✅** — `GET v1/ads/show-by-slug/{slug}`.

---

## 7. Platform credentials — we need these from you ⚠️

These are not code; only your account owners can create them:

- **Google Sign-In** — OAuth client IDs (iOS `com.eurobas.app`; Android package + the 3 SHA-1s; Web client) in your existing Google Cloud project. Send the iOS + Web client IDs.
- **Facebook Login** — `FACEBOOK_APP_ID` + `FACEBOOK_CLIENT_TOKEN`; add iOS/Android platforms with the provided key hashes; enable Login (email, public_profile).
- **Google Maps API keys** — working, restricted iOS + Android keys (the app currently runs on the developer's personal keys; ownership/billing must move to Eurobas before release).

The social-login endpoint already verifies provider tokens server-side, so it
works the moment valid credentials are supplied.

---

## Listing / payment flow — now matches the website exactly

Per your confirmation, the publish flow mirrors the website:

- **Free option / no paid promotion** → the listing/package is **published immediately**.
- **Paid promotion/package selected** → the listing/package is **held unpublished**;
  the app is given a checkout URL (`payment/initiate`), and the listing/package is
  **published only after the payment succeeds** (`payment/verify` / the gateway
  callback publishes it — mirroring the website's `…Payment@executePayment`, which
  sets the ad to published on success). For multiple paid promotions on one listing,
  it publishes only once all are paid. This is covered by an automated test.

---

## Quality & deployment

- **106 automated tests** pass (`php artisan test`), covering CRUD, payments,
  offers, chat, profile, browse, and security/ownership (verified via mutation
  testing — the tests genuinely catch regressions). The pre-existing 51-test
  suite still passes.
- Deploy: `php artisan migrate` (adds `chattings.ad_id` and the new translation
  keys; both migrations are reversible).
- Developer-facing endpoint detail: see `WEBSITE_API_PARITY_CHANGES.md`.
