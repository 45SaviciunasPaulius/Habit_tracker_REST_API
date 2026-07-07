<?php

use App\Models\Habit;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::call(function(){
    $habits = Habit::all();

    $habits->each(function($habit){
          $habit->calculateStreaks();
    });
})->hourly();