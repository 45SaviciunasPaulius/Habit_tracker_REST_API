<?php

namespace Database\Seeders;

use App\Models\Habit;
use App\Models\HabitLog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(30)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin123'
        ]);

        Habit::factory(100)->create();
        HabitLog::factory(1000)->create();
    }
}
