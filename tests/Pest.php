<?php

use Illuminate\Support\Facades\Route;
use Yumb\MagicLogin\Tests\TestCase;

uses(TestCase::class)
    ->beforeEach(function () {
        Route::MagicLoginWeb();
        Route::MagicLoginApi();
    })
    ->in(__DIR__);
