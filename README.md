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


Pre-commit: 

    ./vendor/bin/pint     # formats php files under app/
    npm run format        # folmats js and blade.php under resources/views
