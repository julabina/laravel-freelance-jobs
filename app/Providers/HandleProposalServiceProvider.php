<?php

namespace App\Providers;

use App\Services\HandleProposalService;
use Illuminate\Support\ServiceProvider;

class HandleProposalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(HandleProposalService::class, function () {
            return new HandleProposalService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
