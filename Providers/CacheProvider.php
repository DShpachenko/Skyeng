<?php

namespace App\Providers;

use AnyDirectory\NullCache;
use AnyDirectory\MemcacheCache;
use Psr\Cache\CacheItemPoolInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class CacheProvider
 * @package App\Providers
 */
class CacheProvider extends ServiceProvider
{
    /**
     * Регистрируем через сервис провайдер кэш.
     */
    public function register(): void
    {
        $this->app->singleton(LoggerInterface::class, function ($app) {
            if (env('server_type') === 'production') {
                return new LoggerInterface(MemcacheCache());
            }

            return new LoggerInterface(NullCache());
        });
    }
}