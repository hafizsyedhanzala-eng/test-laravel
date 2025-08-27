## Mini Multi‑Vendor Product Management

Simple multi‑vendor product module implementing the technical test requirements with roles (admin, vendor), product approval flow, REST API, and a minimal Blade UI.

---

## Tech stack
- Laravel 11, PHP 8.2+
- Sanctum for API tokens (database: `personal_access_tokens`)
- Queues for notifications (database driver)

---

## Setup
1. Install dependencies
   - composer install
2. Configure environment
   - Copy `.env.example` to `.env` and set DB connection
3. Generate app key
   - php artisan key:generate
4. Autoload helpers (already configured)
   - composer dump-autoload
5. Run migrations and seeders
   - php artisan migrate --force
   - php artisan db:seed --force
6. Serve the app
   - php artisan serve (http://127.0.0.1:8000)

Seeders create:
- Admin: `admin@example.com` / `password`
- Vendor: `vendor@example.com` / `password`
- API tokens saved to `storage/app/tokens.txt`

---

## Roles
- Admin: Reviews and approves/rejects products.
- Vendor: Creates, updates, deletes own products while pending.

Middleware:
- `auth` (session)
- `role:{admin|vendor}` for access control

---

## Flows

### Vendor flow
1) Login as vendor → Dashboard
2) Create product → status `pending`
3) Can edit/delete only while `pending`
4) After admin decision: `approved` or `rejected` (locked)

### Admin flow
1) Login as admin → Admin products list
2) Review pending products → Approve or Reject
3) Vendors are notified (queued, database notifications)

---

## Web UI
- Login: `GET /login`
- Dashboard (after auth): `GET /`
- Vendor
  - My Products: `GET /products`
  - Create: `GET /products/create`, submit: `POST /products`
  - Edit: `GET /products/{product}/edit`, update: `PUT /products/{product}`
  - Delete: `DELETE /products/{product}`
- Admin
  - List all: `GET /admin/products`
  - Approve: `POST /admin/products/{product}/approve`
  - Reject: `POST /admin/products/{product}/reject`

All UI routes require session auth and appropriate `role`.

---

## REST API

Authentication: Bearer token (Sanctum personal access tokens).
Seeded tokens are written to `storage/app/tokens.txt`.

### Vendor endpoints (auth:sanctum + role:vendor)
- `GET /api/products` → list own products
- `POST /api/products` → create product
  - body: `{ name: string, description?: string, price: number }`
- `PUT /api/products/{id}` → update pending product
- `DELETE /api/products/{id}` → delete pending product

### Admin endpoints (auth:sanctum + role:admin)
- `GET /api/admin/products` → list all products
- `POST /api/admin/products/{id}/approve` → approve
- `POST /api/admin/products/{id}/reject` → reject

Response formats follow standard JSON resources; validation errors return 422 with messages.

---

## Notifications & queue
- Event `ProductCreated` triggers `ProductPendingApproval` notification to admins.
- Queue driver: database. Start a worker to process notifications:
  - php artisan queue:work

---

## Implementation notes
- Service layer: `App\Services\ProductService` centralizes create/update/delete/approve/reject logic.
- Guards in migrations: duplicate `personal_access_tokens`/`failed_jobs` migrations are wrapped with `Schema::hasTable` checks to ensure idempotency.
- Helpers: `app/Support/helpers.php` includes `generateProductCode()` and is autoloaded via Composer.

---

## Development tips
- Use the vendor/admin seed users for quick testing.
- For API testing, copy the token from `storage/app/tokens.txt` and send as `Authorization: Bearer {token}`.
- Pagination is enabled on list pages; styling is intentionally minimal.
