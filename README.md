# FitPulse

FitPulse is a responsive single-page fitness application for managing workout routines, tracking exercises, logging daily nutrition, and discovering high-protein recipes. It uses HTML, CSS, JavaScript, jQuery, Bootstrap, a PHP REST API, and MySQL.

## Entities

The project is built around these entities:

- `users` - registered application users and their roles
- `workouts` - workout plans and routines
- `exercises` - exercises included in workout plans
- `nutrition_logs` - daily meal, calorie, and protein entries
- `reviews` - ratings and feedback for workouts

## Roles

- **Admin** - manages users, exercises, workouts, nutrition records, reviews, and administrative settings.
- **User** - views workout and exercise information and manages their own workouts, nutrition logs, and reviews.

## Running the project

### Option 1: XAMPP

1. Place the project in the XAMPP `htdocs` directory.
2. Start **Apache** and **MySQL** from the XAMPP Control Panel.
3. Open [http://localhost/web-project1/frontend/](http://localhost/web-project1/frontend/) in a browser.

### Option 2: PHP built-in server

From the project root, run:

```bash
php -S localhost:8000 server.php
```

Then open [http://localhost:8000/frontend/](http://localhost:8000/frontend/) in a browser. The `server.php` development router serves the frontend and forwards backend requests to the PHP API.