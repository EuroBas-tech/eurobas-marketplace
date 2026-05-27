# Eurobas API — Consistency & System Review Report

*Follow-up to the API Parity report. This addresses the question about whether
the API is fully aligned with the website — consistency, caching, performance,
and overall behaviour — and documents the review and hardening done since.*

**Bottom line:** Yes. The API mirrors the website's behaviour and structure
because it reuses the same database, models, and business logic. On top of that,
we ran a full review of the whole API layer (not just the parity items) and fixed
every real inconsistency we found. All of it is covered by **111 automated tests**
(all passing) and pushed to GitHub.

---

## 1. Listing & payment flow — now matches the website exactly

As requested:

- **Free option / no paid promotion** → the listing/package is **published immediately**.
- **Paid promotion/package** → the seller is sent to payment first, and the
  listing/package is **published only after the payment succeeds** (the same logic
  the website uses to publish on payment success). If a listing has more than one
  paid promotion, it publishes only once all are paid.

Covered by an automated test that creates a paid listing, confirms it stays
unpublished, then confirms it publishes after payment.

## 2. Privacy / visibility — important fix

During the review we found that the API was exposing a seller's **contact phone
and account details (email, phone, location) even when the seller had chosen to
hide them** in their settings. The website never shows these when hidden; the API
now behaves the same way:

- A seller's contact phone is only returned when they enabled "show phone".
- A seller's email/location are only returned when they enabled those options.
- The ad owner still sees their own details (e.g. when editing).

This was a genuine privacy improvement — the mobile app will now respect the
seller's visibility choices exactly like the website. Backed by dedicated tests.

## 3. Caching — consistent and self-correcting

The API uses the **same caching layer and keys** as the website (settings,
translations with version polling, catalogue data), so admin changes propagate to
both. We found two API caches that could have held old category/attribute data
indefinitely (the admin "clear cache" targets the website's keys, not these) and
set them to refresh automatically every few hours, so changes always reach the app
without manual steps. No conflicting or divergent cache behaviour remains.

## 4. Data consistency

"Popular categories" was counting **all** listings (including unpublished/expired);
it now counts only live listings, so the counts and ordering match what the app and
website actually display.

## 5. Performance

The endpoints follow the website's existing patterns — pagination, eager-loading of
related data to avoid extra queries, and the same aggregate queries the website
uses (e.g. the home feed). Performance characteristics match the website; we did not
introduce heavier code paths. We also noted a couple of **optional** future
optimisations (e.g. caching the home-feed payload) that apply equally to the website
— these are improvements, not fixes, and can be scheduled later.

## 6. Testing & quality

- **111 automated tests**, all passing — covering listings, payments, offers, chat,
  profiles, browsing, and security/privacy.
- We verified the tests genuinely catch problems (by deliberately re-introducing a
  bug and confirming a test fails), audited that every write/account endpoint
  requires authentication, and confirmed the database migrations are reversible.
- All code and reports are pushed to GitHub.

---

## What we still need from you (unchanged)

These are credentials only your account owners can issue — not code:

- **Google Sign-In** client IDs (iOS + Web) in your Google Cloud project.
- **Facebook Login** App ID + Client Token.
- **Google Maps** iOS + Android keys (the app currently runs on the developer's
  personal keys; ownership/billing should move to Eurobas before release).

The sign-in endpoint already verifies provider tokens, so it works as soon as valid
credentials are provided. (The Maps key will be shared with the mobile developer on
request, as agreed.)

---

## Optional future improvements (not blocking, for your awareness)

- Cache the home-feed response for a short window for extra speed at scale.
- Apply the same auto-refresh caching to the website's post-ad form catalogue data.
- Minor: filter home banners by language on the API (the app can also do this).

We're happy to schedule any of these, or walk the mobile developer through the
payment (`initiate` → `verify`) flow. For the full technical detail, the developer
references in the repo are `WEBSITE_API_PARITY_CHANGES.md` and `SYSTEM_REVIEW.md`.
