# Auto Dealer Website — Agent Instructions

## Purpose

This repository is a reusable production base for auto dealership websites.

Each dealership must be developed in its own Git branch. In those branches, agents adapt the shared project to a new company: branding, layout, page content, company data, SEO, images, colors, and dealership-specific functionality.

The shared vehicle catalog, lead flow, admin panel, storage, integrations, and backend conventions should remain reusable unless the task explicitly requires changing them.

Do not treat a new dealership as a new application. Reuse the existing architecture and replace only what the company requires.

## Primary Goals

1. Preserve the reusable dealership platform.
2. Produce a visually distinct, professional website for each company.
3. Keep company-specific data centralized and configurable.
4. Avoid regressions in inventory, leads, admin, images, email, SEO, and analytics.
5. Make focused changes and conserve context and tokens.

## Technology Stack

- PHP 8.3 or newer; production currently uses PHP 8.5.
- Laravel 13.
- PostgreSQL in production.
- SQLite may be used locally or in automated tests when already configured.
- Filament 5 for the administration panel.
- Inertia.js 3 with Vue 3 for the public frontend.
- Tailwind CSS 4.
- Vite 8.
- Resend for transactional lead emails.
- Intervention Image for vehicle image processing.
- PhotoSwipe and Swiper for vehicle galleries and sliders.
- Laravel database queues, cache, and sessions in production.
- PHPUnit 12 for automated tests.
- Laravel Pint for PHP formatting.
- Nginx and PHP-FPM in production.

Do not introduce another frontend framework, CSS framework, admin system, ORM, or state-management library without an explicit requirement.

## Project Structure

```text
app/
├── Console/
│   └── Commands/              Artisan commands and import/maintenance tasks
├── Filament/
│   └── Resources/             Admin resources, forms, tables, and pages
│       ├── Leads/
│       ├── VehicleMakes/
│       ├── VehicleModels/
│       └── Vehicles/
├── Http/
│   ├── Controllers/           Public Inertia controllers and form endpoints
│   ├── Middleware/
│   └── Requests/
│       └── Lead/              Lead form validation requests
├── Mail/                      Transactional mail classes
├── Models/                    Eloquent models
├── Providers/                 Laravel and Filament providers
├── Services/
│   ├── Google/                Google reviews and related integrations
│   ├── Lead/                  Lead handling and notifications
│   └── Meta/                  Meta Pixel/CAPI integration
└── Support/                   Shared enums and small domain helpers

config/
├── site.php                   Dealership identity and public company data
├── lead.php                   Lead notification configuration
└── *.php                      Laravel and integration configuration

database/
├── factories/
├── imports/                   Vehicle import source data
├── migrations/
└── seeders/

resources/
├── css/
│   └── app.css                Global styles, tokens, and Tailwind setup
├── js/
│   ├── Components/            Shared public components
│   ├── Layouts/
│   │   └── SiteLayout.vue     Main public layout, header, footer, navigation
│   ├── Pages/
│   │   ├── Inventory/
│   │   │   ├── Index.vue      Inventory listing
│   │   │   └── Show.vue       Vehicle details
│   │   ├── Home.vue
│   │   ├── About.vue
│   │   ├── Contact.vue
│   │   ├── Delivery.vue
│   │   ├── Finance.vue
│   │   ├── PrivacyPolicy.vue
│   │   ├── Service.vue
│   │   ├── Terms.vue
│   │   ├── TradeIn.vue
│   │   └── WarrantyReturn.vue
│   └── app.js
└── views/
    ├── app.blade.php          Inertia root view
    ├── emails/                Lead notification templates
    └── sitemap.blade.php

public/
├── build/                     Generated Vite assets; do not edit manually
├── images/                    Public branding and static page images
└── storage -> ../storage/app/public

routes/
├── web.php                    Public pages, forms, sitemap, and related routes
└── console.php

storage/app/public/            Uploaded vehicle images and public generated files
tests/
├── Feature/
└── Unit/
```

Before assuming a path or class exists, locate it with `rg --files` or `rg`.

## Branch and Dealership Model

- One dealership equals one dedicated Git branch.
- Never edit another dealership branch while implementing the current company.
- Confirm the current branch before making changes:

```bash
git branch --show-current
git status --short
```

- Preserve unrelated user changes already present in the working tree.
- Do not reset, discard, overwrite, or reformat unrelated changes.
- Do not merge company-specific branding back into the reusable base unless explicitly requested.
- Do not copy old company names, addresses, phones, emails, domains, analytics IDs, legal jurisdiction, images, testimonials, or SEO text into a new branch.

## Dealership Adaptation Workflow

For a new company, first identify:

- legal and display company name;
- domain and canonical URL;
- phone and telephone URI;
- email;
- address and map/place identifier;
- working hours;
- logo, favicon, and brand assets;
- primary, secondary, background, text, and accent colors;
- company positioning and available services;
- inventory source;
- lead recipient;
- social links;
- SEO title and description;
- financing, trade-in, delivery, warranty, returns, and service policies;
- state and legal jurisdiction;
- analytics, Google, and Meta settings.

Keep reusable company data in `config/site.php` and environment variables. A Vue page should not repeat company details that are already available through shared Inertia props.

When adapting the template:

1. Inspect `config/site.php`, `SiteLayout.vue`, `app.css`, routes, controllers, and the affected pages.
2. Establish the new visual system before editing every page independently.
3. Update the shared layout and reusable components first.
4. Adapt public pages to the new design.
5. Verify inventory listing and vehicle details with real dynamic data.
6. Verify every form and lead type.
7. Update SEO, sitemap, legal pages, icons, and public images.
8. Build assets and run the relevant tests.

## Reusable Core vs. Company-Specific Layer

Normally reusable:

- Eloquent models and database relationships;
- vehicle, make, model, image, user, review, and lead tables;
- Filament resources;
- vehicle image processing;
- inventory filters and pagination;
- lead validation and persistence;
- email dispatch flow;
- queue infrastructure;
- Google reviews service;
- Meta browser/CAPI event flow;
- shared SEO component;
- storage layout;
- migrations and deployment mechanics.

Normally company-specific:

- `config/site.php` values and matching `.env.carsforlessct` settings;
- colors and design tokens;
- logo, favicon, and imagery;
- navigation labels and page composition;
- company copy;
- home, about, finance, service, delivery, warranty, trade-in, contact, legal, and footer content;
- page-level SEO;
- maps and review identifiers;
- email recipient and sender display name;
- Meta Pixel ID and related environment configuration.

Do not change the reusable core solely because a page can be implemented faster with hardcoded data.

## Frontend Rules

- Use Vue 3 Composition API and `<script setup>`.
- Use Inertia `Link`, `Head`, forms, visits, and shared props where appropriate.
- Reuse `SiteLayout.vue`, `SeoHead.vue`, and shared components.
- Prefer Tailwind utilities and the existing CSS tokens.
- Keep repeated brand colors in CSS variables or shared utilities instead of scattering raw values across all pages.
- Do not add inline styles unless a value is genuinely dynamic.
- Do not manipulate the DOM directly when Vue state can express the behavior.
- Do not create static copies of dynamic inventory or vehicle pages.
- Preserve responsive behavior from mobile through large desktop widths.
- Maintain keyboard navigation, focus states, semantic headings, labels, alt text, and sufficient contrast.
- Use real links for navigation and telephone/email links.
- Prevent layout shifts by supplying image dimensions or stable aspect ratios.
- Use WebP or another existing optimized format for large website imagery when practical.
- Never modify `public/build` manually; it is generated by Vite.

The new dealership website should be visually distinct. Do not merely replace the logo and colors while leaving every composition identical when the task asks for a new template.

## Backend Rules

- Use strict, typed PHP where consistent with nearby code.
- Follow existing Laravel conventions and the current project architecture.
- Keep controllers thin.
- Put validation in Form Request classes.
- Put reusable business and integration logic in services.
- Use enums or existing support types for finite domain values.
- Use Eloquent relationships rather than repeating manual joins.
- Prevent N+1 queries with intentional eager loading.
- Use database transactions when one operation writes several dependent records.
- Never trust prices, vehicle IDs, lead types, or contact data coming from the browser without server validation.
- Do not expose internal exception details, credentials, or API responses to users.
- Keep secrets in environment variables. Do not commit real secrets.
- Do not create migrations for content or styling changes.
- Never run `migrate:fresh`, destructive seeders, or broad data deletion against production.

## Inventory and Images

- Inventory data must come from the database.
- Preserve the existing separation of vehicle details, makes, models, and images.
- Preserve image variants and ordering where supported.
- Do not hardcode demo vehicles into Vue pages.
- Do not commit temporary scraped data or unlicensed images.
- Confirm that a vehicle is published/available according to the existing model scopes before exposing it publicly.
- Vehicle SEO fields must be passed through the controller when used by `Inventory/Show.vue`.
- Handle missing images with the shared fallback behavior.
- Changes to import behavior require reviewing the related command, importer, storage paths, and tests.

## Leads, Email, and Tracking

The supported lead flows include, where enabled:

- general contact;
- vehicle inquiry;
- financing;
- trade-in / sell your car;
- service-related contact.

For each form:

- validate on the server;
- preserve entered values after validation errors;
- show one clear success or error message;
- save the lead before dispatching dependent notifications;
- do not create duplicate submissions due to frontend retries;
- map the correct lead type;
- send mail through the existing lead service and queue flow;
- never place a secret API key in JavaScript.

If Meta Pixel and CAPI are enabled, preserve browser/server deduplication with the same event ID. Do not emit a `Lead` event merely for viewing a page.

## Configuration Rules

- Use `.env.example` for documented placeholders only.
- Never read, print, commit, or return real secret values.
- Never replace an existing production `.env.carsforlessct`.
- Prefer `config()` in application code; do not call `env()` outside configuration files.
- Clear cached configuration after changing environment-backed configuration.
- Company identity should have one authoritative source.
- Avoid hardcoded production domains. Generate canonical URLs from configuration.

## SEO and Legal Content

Every public branch must have:

- unique titles and descriptions;
- correct canonical domain;
- Open Graph metadata where supported;
- meaningful heading hierarchy;
- sitemap entries for all indexable public pages;
- valid `robots.txt`;
- dealership-specific contact information;
- no references to a previous company;
- accurate structured data if present.

Privacy Policy, Terms, financing, warranties, returns, delivery, and service text must match the dealership's actual operations. Do not invent guarantees, approvals, rates, return rights, warranties, delivery coverage, or service capabilities.

Legal pages may use a prepared template, but company name, address, contact data, state, effective date, integrations, and actual policies must be reviewed for the current dealership. Flag material legal assumptions for human review.

## Token and Context Economy

Token conservation is a project requirement.

- Start with `git status --short`, `git branch --show-current`, `rg --files`, and narrow `rg` searches.
- Read only files relevant to the current task.
- Use line ranges or targeted searches instead of dumping entire large files.
- Do not repeatedly read unchanged files.
- Do not scan `vendor`, `node_modules`, generated assets, caches, logs, or large image directories unless required.
- Do not paste lockfiles, compiled files, minified output, or long command output into the conversation.
- Reuse established project knowledge and existing components.
- Prefer one focused tool call containing several independent read-only checks.
- Make the smallest coherent patch that fully solves the task.
- Do not rewrite a complete file when a small patch is sufficient.
- Do not explain obvious framework basics unless requested.
- Do not provide a long plan for a small change.
- Report only the meaningful outcome, verification, and remaining blocker.
- When asking the user for data, group related missing company details into one concise request.

Saving tokens must not reduce correctness. Always inspect the code directly involved in a change and verify the result.

## Working Method

1. Understand the requested dealership and exact scope.
2. Check branch and working-tree state.
3. Locate relevant files with `rg`.
4. Inspect nearby conventions before editing.
5. Implement a focused patch.
6. Format only changed code where practical.
7. Run the narrowest meaningful verification.
8. Review the diff for previous-company residue, secrets, and unintended changes.
9. Summarize what changed and any remaining action.

Continue independently when the task is clear. Ask a question only when missing information materially changes the implementation, legal meaning, company identity, data safety, or design direction.

## Verification

Choose checks proportional to the change.

PHP:

```bash
vendor/bin/pint --dirty
php artisan test
```

Frontend:

```bash
npm run build
```

Routes and Laravel configuration:

```bash
php artisan route:list
php artisan about
```

Before a production handoff, also verify:

- home page;
- inventory filters and pagination;
- vehicle details and gallery;
- desktop and mobile navigation;
- all lead forms and validation;
- success notifications;
- email queue flow;
- `/admin`;
- uploaded image access through `public/storage`;
- favicon and logo;
- phone, email, map, and external links;
- Privacy Policy and Terms;
- sitemap and robots;
- responsive layouts;
- absence of the previous dealership name and domain;
- production build output.

Do not claim that tests passed unless they were actually run.

## Git and Safety

- Do not commit unless explicitly asked.
- Do not push unless explicitly asked.
- Do not create or switch branches unless explicitly asked.
- Never use `git reset --hard`, destructive checkout commands, or forced pushes without explicit approval.
- Do not delete user files or unrelated modifications.
- Do not include `.env.carsforlessct`, credentials, dumps, logs, or private customer data in Git.
- Do not edit dependency lockfiles unless dependency changes are part of the task.
- Do not run production mutations as part of ordinary development verification.

## Definition of Done for a New Dealership Branch

A dealership adaptation is complete only when:

- branding and design are specific to the new company;
- all company data comes from the correct shared configuration;
- no previous-company content remains;
- public pages are responsive and accessible;
- inventory and vehicle details remain dynamic;
- all required forms persist valid leads;
- email and analytics hooks remain correctly integrated;
- SEO, canonical URLs, sitemap, robots, and legal pages are updated;
- logo, favicon, and static imagery are replaced;
- the frontend production build succeeds;
- relevant automated tests pass;
- no secrets or generated junk are included in the diff;
- the final diff contains only intentional changes for the current branch.
