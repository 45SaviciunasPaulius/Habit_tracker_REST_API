<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitRequest;
use App\Http\Requests\UpdateHabitRequest;
use App\Http\Resources\HabitResource;
use App\Models\Habit;
use App\Services\HabitFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = new HabitFilter();
        $queryItems = $filter->transform($request);

        if(count($queryItems) == 0){
            return HabitResource::collection($user->habits()->paginate(25));
        } else {
            return HabitResource::collection($user->habits()->where($queryItems)->paginate(25));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHabitRequest $request)
    {
        $validated = $request->validated();

        $habit = Habit::create([
            'user_id' => Auth::id(),
            ...$validated
        ]);

        return new HabitResource($habit);
    }

    /**
     * Display the specified resource.
     */
    public function show(Habit $habit)
    {   
        if($habit->user_id !== Auth::id()){
            return response()->json(['message' => 'Unauthotized access'], 403);
        }

        return new HabitResource($habit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHabitRequest $request, Habit $habit)
    {

    $validated = $request->validated();
         
        if(Auth::id() !== $habit->user_id){
            return response()->json(['message' => 'Unauthorized access'], 403);
        }

        $habit->update($validated);

        return new HabitResource($habit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habit $habit)
    {
        if(Auth::id() !== $habit->user_id){
            return response()->json(['message' => 'Unauthorized access'], 403);
        }

        $habit->delete();

        return response()->json([
            'message' => 'Habit was deleted successfully'
        ], 200);
    }
}
