# Prakse

Jauna projekta izveide

## Stack

Laravel, Blade, Javascript

## Initial installation

    cp .env.example .env
    composer install
    npm clean-install
    php artisan key:generate
    php artisan migrate
    
## Development

We're using Bun in production

In parallel:

    php artisan serve
    npm run dev

If you pull in and there are new dependencies added, run this to add them to your pc:

    composer install && npm clean-install

Pre-commit: 

    ./vendor/bin/pint     # formats php files under app/