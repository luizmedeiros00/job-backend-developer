<?php

namespace App\Providers;

use App\Services\FakerStoreApi\FakerStoreApi;
use App\Services\FakerStoreApi\FakerStoreApiInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FakerStoreApiInterface::class, FakerStoreApi::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Http::macro('fakerStore', function () {
            return Http::baseUrl('https://fakestoreapi.com/products');
        });
    }
}
