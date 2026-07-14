# Habit Tracker API

A REST API for tracking habits and daily check-ins, built with Laravel.

## What it does

Users can create habits, log check-ins over time, and track current and longest streaks.

## Features

- [x] Token-based authentication (Laravel Sanctum)
- [x] CRUD for habits and habit logs
- [x] Streak calculation (current & longest)
- [x] Ownership-based authorization (users only access their own data)
- [x] Filtering & pagination
- [x] API Resources

## Tech stack

- Laravel
- MySQL
- Sanctum
- Pest

## API Endpoints

### Auth

| Method | Endpoint        | Description                |
| ------ | --------------- | -------------------------- |
| POST   | `/api/register` | Register a new user        |
| POST   | `/api/login`    | Log in and receive a token |
| POST   | `/api/logout`   | Revoke current token       |
| GET    | `/api/user`     | Get the authenticated user |

### Habits

| Method | Endpoint             | Description     |
| ------ | -------------------- | --------------- |
| GET    | `/api/habit`         | List all habits |
| POST   | `/api/habit`         | Create a habit  |
| GET    | `/api/habit/{habit}` | Show a habit    |
| PUT    | `/api/habit/{habit}` | Update a habit  |
| DELETE | `/api/habit/{habit}` | Delete a habit  |

### Habit Logs

| Method | Endpoint                        | Description           |
| ------ | ------------------------------- | --------------------- |
| GET    | `/api/habit/{habit}/logs`       | List logs for a habit |
| POST   | `/api/habit/{habit}/logs`       | Create a log entry    |
| GET    | `/api/habit/{habit}/logs/{log}` | Show a single log     |
| PUT    | `/api/habit/{habit}/logs/{log}` | Update a log          |
| DELETE | `/api/habit/{habit}/logs/{log}` | Delete a log          |

## Status

In progress

## Todo

- [ ] Feature tests.
