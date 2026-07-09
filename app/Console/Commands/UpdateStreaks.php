<?php

namespace App\Console\Commands;

use App\Models\Habit;
use Illuminate\Console\Command;

class UpdateStreaks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-streaks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Habit::all()->each(function($habit){
            $habit->calculateStreaks();
        });
    }
}
