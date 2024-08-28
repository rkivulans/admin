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

If you pull in and there are new migrations added, run this to migrate:

    php artisan migrate

Pre-commit: 

    ./vendor/bin/pint     # formats php files under app/
    npm run format        # folmats js and blade.php under resources/views

## Translation

Virsraksti: anglinki "Title Case", latviski "Pirmais teikuma burts liels"
Jaunas lietas *izveido* (nevis pievieno)

Termini:

  - e-pasts
  - pāradresācija  (Alias)
  - pārsūtīt uz .. (Forward to ..)
  - pastkastītes
  - domēns
  - infopanelis
  - reset password - nomainīt paroli
