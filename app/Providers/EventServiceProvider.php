<?php

namespace App\Providers;

use App\Events\ImportError;
use App\Listeners\SendImportErrorEmail;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ImportError::class => [
            SendImportErrorEmail::class
        ]
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
