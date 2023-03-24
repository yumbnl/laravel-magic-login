<?php

namespace Yumb\MagicLogin;

use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yumb\MagicLogin\Commands\MagicLoginCommand;
use Yumb\MagicLogin\Http\Controllers\RequestTokenController;
use Yumb\MagicLogin\Http\Controllers\VerifyTokenController;
use Yumb\MagicLogin\Http\Controllers\RevokeTokenController;


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
            ->hasViews()
            ->hasMigration('create_laravel-magic-login_table')
            ->hasCommand(MagicLoginCommand::class);
    }

    public function packageRegistered()
    {
        Route::post('magic-login/request-token', RequestTokenController::class)
            ->name('magictoken.request');

        Route::post('magic-token/verify-token', VerifyTokenController::class)
            ->name('magictoken.verify');

        Route::post('magic-login/revoke-token', RevokeTokenController::class)
            ->name('magictoken.revoke');
    }
}
