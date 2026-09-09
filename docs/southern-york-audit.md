# Southern York Motors — implementation audit

## Baseline (September 9, 2026)

- Branch: `southernyorkmotors`; clean working tree before work.
- PHP CLI 8.3.6, Node 24.13.0. Composer declares Laravel 13, Filament 5, Inertia 3, Intervention 4; frontend uses Vue 3, Tailwind 4, Vite 8.
- Public pages: Home, Inventory, Vehicle detail, Finance, Trade-In, About, Contact, Privacy Policy, Terms. Service, delivery and warranty URLs permanently redirect to Contact. Sitemap and robots have controllers.
- Vehicles remain database-backed. Inventory has 12-item pagination, make/model, year, price, mileage, body type, transmission, drivetrain and color filters, plus seven sorting choices. Public queries require active/available vehicles.
- Vehicle relationships and ordered photos are loaded on detail pages; HTML descriptions are sanitized. Related vehicles are restricted to available inventory. Preserve all records and files.
- Storage supports public image paths and uploaded `storage/vehicles` files with large/medium/thumb variants. Existing `public/storage` points to a sibling project's storage: inspect URL availability before changing this shared link.
- Four POST flows use Form Requests, dedicated lead services and database persistence: Contact, Finance, Trade-In, Vehicle inquiry. Notifications follow persistence; Meta uses the same event ID in the browser/server and checks marketing consent.
- Actual mail delivery is synchronous (`Mail::send`); the Mailable has Queueable but does not implement ShouldQueue. No application jobs/notifications or scheduled queue-dependent lead workflow found. Do not claim a queue migration or delivery verification.
- Existing forms disable submit while processing, but should also guard handlers. Validation feedback is incomplete for some optional trade-in fields. No application-specific captcha/honeypot/throttle found; Laravel CSRF remains in force.
- Google review records have no dealer ownership association; existing records must not become Southern York testimonials. Preserve integration and data, omit reviews from new public pages.
- Shared components: SiteLayout, SeoHead, VehicleCard, four form components, CookieConsentBanner, Reveal, FAQ, PageIntro, LegalPageLayout, LeadFormSection. Desktop/mobile filter markup is duplicated. Public pages heavily repeat giant dark photo banners and CTA sections.
- Existing main menu is a drawer at all widths. Inquiry traps focus; gallery and mobile filters need equivalent focus behavior and gallery swipe support.
- Existing cookie overlay blocks the whole page, stores a brand-specific localStorage choice, initializes Meta after opt-in. Keep consent gating while redesigning as a compact banner and optional preferences dialog.
- SEO uses Inertia Head, canonical domain shared props, OpenGraph/Twitter and JSON-LD. Sitemap/robots currently use request origin rather than canonical site configuration. Static robots can shadow the controller.
- Old marketing assets, red palette, DM Sans/Space Grotesk, old contacts and invented inherited opening hours must be retired. No new hours, ratings, social profiles, rates, warranty or approval guarantees.
- Swiper and PhotoSwipe dependencies exist but current public gallery is custom. Reuse existing capabilities where useful; no new frontend framework required.
- Baseline tests cover public page HTTP availability and retired redirects only. Add isolated SQLite tests for inventory visibility/filtering and all four persisted lead flows with mail/HTTP fakes.

## Design direction

Forest green, warm ivory, restrained brass; editorial typography, open desktop navigation, landscape-led split hero, airy vehicle cards, focused forms and distinct internal-page compositions. New vector road/initial mark and a coherent set of unique automotive campaign photographs. Marketing images never substitute for inventory images.

## Release checks

Build, isolated tests, route list, canonical/brand audit, actual local inventory image URLs, responsive browser QA and form UX. Real email delivery, live Meta and production credentials require deployment verification. Legal wording retains the existing template's meaning; dealership must review operational accuracy before release.
