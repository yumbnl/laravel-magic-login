<?php

namespace Yumb\MagicLogin;

use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yumb\MagicLogin\Commands\MagicLoginCommand;
use Yumb\MagicLogin\Http\Controllers\RequestTokenController;
use Yumb\MagicLogin\Http\Controllers\RevokeTokenController;
use Yumb\MagicLogin\Http\Controllers\VerifyTokenController;

class MagicLoginServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-magic-login')
            ->hasConfigFile()
            ->hasViews('magic-login')
            ->hasMigration('create_laravel-magic-login_table')
            ->hasTranslations()
            ->hasCommand(MagicLoginCommand::class);

        $this->app->register(MagicEventsServiceProvider::class);
    }

    public function packageRegistered()
    {
        Route::macro('MagicLoginWeb', function (string $baseUrl = 'magic-login-web') {
            Route::prefix($baseUrl)->group(function () {
                Route::post('/request', RequestTokenController::class)
                    ->name('magictoken.web.request');

                Route::get('/verify', VerifyTokenController::class)
                    ->name('magictoken.web.verify');
            });
        });

        Route::macro('MagicLoginApi', function (string $baseUrl = 'magic-login-api') {
            Route::prefix($baseUrl)->group(function () {
                Route::post('/request', RequestTokenController::class)
                    ->name('magictoken.api.request');

                Route::post('/verify', VerifyTokenController::class)
                    ->name('magictoken.api.verify');

                Route::middleware('auth:sanctum')->group(function () {
                    Route::post('/revoke', RevokeTokenController::class)
                        ->name('magictoken.api.revoke');
                });
            });
        });
    }
}
