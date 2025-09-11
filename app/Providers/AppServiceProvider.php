<?php

namespace App\Providers;

use Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        Http::macro('news', function () {
            return Http::withHeader('X-API-KEY', config('services.news.api_key'))
                ->acceptJson()
                ->baseUrl('https://newsapi.org/v2');
        });

        Http::macro('nyt', function () {
            return Http::acceptJson()
                ->baseUrl('https://api.nytimes.com/svc/search/v2');
        });

        Http::macro('newsdata', function () {
            return Http::withHeader('X-ACCESS-KEY', config('services.newsdata.api_key'))
                ->baseUrl('https://newsdata.io/api/1');
        });
    }
}
