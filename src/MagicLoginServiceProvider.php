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
            // ->hasViews()
            ->hasMigration('create_laravel-magic-login_table');
            // ->hasCommand(MagicLoginCommand::class);
    }

    public function packageRegistered()
    {
        Route::post(config('magic-login.urls.magictoken.request'), RequestTokenController::class)
            ->name('magictoken.request');

        Route::post(config('magic-login.urls.magictoken.request'), VerifyTokenController::class)
            ->name('magictoken.verify');

        Route::post(config('magic-login.urls.magictoken.request'), RevokeTokenController::class)
            ->name('magictoken.revoke');
    }
}
