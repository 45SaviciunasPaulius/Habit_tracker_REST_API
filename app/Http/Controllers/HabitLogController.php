<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitLogRequest;
use App\Http\Requests\UpdateHabitLogRequest;
use App\Http\Resources\HabitLogResource;
use App\Http\Resources\HabitResource;
use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Habit $habit)
    {
        if($habit->user_id !== Auth::id()){
            return response()->json(['message' => 'Unauthorized access'], 403);
        }

        $logs = $habit->habitLogs;

        return response()->json([
            'habit' => new HabitResource($habit),
            'logs' => HabitLogResource::collection($logs)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHabitLogRequest $request, Habit $habit)
    {
        $validated = $request->validated();

        if($habit->user_id !== Auth::id()){
            return response()->json(['message' => 'Unauthorized access'], 403);
        }

        $log = HabitLog::create(['habit_id' => $habit->id,...$validated]);

        return new HabitLogResource($log);
    }

    /**
     * Display the specified resource.
     */
    public function show(Habit $habit, HabitLog $log)
    {
        if($habit->user_id !== Auth::id() || $habit->id !== $log->habit_id){
            return response()->json(['message' => 'Unauthorized access'], 403);
        }
        
         return response()->json([
            'habit' => new HabitResource($habit),
            'log' => new HabitLogResource($log)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHabitLogRequest $request, Habit $habit, HabitLog $log)
    {
        $validated = $request->validated();

        if($habit->id !== $log->habit_id || $habit->user_id !== Auth::id()){
            return response()->json(['message' => 'Unauthorized access'], 403);
        }

        $log->update($validated);

        return new HabitLogResource($log);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habit $habit, HabitLog $log)
    {
        if($habit->id !== $log->habit_id || $habit->user_id !== Auth::id()){
            return response()->json(['message' => 'Unauthorized access'], 403);
        }

        $log->delete();

        return response()->json(['message' => 'Log was deleted successfully'], 200);
    }
}
