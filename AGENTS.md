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
- backend/: routes/, services/, dao/, middleware/, config/, logs/
- docs/: AI_LOG.md and other documentation
 
## Frontend rules
- Each view is in its own file in frontend/views/.
- Use Bootstrap 5 classes; avoid inline styles.
 
## Backend rules
- Requests go: route -> service -> DAO -> database.
- Only services call DAO classes. Routes never call DAO classes directly.
- All SQL uses PDO prepared statements.
- Routes return JSON with correct HTTP status codes.
 
## Conventions
- PHP classes: PascalCase (UserService, UserDao). Files are named after the class.
- JavaScript and PHP variables: camelCase. Database tables and columns: snake_case.
 
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