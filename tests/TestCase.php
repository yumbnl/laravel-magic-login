<?php

namespace Yumb\MagicLogin\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Yumb\MagicLogin\MagicLoginServiceProvider;
use Yumb\MagicLogin\Tests\TestModels\User;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Yumb\\MagicLogin\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            MagicLoginServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        // Use test User model for users provider
        $app['config']->set('magic-login.user_model', User::class);

        $migration = include __DIR__.'/../database/migrations/2023_03_22_085913_create_magic_login_tokens_table.php';
        $migration->up();

        $schema = $app['db']->connection()->getSchemaBuilder();

        $schema->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->softDeletes();
        });
    }
}
