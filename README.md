# Habit Tracker API

A REST API for tracking habits and daily check-ins, built with Laravel.

## What it does

Users can create habits, log check-ins over time, and track current and longest streaks.

## Features

- [x] Token-based authentication (Laravel Sanctum)
- [x] CRUD for habits and habit logs
- [x] Streak calculation (current & longest)
- [x] Ownership-based authorization (users only access their own data)
- [ ] Filtering & pagination
- [x] API Resources

## Tech stack

- Laravel
- MySQL
- Sanctum
- Pest

## Status

In progress

## Needs fixing

- [ ] longest_streak is not recalculated when frequency changes
