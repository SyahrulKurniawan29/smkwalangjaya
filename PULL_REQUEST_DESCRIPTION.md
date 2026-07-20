## feat(initial-scaffold): scaffold Laravel + Inertia + Vue + basic modules

This pull request adds the initial scaffold for the SMK Walang Jaya school counseling & attendance application.

What's included:
- Laravel project structure placeholders (composer.json, package.json, resources, routes)
- Database migrations & models: roles, users, classrooms, students, attendances, counseling_sessions, counseling_notes, attachments
- Seeders for roles and example users (admin, guru_bk, wali_kelas), 1 classroom & 5 students
- Controllers & routes for Classes, Students, Attendance (bulk), Counseling (sessions & notes)
- Middleware 'role' and basic Policies for access control (CounselingNote, Attendance, ClassRoom)
- Inertia + Vue pages for basic UI (Dashboard, Classes, Students, Attendance, Counseling create/show pages)
- README + .env.example with setup instructions

Checklist before merge:
- [ ] Run composer install and npm install locally
- [ ] Run php artisan migrate --seed and verify seed data
- [ ] Run php artisan breeze:install inertia locally to enable auth scaffolding
- [ ] Run php artisan storage:link if you want file attachments to be served from storage

Testing & Notes:
- Policies are basic and may need customization for detailed school rules (e.g., wali_kelas access to only their class)
- Attachments are stored on the public disk by default; change storage driver for production

