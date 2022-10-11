#Arena.Api.Core Installation

**This file is step by step guide of project installation.**

## Downloading and Package Installation
1. Clone this project from [repository](https://github.com/ArenaOps/arena.api.core).
    ```bash
    git clone https://github.com/ArenaOps/arena.api.core
    ``` 
2. Switch to `develop` branch:
    ```bash
    git checkout develop
    ```
3. Install Composer Dependencies:
    ```bash
    composer install
    ```

## Environment Setups
1. Create `.env` file:
    ```bash
    touch .env
    ```
2. Put this content into `.env` file:
    ```dotenv
    APP_NAME=arena-api
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=
    ASSET_URL=

    #API CONFIG
    API_PREFIX=/
    API_DEBUG=true

    LOG_CHANNEL=stack
    FILESYSTEM_DRIVER=local

    #DATABASE CONFIG
    DB_DATABASE=
    DB_HOST=
    DB_PASSWORD=
    DB_PORT=
    DB_USERNAME=

    CACHE_DRIVER=file
    QUEUE_CONNECTION=database
    SESSION_DRIVER=file
    SESSION_LIFETIME=120
    BROADCAST_DRIVER=pusher

    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379

    #MAIL DRIVER AND MAILGUN CREDENTIALS
    MAIL_DRIVER=log
    MAIL_HOST=
    MAIL_PORT=
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_FROM_ADDRESS=
    MAIL_FROM_NAME=

    #AWS CREDENTIALS
    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=

    #AWS S3 BUCKETS
    AWS_BUCKET=arena-merch-apparel-develop
    AWS_APPAREL_BUCKET=arena-merch-apparel-develop
    AWS_SOUNDBLOCK_BUCKET=arena-soundblock
    AWS_ACCOUNT_BUCKET=arena-account-develop
    AWS_CORE_BUCKET=arena-core-develop

    #PUSHER CREDENTIALS
    PUSHER_APP_ID=
    PUSHER_APP_KEY=
    PUSHER_APP_SECRET=
    PUSHER_APP_CLUSTER=

    MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
    MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
    
    JWT_SECRET=
    
    #PASPORT AUTH CLIENT CREDENTIALS
    PASSWORD_CLIENT_ID=
    PASSWORD_CLIENT_SECRET=
    
    #LEDGER MICROSERVICE
    LEDGER_SERVICE_HOST=
    LEDGER_TOKEN=
    LEDGER_NAME=
    
    #BILLING
    CHARGE_NOT_DEFAULT=true
    STRIPE_KEY=
    STRIPE_SECRET=
    
    #SLACK NOTIFICATION URL
    SLACK_WEBHOOK_URL=
    
    #MERCH ORDER EMAIL
    MERCH_ORDER_EMAIL=test@email.com
    
    #TELESCOPE
    TELESCOPE_AUTH_TOKEN=
    ```
3. Generate APP KEY:
    ```bash
    php artisan key:generate
    ```
4. Put your local host name to `APP_URL` variable.
5. Put your Pusher Credentials. If you don't have Pusher's account you can make it here: 
[Pusher](https://dashboard.pusher.com/accounts/sign_up).
6. If you use `SMTP` server update `MAIL_*` variables.
7. Put your Stripe **Test**  credentials to `STRIPE_*` variables. If you don't have Stripe's 
account, you can make it here: [Stripe](https://dashboard.stripe.com/register).

## Database
1. Create MySQL database and put your credentials to `DB_*` variables in `.env` file.
2. Run Migrations and Seeds:
    ```bash
    php artisan migrate --seed
    ``` 
3. Create MySQL database for PHPUNIT with `arena_api_test` name.

## API AUTH
1. Install Laravel Passport:
    ```bash
    php artisan passport:install
    ``` 
2. Put in `.env` file `Password Grand Client` credentials. `PASSWORD_CLIENT_ID` is Client ID from 
prev command output (Generally - 2). `PASSWORD_CLIENT_SECRET` is Client secret from `passport:install`
output (hash).

## Telescope
1. Generate and put random string to `TELESCOPE_AUTH_TOKEN` variable. That's auth token, that you send
in a query params to have access to Telescope Dashboard. You can use this command to generate random string:
```bash
cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w ${1:-32} | head -n 1
```
2. You can test it here: `<YOUR_HOST>/telescope/requests?telescope_token=<YOUR_TOKEN>`