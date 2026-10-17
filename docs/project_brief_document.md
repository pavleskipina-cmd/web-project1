# Project Brief: FitPulse (Smart Fitness & Workout Tracker)

## 1. Project Name and Purpose
- **Project Name:** FitPulse
- **Purpose:** FitPulse is a responsive single-page web application (SPA) designed to help fitness enthusiasts track their workout routines, log daily nutrition, and manage custom exercise plans. It bridges the gap between structured workout tracking and daily meal planning by integrating high-protein recipe recommendations from an external API.

## 2. Target Users
- **Gym Goers & Fitness Enthusiasts:** Individuals looking for a structured, digitized way to track their daily exercise routines, sets, reps, and nutrition logs.
- **Personal Trainers / Admins:** Application administrators who manage exercise databases, curate workout templates, manage user accounts, and review platform feedback.

## 3. Main User Flows
- **User Flow:**
  1. **Authentication:** User registers or logs in via a single-page modal/view.
  2. **Dashboard Overview:** User views recent workout stats, daily calorie intake summaries, and quick links.
  3. **Workout Management:** User browses available workout routines, logs completed exercises, sets, reps, and weights.
  4. **Nutrition Logging:** User logs daily meals and calorie/protein intake.
  5. **Recipe Discovery:** User accesses the external recipe feature (powered by TheMealDB) to search for meal ideas based on high-protein or health criteria.
  6. **Feedback/Reviews:** User submits feedback or reviews on specific workout routines.

- **Admin Flow:**
  1. **Admin Login:** Accesses extended administrative controls based on JWT user role.
  2. **Entity Management (CRUD):** Admin creates, updates, or deletes global exercise definitions, workout templates, and manages registered user accounts.
  3. **System Logs Review:** Admin monitors application logs and activity.

## 4. Roles and Permissions
- **Admin:**
  - Full CRUD access to all 5 entities (`users`, `workouts`, `exercises`, `nutrition_logs`, `reviews`).
  - Ability to create global workout templates and manage system settings.
  - Access to admin dashboards and analytics.
- **User (Client):**
  - Read access to global exercise lists and workout templates.
  - Full CRUD access to their *own* data (`nutrition_logs`, personal custom `workouts`, personal `reviews`).
  - Read access to external recipe data.

## 5. Required Pages / Views (SPA Components)
- `views/login.html`: Unified authentication form (Login / Registration toggle).
- `views/dashboard.html`: Personalized dashboard showing activity summary, quick stats, and recent logs.
- `views/workouts.html`: View and filter workout plans; log completed exercises.
- `views/exercises.html`: Searchable library of exercise movements with instructions.
- `views/nutrition.html`: Daily food/calorie log with external API high-protein recipe finder.
- `views/reviews.html`: Community/workout ratings and feedback management.
- `views/admin.html`: User and system management view (restricted to Admin role).

## 6. Important Entities and Data (Database Schema Concept)
1. **`users`**
   - Fields: `id`, `name`, `email`, `password_hash`, `role` (`admin`/`user`), `created_at`
2. **`workouts`**
   - Fields: `id`, `user_id` (FK), `title`, `description`, `category` (e.g., Strength, Cardio), `created_at`
3. **`exercises`**
   - Fields: `id`, `workout_id` (FK), `name`, `muscle_group`, `default_sets`, `default_reps`
4. **`nutrition_logs`**
   - Fields: `id`, `user_id` (FK), `meal_type`, `calories`, `protein_grams`, `date`
5. **`reviews`**
   - Fields: `id`, `user_id` (FK), `workout_id` (FK), `rating` (1-5), `comment`, `created_at`

## 7. Design Direction
- **Framework:** Bootstrap 5 (dark/modern dashboard theme using SB Admin 2 style structure).
- **Usability:** Mobile-first responsive layout with clean sidebar navigation.
- **Interactivity:** Dynamic SPA view swapping using Vanilla JavaScript and jQuery AJAX without full page reloads.

## 8. Features in Scope
- Single Page Application (SPA) modular routing.
- Complete RESTful API built on FlightPHP.
- PDO MySQL database interaction across all 5 entities with prepared statements.
- Role-based Access Control (RBAC) via JWT middleware.
- Request logging (`info.log`) and error handling middleware (`error.log`).
- External API integration: **TheMealDB API** (fetching recipe details and ingredient lists directly into the UI).
- Client-side and server-side form validations.

## 9. Features Intentionally Out of Scope
- Real-time WebSocket notifications or chat features.
- OAuth / Social Login integrations (Google, Facebook logins).
- Complex payment/subscription gateways.
- Advanced video upload hosting for exercises.

## 10. Backend / API Expectations
- Built using **FlightPHP** framework with PHP 8.x.
- Modular layered architecture: `Route -> Service -> DAO -> Database`.
- OpenAPI / Swagger documentation accessible via UI endpoint.
- All database credentials, secrets, and API keys managed in uncommitted `backend/config/config.php` (template provided via `config.example.php`).

## 11. Future Plans and Assumptions
- **Assumptions:** All operations will run locally under XAMPP during early development and deploy to cloud hosting (e.g., DigitalOcean / Heroku) for Milestone 5.
- **Future Enhancements:** exported PDF workout history reports.