# AI Log

## Milestone 1

### Tools and tasks
- **Tool:** github Copilot
- **Model:** Backend
- **Task:** make a footer in the index.html file
- **Main prompt:** "Add a footer to frontend/views/index.html"
- **What was generated:** A simple footer.
- **What the student kept, changed, or rejected:** Rejected the whole prompt.

- **Tool:** GitHub Copilot
- **Model:** Frontend
- **Task:** Add SPA routing and linking template pages
- **Main prompt:** "Create the following static views inside frontend/views/: dashboard.html: Summary cards (total workouts, calories logged, active plans) and placeholder charts. workouts.html: A static Bootstrap data table displaying sample workout routines with 'Add', 'Edit', and 'Delete' buttons. exercises.html: A static grid/table layout listing sample exercises with muscle group tags. nutrition.html: A daily macro and calorie tracking view with a section designated for displaying external API recipe suggestions (TheMealDB integration placeholder). profile.html: A user profile and settings form."
- **What was generated:** The requested static pages.
- **What the student kept, changed, or rejected:** Kept the newly created pages; discarded most templated pages because they were not needed.

### Where the AI was wrong
- The Backend agent should not have made changes to the frontend part of the project; this violated the agent's scope rules.
- The issue was noticed because the requested change targeted `frontend/views/index.html`, even though the agent was a backend agent.
- The generated change was rejected and not kept.

- **What was wrong:** Some CSS and asset links were broken because the files were in different directories.
- **How it was noticed:** The pages were checked manually and reviewed after each prompt.
- **How it was fixed:** The reviewer provided detailed bullet-point feedback, which was given to the Frontend agent to correct the links.
