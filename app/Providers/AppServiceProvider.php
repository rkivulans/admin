<?php

namespace App\Providers;

use App\Services\DevMailboxService;
use App\Services\MailboxService;
use App\Services\MailboxServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MailboxServiceInterface::class, function ($app) {
            if (config('services.mailbox.server') === 'dev') {
                return new DevMailboxService;
            }

            return new MailboxService;
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
