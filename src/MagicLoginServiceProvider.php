<?php

namespace Yumb\MagicLogin;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yumb\MagicLogin\Commands\MagicLoginCommand;
use Yumb\MagicLogin\Http\Controllers\RequestTokenController;
use Illuminate\Support\Facades\Route;

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
        Route::post('magic-login/token-request', RequestTokenController::class)
            ->name('magictoken.request');
    }
}
