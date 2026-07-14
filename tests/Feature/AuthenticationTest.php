<?php

use App\Models\Habit;
use App\Models\HabitLog;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

test('Register creates a user and returns a token', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'test',
        'email' => 'test@example.com',
        'password' => 'admin123',
        'password_confirmation' => 'admin123',
    ]);

    $response->assertStatus(201);

    $response->assertJsonStructure([
        'token'
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});

test('Login with valid user and return a token', function(){
    User::create(['name' => 'test',
    'email' => 'test@example.com',
    'password' => 'admin123']);

    $response = $this->postJson('/api/login' , [
        'email' => 'test@example.com',
        'password' => 'admin123'
    ]);

    $response->assertStatus(200);

    $response->assertJsonStructure(['token']);
});

test('Login with bad credentials returns 401',function(){
    User::create(['name' => 'test',
    'email' => 'test@example.com',
    'password' => 'admin123']);

    $response = $this->postJson('/api/login' , [
        'email' => 'test@example.com',
        'password' => 'admin1234'
    ]);

    $response->assertStatus(401);

});

test('Unauthenticated requests to protected routes return 401', function(){
    User::factory(1)->create();
    Habit::factory(1)->create();
    HabitLog::factory(1)->create();

    $this->getJson('/api/habit')->assertStatus(401);
    $this->getJson('/api/habit/1')->assertStatus(401);
    $this->getJson('/api/habit/1/logs')->assertStatus(401);
    $this->getJson('/api/habit/1/logs/1')->assertStatus(401);
});

test('Logout revokes the token', function(){
    User::create(['name' => 'test',
    'email' => 'test@example.com',
    'password' => 'admin123']);

    $response = $this->postJson('/api/login', ['email' => 'test@example.com',
    'password' => 'admin123']);

    $response->assertStatus(200);
    
    $token = $response->json('token');

    $this->withToken($token)->postJson('/api/logout')->assertStatus(200);

    expect(PersonalAccessToken::findToken($token))->toBeNull();
});