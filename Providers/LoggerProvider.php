<?php

namespace App\Providers;

use AnyDirectory\KibanaLogger;
use AnyDirectory\FileLogger;
use Psr\Log\LoggerInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class LoggerProvider
 * @package App\Providers
 */
class LoggerProvider extends ServiceProvider
{
    /**
     * Регистрируем через сервис провайдер логера.
     */
    public function register(): void
    {
        $this->app->singleton(LoggerInterface::class, function ($app) {
            if (env('server_type') === 'production') {
                return new LoggerInterface(KibanaLogger());
            }

            return new LoggerInterface(FileLogger());
        });
    }
}