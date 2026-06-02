# EuroBas.com — Phase 3 Delivery Report

**Prepared for:** Hasan · Euro Market
**Prepared by:** Edgar
**Date:** 30 May 2026
**Scope delivered:** Milestone 1 (Mobile Login Fix + Dedicated Login Page), Milestone 2 (Messaging System Enhancements), Milestone 3 (Seller Profile & Ratings)
**Surfaces:** Website (theme `theme_aster`) **and** Mobile API (`/api/v1`)

---

## 1. Summary

All three milestones from the Phase 3 proposal are **complete on both the website and the mobile API**. Every deliverable was implemented, wired end-to-end, and tested.

| # | Milestone | Web | API | Admin | Status |
|---|-----------|-----|-----|-------|--------|
| 1 | Mobile Login Fix + Dedicated Login Page | ✅ | n/a* | — | Done |
| 2 | Messaging System Enhancements | ✅ | ✅ | ✅ | Done |
| 3 | Seller Profile & Ratings | ✅ | ✅ | — | Done |

\* The mobile app already uses a native Passport-token login screen (`/api/v1/auth/login`), which was unaffected by the popup/modal problem. No API auth change was required; it was reviewed and confirmed intact.

**Testing:** the full automated suite passes — **156 tests (123 pre-existing + 33 new)**, covering both the API and the website (session-guard) controllers, full-page render tests of the rewritten chat inbox and seller profile, the admin user-reports pages, the dedicated-login auth+redirect cycle, the seller rating on the actual ad-card partials (with a real ad), **real image uploads** (web + API), block enforcement on the send path, and the local-host reCAPTCHA bypass. New tables and behaviour were also verified directly against the live database, and the affected pages were smoke-tested over HTTP (home, dedicated login, seller profile, ad detail, ad listing) — all returning 200.

**Guiding principle honoured:** no existing functionality was modified or broken. Automated chat messages (auction offers / price negotiations) are untouched, all new UI strings flow through the existing `translate()` system, and the existing ad-review system was left intact (seller ratings use their own table).

---

## 2. Milestone 1 — Mobile Login Fix & Dedicated Login Page

### What was delivered
| # | Item | Result |
|---|------|--------|
| 1 | **Dedicated Login Page** | New standalone page at `/customer/auth/login`, built to mirror the existing registration page layout/style (same card, same field styling, social login, captcha). |
| 2 | **Redirect Behaviour** | The **Login** and **Post an Ad** buttons now navigate to the dedicated login page instead of opening the modal. "Post an Ad" carries a `redirect_to` so the user lands on the posting flow right after logging in. |
| 3 | **Popup Retained** | **Add to Favourites**, **Contact Seller**, messages, and similar quick actions still open the existing centered popup modal. |
| 4 | **Mobile Stability** | A dedicated stability layer fixes the flicker / disappearing-content issues for the retained popups across mobile viewports. |
| 5 | **Translations** | No text changed; all strings continue to use the translation system. |

### How it works
- `LoginController@login` now renders the dedicated page for `theme_aster` and records a safe post-login redirect target (`keep_return_url`), guarded against redirect loops back to auth pages.
- `LoginController@submit` honours an explicit `redirect_url` from the dedicated page, while the modal keeps its original "return to previous page" behaviour — so **both** paths work.
- **Mobile flicker fix** (`_modal-stability.blade.php`, included on every layout): removes orphaned/stacked Bootstrap modal backdrops, cleans up leftover `modal-open` body state, hardware-accelerates the dialog to stop repaint flicker, and prevents the keyboard-resize "jump" that made content disappear on iPhone/Android/tablet.

### Files
- New: `resources/themes/theme_aster/theme-views/customer-views/auth/login.blade.php`
- New: `resources/themes/theme_aster/theme-views/layouts/partials/modal/_modal-stability.blade.php`
- Changed: `app/Http/Controllers/Customer/Auth/LoginController.php`, `theme_aster/file_names.php`, `_header.blade.php`, and the four `*-app.blade.php` layouts.

### How to verify
1. Logged out, click **Login** (top bar) or **Post an Ad** → you land on the full-page login (not a popup).
2. Log in → you return to where you were (Post-an-Ad sends you to the posting screen).
3. On an ad, click **Contact Seller** or the **heart** (Add to Favourites) while logged out → the centered popup still appears, and it no longer flickers on mobile.

---

## 3. Milestone 2 — Messaging System Enhancements

### Core features
| # | Feature | Result |
|---|---------|--------|
| 1 | **Report User** | New `user_reports` table. Report form available from the chat header; reports appear in a new **Admin → User Reports** panel for review (with status: pending / reviewed / dismissed). |
| 2 | **Block User** | New `user_blocks` table. Blocked users cannot send messages and disappear from the chat list; a Block/Unblock toggle is in the chat header. |
| 3 | **Delete Message** | Per-user soft delete — the message disappears for the deleting user only; the other party still sees it. |
| 4 | **Delete Conversation** | Batch soft delete of a whole thread for the current user only. |
| 5 | **Send Images** | Image attach button in the chat input, with preview-before-send; stored via the existing attachment column (`chatting/` storage, JSON array). |

### Message status
| Status | Implementation |
|--------|----------------|
| **Sent** | Single grey check — message saved. |
| **Delivered** | Double grey check — new `delivered_at` set when the recipient loads their chat list. |
| **Seen** | Blue double check — existing `seen` flag upgraded with a `seen_at` timestamp, set when the recipient opens the conversation. |

### UI / UX
- Sender messages are right-aligned in a coloured bubble; receiver messages are left-aligned in a neutral bubble.
- Bubbles capped at ~70% width (85% on small phones) with proper spacing.
- Timestamps **grouped by day** (Today / Yesterday / date separators).
- Status check icons render beside each of your own messages.
- Fully mobile-responsive layout.

### Preserved
- **Automated messages are completely untouched** — the auction-offer and asking-price message logic in `messages_store` / the API was not modified. (Verified by the existing parity tests, which still pass.)
- All new UI text uses the translation system.

### API (mobile) — new endpoints
All under `/api/v1/customer/chat` (Passport auth):
- `POST report` · `POST block` · `POST unblock` · `GET blocked-list`
- `POST delete-message` · `POST delete-conversation`
- `GET list` and `GET get-messages/{id}` now return per-message `message_status` (sent/delivered/seen), set `delivered_at`/`seen_at`, hide blocked conversations and per-user-deleted messages.
- `POST send-message` now rejects messages between blocked users (HTTP 403).

### Admin panel
- New **Admin → User Reports** section (sidebar entry with a "pending" indicator), with list, detail view, status update, and delete.

### Files
- New: migrations `…_create_user_reports_table`, `…_create_user_blocks_table`, `…_add_status_columns_to_chattings_table`; models `UserReport`, `UserBlock`; `Admin/UserReportController`; admin views `admin-views/user-report/{list,view}.blade.php`.
- Changed: `Chatting` model (status casts + `visibleTo` scope), `Web/ChattingController` (report/block/delete + status logic), `api/v1/ChatController`, `app/User.php` (relationships + cascade cleanup), `routes/web.php`, `routes/admin.php`, `routes/api/v1/api.php`, chat UI `users-profile/user-inbox.blade.php`, admin sidebar.

---

## 4. Milestone 3 — Seller Profile & Ratings

> In EuroBas a "seller" is the user who posts an ad, so block/report reuse the **same** user-to-user system built in Milestone 2.

| # | Feature | Result |
|---|---------|--------|
| 1 | **Contact Seller** | A prominent **Contact Seller** action sits in a dedicated toolbar on the seller's profile; it reuses the existing message flow (no logic change) and opens the conversation. |
| 2 | **Block Seller** | Block/Unblock button on the profile, using the Milestone 2 `user_blocks` system. |
| 3 | **Report Seller** | Report button on the profile, using the Milestone 2 `user_reports` system (tagged `type = seller`). |
| 4 | **Seller Rating System** | Customers leave a 1–5 star rating + written review (one per seller, editable). Average rating + review count + star visuals shown on the profile, with a reviews list. |
| 5 | **Ratings on Ad Listings** | Seller name + average rating + review count shown under the seller's name on the ad cards used across the listing pages — the main grid card (home, category, recommended, featured, top-rated, related, shop) and the ad-view / profile-ads listing card. Shown only when the seller has reviews. |

### Audit note (existing Review model)
The existing `reviews` table is **ad-scoped** (`ad_id`) and powers ad reviews. To avoid breaking it, seller ratings use a dedicated, indexed `seller_reviews` table (one review per customer per seller, enforced by a unique key). This delivers a clean, working seller-rating system without disturbing ad reviews.

### API (mobile)
- `GET /api/v1/users/{id}/reviews` — public seller reviews + summary.
- `POST /api/v1/customer/seller-review` — submit/update a rating (auth).
- `GET /api/v1/users/{id}` (seller profile) now includes `seller_rating_avg` and `seller_reviews_count`.

### Performance
Per-card rating lookups are memoised per request (`SellerReview::summaryFor`), and the table is indexed on `seller_id`, so listing pages stay fast.

### Files
- New: migration `…_create_seller_reviews_table`; model `SellerReview`; `Web/SellerReviewController`; `api/v1/SellerReviewController`; partial `_seller-rating-inline.blade.php`.
- Changed: `UserProfileController@show_profile`, `users-profile/user-profile-show.blade.php` (toolbar, rating, modals, reviews list), `_product-large-card.blade.php`, `app/User.php` (rating accessors), `app/CPU/helpers.php` (`publicSellerProfile`), `routes/web.php`, `routes/api/v1/api.php`.

---

## 5. Testing

- **Automated:** `php artisan test` → **156 passed** (123 existing + 33 new).
  - `tests/Feature/Api/MessagingAndSellerRatingTest.php` (8) — API: block prevents send, blocked users hidden from list, report stored, per-user message delete visibility, status progression sent→delivered→seen, seller review create/summary/upsert/self-review guard.
  - `tests/Feature/Web/MessagingSellerProfileWebTest.php` (8) — website: the rewritten **chat inbox** and **seller profile** pages render end-to-end with real data (bubbles, status icons, day grouping, reviews list), blocked partners and soft-deleted messages are hidden, and every web POST endpoint (block/unblock/report/delete/seller-review) works.
  - `tests/Feature/Web/Phase3ExtraTest.php` (6) — the **dedicated login** page authenticates and honours `redirect_url`, the GET login page records a safe redirect target, the **ad-card seller rating** partial renders (and is empty without reviews), and the **admin user-reports** pages render + status-update/delete work.
  - `tests/Feature/ChatImagesAndApiSurfaceTest.php` (7) — **real image uploads** stored + returned (web `discussion_store` and API `send-message`), the web send path is blocked between blocked users, and the remaining API surface (`get-messages` response shape, `blocked-list`, `delete-conversation`, self-block/self-report guards).
  - `tests/Feature/Web/AdCardSellerRatingTest.php` (3) — the actual **ad-card partials** (main grid card + ad-view/profile listing card) render the seller name + star rating + review count for a real ad whose seller has reviews, and render no rating block when the seller has none.
- **Compiled-view lint:** every created/edited Blade view was compiled and its generated PHP linted, guaranteeing no render-time parse errors.
- **Database:** new tables and `chattings` columns confirmed present; block (both directions), soft-delete visibility, report, and rating summaries verified against live data.
- **HTTP smoke tests (live site):** home, dedicated login, seller profile, ad detail, ad listing — all return **200**.
- **No regressions:** the cross-surface Web↔API parity tests (chat shape, offer rows, seller counts) still pass.

---

## 5b. Local testing (how to try every feature)

**1. Seed the test data** (idempotent — safe to re-run):

```
php artisan db:seed --class=Database\\Seeders\\Phase3TestDataSeeder
```

This creates three accounts (password for all: **`password`**) plus two seller ads, a seed chat conversation, and seller reviews:

| Login | Role |
|-------|------|
| `buyer@eurobas.test`  | Log in as this to test everything |
| `seller@eurobas.test` | A seller to contact / block / report / rate (has 2 ads + reviews) |
| `rater@eurobas.test`  | Has already left the seller a review |

**2. reCAPTCHA is automatically disabled on any `.test` host** (e.g. `eurobas.test`) across **every** auth/captcha surface — customer login page + popup, register pages (individual & company) + popup, **admin login**, seller login + registration, and the contact form. This covers the visible widget, the Google `api.js` loader, the JS validation, the fallback (gregwar) captcha, **and** the server-side validation in all five controllers — so nothing challenges you locally (you can even sign into the admin panel to review user reports). On real domains reCAPTCHA stays on exactly as before, including its fallback. (Controlled by `recaptcha_enabled()` / `is_local_test_host()` in `app/CPU/theme-helpers.php`.)

> **Important for local HTTP:** the project ships with `SESSION_SECURE_COOKIE` defaulting to `true`, which makes the session cookie HTTPS-only — over plain `http://...test` the browser drops it and every POST fails with **419 (CSRF)**. For local dev over HTTP, set `SESSION_SECURE_COOKIE=false` in `.env` (already set in this environment) and run `php artisan config:clear`. Keep it `true` (the default) in production over HTTPS.

**3. What to try once logged in as the buyer:**
- **M1** — click *Login* / *Post an Ad* (they open the dedicated page); click the heart / *Contact Seller* (these keep the popup).
- **M2** — open *Messages*: you'll see the seeded conversation with delivered/seen ticks; try the 3-dot menu (Report / Block / Delete conversation), the per-message delete, the image attach button, and send a message.
- **M3** — open the seller profile (`/show-profile/<seller id>/Test Seller`): use *Contact Seller*, *Rate Seller* (★1–5 + review), *Block*, *Report*; the average rating shows in the header and on the seller's ad cards.

## 6. Deployment notes

1. **Run migrations.** Four new, fully idempotent migrations are included:
   - `2026_05_30_100001_create_user_reports_table`
   - `2026_05_30_100002_create_user_blocks_table`
   - `2026_05_30_100003_add_status_columns_to_chattings_table`
   - `2026_05_30_100004_create_seller_reviews_table`

   ```
   php artisan migrate --force
   ```
   > **Heads-up (environment-specific):** on a database that was loaded from a SQL dump rather than built up through migrations, a few **older, unrelated** migrations may still show as "pending" while their columns already exist, which can stop `migrate` early. This pre-dates Phase 3. The four new migrations above each guard with `hasTable`/`hasColumn` and can be applied individually if needed, e.g.
   > `php artisan migrate --path=database/migrations/2026_05_30_100001_create_user_reports_table.php --force`

2. **Clear caches** after deploy:
   ```
   php artisan config:clear && php artisan route:clear && php artisan view:clear
   ```

3. **Storage:** chat images use the existing `chatting/` storage path — no new disk/config needed.

---

## 7. New API endpoint reference (mobile)

```
# Messaging (auth: Bearer token)
POST   /api/v1/customer/chat/report                 { reported_id, reason?, message?, chatting_id? }
POST   /api/v1/customer/chat/block                   { blocked_id }
POST   /api/v1/customer/chat/unblock                 { blocked_id }
GET    /api/v1/customer/chat/blocked-list
POST   /api/v1/customer/chat/delete-message          { message_id }
POST   /api/v1/customer/chat/delete-conversation     { user_id }
# (existing list / get-messages / send-message now carry message_status + status timestamps)

# Seller ratings
GET    /api/v1/users/{id}/reviews                    (public)
POST   /api/v1/customer/seller-review                { seller_id, rating(1-5), comment? }   (auth)
GET    /api/v1/users/{id}                            -> now includes seller_rating_avg, seller_reviews_count
```

---

## 8. Known limitations (out of Phase-3 scope)

- **Site-wide mobile horizontal overflow.** On narrow phone widths the existing theme has a slight horizontal overflow (the header/search bar and listing cards extend past the viewport). This is **pre-existing and theme-wide** — it shows on every page including the home page — and is squarely the **Milestone 4 (Full UI/UX Redesign — mobile-first layouts)** work, not Milestone 1–3. The Phase-3 mobile deliverable (Milestone 1 #4) was the login **popup flicker/disappearing** fix, which is done; and all new Phase-3 UI (chat bubbles, seller-profile toolbar, ratings) renders correctly *within* the existing layout. Recommend addressing the global responsive layout as part of Milestone 4.
- **Vendor seller-login popup** still shows reCAPTCHA on the seller-registration page (a separate vendor-portal flow, unrelated to the customer features delivered here).
- **Chat messages render their stored HTML as-is**, by design, so the existing automated auction/price-negotiation messages (which contain HTML) keep rendering unchanged.

---

*EuroBas.com — Phase 3 Delivery — Prepared by Edgar — 30 May 2026*
