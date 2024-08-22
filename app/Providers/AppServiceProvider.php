<?php

namespace App\Providers;

use App\Services\DevMailboxApiClient;
use App\Services\MailboxApiClient;
use App\Services\MailboxApiClientInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MailboxApiClientInterface::class, function ($app) {
            if (config('services.mailbox.server') === 'dev') {
                return new DevMailboxApiClient;
            }

            return new MailboxApiClient;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
