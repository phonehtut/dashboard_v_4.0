<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use function Laravel\Prompts\text;

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
})->purpose('Display an inspiring quote');

Artisan::command('greetold {name?}', function (String $name = null) {
    if(! $name) {
        $name = $this->ask('What is your name?');
    }


    $this->info("Hello, {$name}");
});

Artisan::command('greet {name?}', function (String $name = null) {
    if(! $name) {
        $name = text(
            label: 'What is your name?',
            placeholder: 'E.g. Taylor Otwell',
            default: 'Test',
            hint: 'This will be displayed on your profile.',
            required: 'Your name is required.',
        );
    }


    $this->info("Hello, {$name}");
});
