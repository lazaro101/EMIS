<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('random', function () {
    $this->comment(mt_rand(1,31)."-".mt_rand(1,31));
})->describe('Random Number');

Artisan::command('snuckls', function () {
    $this->comment(mt_rand(1,42)."-".mt_rand(1,42)."-".mt_rand(1,42)."-".mt_rand(1,42)."-".mt_rand(1,42));
})->describe('Random Number');
