# AGENTS.md
 
## Project
[FitPulse]: [A responsive single-page web application for managing workout routines, tracking exercises, logging daily nutrition, and viewing high-protein recipes for fitness enthusiasts and trainers.].
Roles: [admin, user]. Entities: [users, workouts, exercises, nutrition_logs, reviews].
 
## Technology stack
- Frontend: HTML, CSS, JavaScript, jQuery, Bootstrap 5, spapp (hash-based SPA router),No frameworks (React/Vue/Angular are NOT allowed).
- Backend: PHP with FlightPHP (REST API), PDO, MySQL
- Local server: XAMPP
- database: MySQL 8.
 
## Folder structure
- frontend/: css/, js/, views/ (one HTML file per view), assets/, index.html          app shell, every <section> in <main id="spapp"> is one view
- backend/: 
  - rest/routes/: thin FlightPHP route files
  - rest/services/: service-layer validation and business rules
  - rest/dao/: PDO database access
  - utils/: exception classes and reusable validation helpers
  - config/: local and example configuration
  - logs/: runtime log files
  - vendor/: Composer dependencies, ignored by Git
- docs/: AI_LOG.md and other documentation
- database/: local MySQL schema and seed data
 
## Frontend rules
- Each view is in its own file in frontend/views/.
- Use Bootstrap 5 classes; avoid inline styles.
 
## Backend rules
- Requests go: route -> service -> DAO -> database.
- Only services call DAO classes. Routes never call DAO classes directly.
- All SQL uses PDO prepared statements.
- Routes return JSON with correct HTTP status codes.
- Route handlers may parse request/query data and call one service method, but must not contain SQL, try/catch blocks, or business rules.
- External API integrations belong in a service. Use a strict timeout and throw `ExternalServiceException` for 503 failures.
- `backend/config/config.php`, `backend/vendor/`, and runtime log files are not committed.

## API conventions
- Entity IDs use numeric FlightPHP path patterns such as `@id:[0-9]+`.
- CRUD collections use `/users`, `/workouts`, `/exercises`, `/nutrition_logs`, and `/reviews`.
- Creation returns HTTP `201`; deletion returns HTTP `200` with a confirmation message.
- Validation errors return `400`, missing entities return `404`, unexpected errors return `500`, and external API failures return `503`.
- OpenAPI JSON is served at `/openapi.json`; Swagger UI is served at `/docs`.
 
## Conventions
- PHP classes: PascalCase (UserService, UserDao). Files are named after the class.
- JavaScript variables: camelCase. PHP variables, database tables, and columns: snake_case.
 
## Rules for AI assistants
- Do not add new libraries or frameworks without asking me first.
- Do not change the database schema without asking me first.
- Never put passwords, keys or secrets in code; they belong in backend/config/config.php,
  which is not committed. Update config.example.php instead.
- Do not edit files in backend/logs/.
- Make small changes and explain what you changed and why.
## Product context

Before implementing features, read:
[docs/project_brief_document.md](docs/project_brief_document.md)