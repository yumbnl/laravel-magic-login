<?php

namespace Yumb\MagicLogin;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yumb\MagicLogin\Commands\MagicLoginCommand;

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
}
