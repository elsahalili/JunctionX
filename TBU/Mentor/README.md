# UniMatch

UniMatch is a PHP and Bootstrap web application that helps students explore university options based on their interests, CV keywords, and preferred academic direction. The project includes a public landing website, authentication, a student quiz flow, matched university results, meeting scheduling, contact/newsletter forms, and an admin area for managing content.

## Technologies Used

- PHP 8+
- Bootstrap 5
- Bootstrap Icons
- JavaScript
- JSON file storage
- FullCalendar for meeting visualization
- XAMPP or any PHP-compatible local server

## Features

- Modern responsive landing pages for courses, events, mentors, pricing, and contact
- Student registration and login with hashed passwords
- Per-user JSON profile data
- CV upload step with lightweight keyword scoring
- Quiz-based faculty scoring
- Matched university results with detail pages
- Meeting scheduler with calendar view and completion action
- Contact and newsletter forms stored locally as JSON
- Admin login and university management
- Safer JSON API endpoints with allowlisted data types

## Installation

1. Clone or download the project into your web server root.

   ```bash
   git clone <repository-url>
   ```

2. If you use XAMPP, place the folder in:

   ```text
   C:\xampp\htdocs\JunctionX\TBU\Mentor
   ```

3. Start Apache from the XAMPP control panel.

4. Open the app in your browser:

   ```text
   http://localhost/JunctionX/TBU/Mentor/index.php
   ```

## How To Run

- Public website: `index.php`
- Register: `register.php`
- Login: `login.php`
- Student dashboard: `home.php`
- Quiz: `quizPage.php`
- Results: `result.php`
- Admin login: `admin_panel/admin/login.php`

Demo admin credentials are stored in `admin_panel/data/admins.json`. Change them before publishing a live deployment.

## Screenshots

Add screenshots before publishing the repository:

- Home page
- Student dashboard
- Quiz flow
- Matched universities
- Meeting scheduler
- Admin panel

Suggested folder:

```text
assets/img/screenshots/
```

## Deployment Notes

- This project uses JSON files as lightweight storage for portfolio/demo purposes. For production, move users, meetings, form submissions, and admin data to a real database.
- Do not commit real user data. Runtime profile and form-submission files are ignored in `.gitignore`.
- Update `APP_SUPPORT_EMAIL`, `APP_SUPPORT_PHONE`, and `APP_ADDRESS` in `app.php` for your real deployment.
- Replace demo admin credentials with a hashed password before hosting publicly.
- FullCalendar is currently loaded from a CDN on the meeting page. For fully offline deployments, download and serve it locally.

## Project Status

Portfolio-ready demo. The core flows are functional locally with XAMPP/PHP and are structured for future database integration.
