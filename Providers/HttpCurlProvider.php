<?php

namespace App\Providers;

use App\Helpers\HttpCurl;
use Illuminate\Support\ServiceProvider;

/**
 * Class HttpCurlProvider
 * @package App\Providers
 */
class HttpCurlProvider extends ServiceProvider
{
    /**
     * Регистрируем через сервис провайдер HttpCurl.
     */
    public function register(): void
    {
        $this->app->singleton(HttpCurl::class, function ($app) {
            return new HttpCurl($app['config']['api']);
        });
    }
}