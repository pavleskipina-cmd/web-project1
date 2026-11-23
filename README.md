# FitPulse

FitPulse is a responsive single-page fitness application for managing workout routines, tracking exercises, logging daily nutrition, and discovering high-protein recipes. It uses HTML, CSS, JavaScript, jQuery, Bootstrap, a PHP REST API, and MySQL.

## Entities

The project is built around these entities:

- `users` - registered application users and roles
- `workouts` - workout plans owned by users
- `exercises` - exercises belonging to a workout
- `nutrition_logs` - meal, calorie, and protein entries owned by users
- `reviews` - ratings and feedback linking users to workouts

## Relationships

- `workouts.user_id` references `users.id`
- `exercises.workout_id` references `workouts.id`
- `nutrition_logs.user_id` references `users.id`
- `reviews.user_id` references `users.id`
- `reviews.workout_id` references `workouts.id`

Workout deletion is restricted while dependent exercises or reviews exist.

## External recipe API

FitPulse uses TheMealDB for high-protein meal and recipe ideas. `RecipeService` searches TheMealDB with a strict timeout, validates the HTTP/JSON response, converts it to UI-ready recipe objects, and returns HTTP `503` through `ExternalServiceException` if the provider is unavailable.

Endpoint:

- `GET /recipes/search?q=chicken&limit=10`

## Roles

- **Admin** - manages users, exercises, workouts, nutrition records, reviews, and administrative settings.
- **User** - views workout and exercise information and manages their own workouts, nutrition logs, and reviews.

## Running the project

### Option 1: XAMPP

1. Place the project in the XAMPP `htdocs` directory.
2. Start **Apache** and **MySQL** from the XAMPP Control Panel.
3. Import `database/fitpulse.sql` into MySQL, for example with phpMyAdmin or:

   ```sql
   source C:/xampp/htdocs/Pavle Škipina/web-project1/database/fitpulse.sql
   ```

4. Copy `backend/config/config.example.php` to `backend/config/config.php`.
5. Update database values in `backend/config/config.php` if they differ from the local defaults.
6. Run `composer install` inside `backend/` if dependencies are not installed.
7. Open [http://localhost/web-project1/frontend/](http://localhost/web-project1/frontend/) in a browser.
8. Open the API documentation at [http://localhost/web-project1/backend/docs](http://localhost/web-project1/backend/docs).

### Option 2: PHP built-in server

For the backend API only, change into `backend/` and run:

```bash
cd backend
php -S localhost:8000 index.php
```

Then open [http://localhost:8000/docs](http://localhost:8000/docs) for Swagger UI and [http://localhost:8000/openapi.json](http://localhost:8000/openapi.json) for the OpenAPI document.

## API documentation

- Swagger UI: [http://localhost/web-project1/backend/docs](http://localhost/web-project1/backend/docs)
- OpenAPI JSON: [http://localhost/web-project1/backend/openapi.json](http://localhost/web-project1/backend/openapi.json)