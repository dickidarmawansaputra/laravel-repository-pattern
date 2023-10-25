<?php

namespace App\Providers;

use App\Repositories\InvoiceRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\InvoiceRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
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
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
    }
}
