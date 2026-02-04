# Order & Payment Management API (Laravel) - v1

## Setup
1. Clone repo
2. Install
   - composer install
3. Copy env
   - copy .env.example .env
4. Configure DB in .env
5. Generate key
   - php artisan key:generate
6. JWT
   - php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
   - php artisan jwt:secret
7. Migrate
   - php artisan migrate
8. Run
   - php artisan serve

## API Versioning
All endpoints are under:
`/api/v1/...`

Routes are split into:
`routes/api/v1/auth.php`, `orders.php`, `payments.php`

## Business Rules
- Payments can only be processed for CONFIRMED orders.
- Orders cannot be deleted if they have any payments.

## Add New Payment Gateway
1. Create a gateway class in:
   `app/Services/Payment/Gateways/Gateways`
   implementing `PaymentGatewayInterface`.
2. Register the gateway in `AppServiceProvider` mapping.
3. Add its key to:
   `.env` -> `PAYMENT_GATEWAYS=credit_card,paypal,new_gateway`
   and add its config to `config/payment_gateways.php`.

## Testing
Run:
`php artisan test`

## Postman

Import the collection JSON from:
`Order Payments API.postman_collection.json` (root). Use environment variables `baseUrl` and `token`.

Quick usage:
- Set `baseUrl` to your app URL (e.g. `http://127.0.0.1:8000`).
- Call `POST /api/v1/auth/login` to obtain `token` then set `token` in the environment.
