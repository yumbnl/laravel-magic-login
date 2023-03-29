<?php

use Illuminate\Support\Facades\Route;
use Yumb\MagicLogin\Tests\TestCase;

uses(TestCase::class)
    ->beforeEach(function () {
        Route::magiclogin();
    })
    ->in(__DIR__);
