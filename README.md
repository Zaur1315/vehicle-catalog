# Vehicle Catalog

Vehicle Catalog is a Laravel-based MVP for an auto dealer website.

The project is built as a reusable base for automotive dealership websites. It includes a public vehicle inventory,
vehicle detail pages, lead generation forms, and a Filament admin panel for managing makes, models, vehicles, images,
and customer inquiries.

---

## Tech Stack

- PHP 8.3+
- Laravel 13
- PostgreSQL
- Filament Admin Panel
- Blade / Inertia-ready frontend structure
- Tailwind CSS
- Vite

---

## Main Features

### Public Website

- Modern dealership landing page
- Vehicle inventory page
- Vehicle detail pages
- Vehicle image gallery
- Vehicle specifications
- Inventory filters:
    - Make
    - Model
    - Model year
    - Price range
    - Mileage range
    - Body type
    - Transmission
    - Drivetrain
    - Exterior color
    - Sorting
- Single vehicle inquiry form
- Contact page
- Responsive layout
- Commercial dealership UI

### Admin Panel

The project includes a Filament-based admin panel.

Admin can manage:

- Vehicle makes
- Vehicle models
- Vehicles
- Vehicle images
- Leads / customer inquiries

### Lead Workflow

The project supports dealership lead generation flows:

1. Vehicle inquiry  
   A customer sends a request directly from a vehicle detail page.

2. Contact request  
   A customer sends a general message from the contact page.

All requests are stored as leads and can be reviewed in the admin panel.

---

## Project Goal

The goal of this project is to build a reusable Laravel base for fast production of auto dealer websites.

The structure can be reused for:

- Used car dealerships
- Independent auto dealers
- Luxury car dealers
- Truck dealers
- Motorcycle dealers
- Powersports dealers
- Vehicle export / delivery businesses

---

## Installation

Clone the repository:

```bash
git clone <repository-url>
cd vehicle-catalog
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

Create environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

## Database Setup

The project is configured for PostgreSQL by default.

Create database and user:

```sql
CREATE
USER vehicle_catalog_user WITH PASSWORD 'vehicle_catalog_password';
CREATE
DATABASE vehicle_catalog OWNER vehicle_catalog_user;
GRANT ALL PRIVILEGES ON DATABASE
vehicle_catalog TO vehicle_catalog_user;
```

Update `.env` if needed:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=vehicle_catalog
DB_USERNAME=vehicle_catalog_user
DB_PASSWORD=vehicle_catalog_password
```

Run migrations and seeders:

```bash
php artisan migrate:fresh --seed
```

Create storage symlink:

```bash
php artisan storage:link
```

---

## Running the Project

Start Laravel development server:

```bash
php artisan serve
```

Start Vite development server:

```bash
npm run dev
```

Open the website:

```text
http://127.0.0.1:8000
```

---

## Admin Panel

Admin panel URL:

```text
http://127.0.0.1:8000/admin
```

Default admin credentials:

```text
Email: admin@example.com
Password: password
```

The default admin user is created by `DatabaseSeeder`.

---

## Demo Data

Seeders create demo data for:

- Vehicle makes
- Vehicle models
- Vehicles
- Admin user

Demo vehicles include sedans, SUVs, trucks, and luxury vehicles.

---

## Public Routes

```text
GET     /                       Home page
GET     /inventory              Vehicle inventory
GET     /inventory/{slug}       Vehicle detail page
POST    /inventory/{slug}/lead  Vehicle inquiry form
GET     /contact                Contact page
POST    /contact                Contact form
```

Additional planned routes:

```text
GET     /delivery
GET     /warranty-return
GET     /about
GET     /finance
GET     /trade-in
```

---

## Admin Resources

```text
Inventory
- Makes
- Models
- Vehicles

Sales
- Leads
```

---

## Core Domain Model

```text
VehicleMake
    has many VehicleModel
    has many Vehicle

VehicleModel
    belongs to VehicleMake
    has many Vehicle

Vehicle
    belongs to VehicleMake
    belongs to VehicleModel
    has many VehicleImage
    has many Lead

VehicleImage
    belongs to Vehicle

Lead
    belongs to Vehicle nullable
```

---

## Useful Commands

Clear cache:

```bash
php artisan optimize:clear
```

Rebuild database with seed data:

```bash
php artisan migrate:fresh --seed
```

Build frontend assets:

```bash
npm run build
```

Run Laravel Pint:

```bash
./vendor/bin/pint
```

Check routes:

```bash
php artisan route:list
```

Search for old equipment/product references:

```bash
grep -R "Product\|Brand\|Category\|QuoteCart\|LeadItem\|ProductAttribute\|equipment\|quote cart" -n app database routes resources README.md
```

---

## Notes

- Vehicle images uploaded from the admin panel are stored on the public disk.
- Demo images can be served from the public directory or public storage disk.
- Vehicle inquiries do not require user registration.
- Leads are stored in the database and managed from the admin panel.
- The public Admin button should be visible only for authenticated users.
- The old quote cart workflow is intentionally removed for the auto dealer version.

---

## Final Manual Checklist

Before submitting or deploying the project, check the following scenarios:

- Home page opens correctly.
- Inventory page opens correctly.
- Inventory filters work.
- Vehicle detail page opens correctly.
- Vehicle images are displayed correctly.
- Vehicle inquiry form creates a lead.
- Contact form creates a lead.
- Admin login works.
- Admin button is hidden for guests.
- Makes are visible in admin.
- Models are visible in admin.
- Vehicles are visible in admin.
- Vehicle images are visible in admin table.
- Image upload from admin works.
- Leads are visible in admin.
- Mobile layout is acceptable.

---

## Future Improvements

Possible next steps:

- Google Reviews integration through Google Places API
- Delivery page
- Warranty and return policy page
- Finance payment calculator
- Trade-in request form
- Email notifications for new leads
- Lead status history
- Advanced inventory search
- Saved filters
- SEO meta management
- Schema.org markup for AutoDealer and Vehicle
- Sitemap.xml and robots.txt
- Google Analytics / Meta Pixel tracking
- Live chat or WhatsApp widget
- Automated tests

---

### [Scroll to Top ↑](#vehicle-catalog)
