<?php

use Illuminate\Support\Facades\Route;
use Yumb\MagicLogin\Tests\TestCase;

uses(TestCase::class)
    ->beforeEach(function () {
        Route::MagicLoginWeb();
    })
    ->in(__DIR__);
