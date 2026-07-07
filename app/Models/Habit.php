<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'frequency',
        'current_streak',
        'longest_streak'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function habitLogs(){
        return $this->hasMany(HabitLog::class);
    }

    private function calculateDailyStreak(){
        $date = Carbon::today();

        if(!$this->habitLogs()->where('date', $date)->exists()){
           $date->subDay();
        }

        $streak = 0;

        while($this->habitLogs()->where('date',$date)->exists()){
            $streak++;
            $date->subDay();
        }

        return $this->update(['current_streak' => $streak,
        'longest_streak' => $this->longest_streak<$streak ? $streak : $this->longest_streak]);
    }

    private function calculateWeeklyStreak(){
        $frequency = $this->frequency;
        $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $habitStart = $this->created_at;

        $week = $weekStart->copy()->subWeek();
        $streak = $this->habitLogs()->whereBetween('date', [$weekStart, $weekStart->copy()->endOfWeek(Carbon::SUNDAY)])->count();

        while($week->gte($habitStart)){
            $count = $this->habitLogs()->whereBetween('date', [$week, $week->copy()->endOfWeek(Carbon::SUNDAY)])->count();

            if($count >= $frequency){
                $streak+=$count;
                $week->subWeek();
            } else{
                break;
            }
        }

       return $this->update(['current_streak' => $streak,
        'longest_streak' => $this->longest_streak<$streak ? $streak : $this->longest_streak]);
    }

    public function calculateStreaks(){
         if($this->frequency < 7){
            $this->calculateWeeklyStreak();
        } else{
            $this->calculateDailyStreak();
        }
    }
}
