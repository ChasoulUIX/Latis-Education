# CRUD Siswa Latis Education & Tutor Indonesia Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Membangun aplikasi web CRUD data siswa terintegrasi MySQL, DataTables interaktif, filter lembaga (Latis Education & Tutor Indonesia), ekspor Excel dinamis, autentikasi session, sidebar navigasi, dan halaman profil kandidat dengan Laravel 11++ dan Tailwind CSS.

**Architecture:** Model-View-Controller (MVC) Laravel standar menggunakan Eloquent/PDO prepared statements. Blade templates ber-styling Tailwind CSS mengintegrasikan DataTables jQuery & DataTables search/filter API. Autentikasi berbasis session dengan middleware `auth`.

**Tech Stack:** Laravel 13 (PHP 8.3+), MySQL, Tailwind CSS v4, DataTables.net, Maatwebsite/Excel 4.x (PhpSpreadsheet), PHPUnit.

**Spec:** `docs/superpowers/specs/2026-09-17-crud-siswa-latis-design.md`

## Global Constraints
- Laravel 11++ (proyek saat ini Laravel 13).
- CSS menggunakan Tailwind CSS.
- Wajib menerapkan session management (Login/Logout/Auth Middleware).
- MySQL database dengan Prepared Statements pada semua query.
- Validasi Siswa:
  - Lembaga: Dropdown dari database (`institutions`).
  - NIS: Required, unik, angka.
  - Nama: Required string.
  - Email: Required, email valid.
  - Foto: Required/nullable saat update, format JPG/PNG, ukuran maksimal 100KB (`max:100`).
- DataTables: Action edit/delete, paginasi, search HANYA pada kolom NIS & Nama, filter dropdown lembaga dari database.
- Ekspor Excel: Menampilkan data siswa sesuai hasil filter lembaga & pencarian aktif.
- Sidebar Navigasi: Siswa, Profile, Logout.
- Menu Profile: Nama kandidat, Posisi kandidat, Foto kandidat.

---

### Task 1: Database Migrations, Models, & Seeders

**Files:**
- Create: `database/migrations/2026_09_17_000001_add_profile_fields_to_users_table.php`
- Create: `database/migrations/2026_09_17_000002_create_institutions_table.php`
- Create: `database/migrations/2026_09_17_000003_create_students_table.php`
- Create: `app/Models/Institution.php`
- Create: `app/Models/Student.php`
- Modify: `app/Models/User.php`
- Create: `database/seeders/DatabaseSeeder.php`
- Test: `tests/Feature/DatabaseSetupTest.php`

**Interfaces:**
- Produces: `Institution` model (`id`, `name`), `Student` model (`id`, `institution_id`, `nis`, `name`, `email`, `photo`), `User` model (`position`, `image`).

- [ ] **Step 1: Write test for Database Models and Migrations**
Create `tests/Feature/DatabaseSetupTest.php` to verify institution seeding, student model relations, and user profile fields.

- [ ] **Step 2: Run test to verify it fails**
Run: `php artisan test --filter=DatabaseSetupTest`

- [ ] **Step 3: Create migrations, models, and seeders**
Implement migrations with foreign keys, indexes, and fillables on models. Seed default institutions ("Latis Education", "Tutor Indonesia") and default admin candidate user.

- [ ] **Step 4: Run migrations and test**
Run: `php artisan migrate:fresh --seed && php artisan test --filter=DatabaseSetupTest`
Expected: PASS

- [ ] **Step 5: Commit**
`git add database/ app/Models/ tests/Feature/DatabaseSetupTest.php && git commit -m "feat(db): add institutions, students, and user profile migrations with seeders"`

---

### Task 2: Auth & Session Management

**Files:**
- Create: `app/Http/Controllers/AuthController.php`
- Create: `resources/views/auth/login.blade.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/AuthTest.php`

**Interfaces:**
- Produces: `GET /login`, `POST /login`, `POST /logout` routes with session handling (`Auth::attempt()`, session regeneration, session invalidation).

- [ ] **Step 1: Write failing test for Authentication**
Test login with valid/invalid credentials, session protection on `/students` and `/profile`, and logout session invalidation.

- [ ] **Step 2: Run test to verify it fails**
Run: `php artisan test --filter=AuthTest`

- [ ] **Step 3: Implement AuthController and login view**
Build `AuthController` (`loginForm`, `login`, `logout`) with Tailwind CSS login view. Protect routes with `auth` middleware.

- [ ] **Step 4: Run test to verify it passes**
Run: `php artisan test --filter=AuthTest`
Expected: PASS

- [ ] **Step 5: Commit**
`git add app/Http/Controllers/AuthController.php resources/views/auth/ routes/web.php tests/Feature/AuthTest.php && git commit -m "feat(auth): implement session login, logout, and auth middleware"`

---

### Task 3: Base Layout & Sidebar Navigation

**Files:**
- Create: `resources/views/layouts/app.blade.php`
- Create: `resources/views/layouts/sidebar.blade.php`
- Create: `resources/views/layouts/navbar.blade.php`
- Modify: `resources/css/app.css`
- Test: `tests/Feature/NavigationTest.php`

**Interfaces:**
- Produces: Reusable blade layout with active menu indicator for Sidebar (Siswa, Profile, Logout) and responsive mobile navigation.

- [ ] **Step 1: Write failing test for navigation layout**
Test rendered sidebar contains links to Siswa (`/students`), Profile (`/profile`), and Logout button.

- [ ] **Step 2: Run test to verify it fails**
Run: `php artisan test --filter=NavigationTest`

- [ ] **Step 3: Implement layout, sidebar, and navbar Blade components**
Include Tailwind styling, FontAwesome / Lucide icons (SVG), toast/flash alerts for session notifications.

- [ ] **Step 4: Run test to verify it passes**
Run: `php artisan test --filter=NavigationTest`
Expected: PASS

- [ ] **Step 5: Commit**
`git add resources/views/layouts/ tests/Feature/NavigationTest.php && git commit -m "feat(ui): create base layout and responsive sidebar navigation"`

---

### Task 4: Student CRUD Backend & Requests (Prepared Statements)

**Files:**
- Create: `app/Http/Requests/StoreStudentRequest.php`
- Create: `app/Http/Requests/UpdateStudentRequest.php`
- Create: `app/Http/Controllers/StudentController.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/StudentCrudTest.php`

**Interfaces:**
- Produces: `StudentController` CRUD methods (`index`, `create`, `store`, `edit`, `update`, `destroy`) using PDO prepared statement bindings, photo upload handler (JPG/PNG <= 100KB, stored in `storage/app/public/students`).

- [ ] **Step 1: Write failing tests for Student CRUD & Validation**
Test NIS validation (required, unique, numeric), email validation, photo format/size (max 100KB), create, update, and delete actions.

- [ ] **Step 2: Run test to verify it fails**
Run: `php artisan test --filter=StudentCrudTest`

- [ ] **Step 3: Implement FormRequests and StudentController logic**
Implement strict validation rules, photo storage deletion on update/delete, and database transactions with parameterized queries.

- [ ] **Step 4: Run test to verify it passes**
Run: `php artisan test --filter=StudentCrudTest`
Expected: PASS

- [ ] **Step 5: Commit**
`git add app/Http/Requests/ app/Http/Controllers/StudentController.php routes/web.php tests/Feature/StudentCrudTest.php && git commit -m "feat(students): implement student CRUD controller and request validations"`

---

### Task 5: Student DataTables View & Realtime Filter

**Files:**
- Create: `resources/views/students/index.blade.php`
- Modify: `app/Http/Controllers/StudentController.php`
- Test: `tests/Feature/StudentDataTablesTest.php`

**Interfaces:**
- Produces: DataTables view with:
  - Custom institution filter dropdown populated from database.
  - Search input restricted to columns NIS & Nama Siswa.
  - Action edit and delete buttons with confirmation modal.
  - Server-side / Client-side AJAX endpoint `GET /students/data`.

- [ ] **Step 1: Write failing test for DataTables data endpoint & filtering**
Test endpoint returns filtered JSON by institution and keyword search specifically matching NIS and Name.

- [ ] **Step 2: Run test to verify it fails**
Run: `php artisan test --filter=StudentDataTablesTest`

- [ ] **Step 3: Implement DataTables view and AJAX endpoint**
Integrate DataTables CSS & JS, configure columnDefs, custom search filtering on NIS (column index) and Nama (column index), institution filter event listener.

- [ ] **Step 4: Run test to verify it passes**
Run: `php artisan test --filter=StudentDataTablesTest`
Expected: PASS

- [ ] **Step 5: Commit**
`git add resources/views/students/index.blade.php app/Http/Controllers/StudentController.php tests/Feature/StudentDataTablesTest.php && git commit -m "feat(datatables): integrate DataTables with institution filter and NIS/Name search"`

---

### Task 6: Student Create & Edit Views

**Files:**
- Create: `resources/views/students/create.blade.php`
- Create: `resources/views/students/edit.blade.php`
- Test: `tests/Feature/StudentViewsTest.php`

**Interfaces:**
- Produces: Form views with institution dropdown from database, NIS numeric input, Nama, Email, and File upload with preview & 100KB validation warning.

- [ ] **Step 1: Write failing test for Create and Edit views rendering**
Verify views render institution options from DB and old input data / validation error messages.

- [ ] **Step 2: Run test to verify it fails**
Run: `php artisan test --filter=StudentViewsTest`

- [ ] **Step 3: Build Create and Edit Blade views**
Styled with Tailwind CSS, file input client-side size check (100KB), error states, and responsive layout.

- [ ] **Step 4: Run test to verify it passes**
Run: `php artisan test --filter=StudentViewsTest`
Expected: PASS

- [ ] **Step 5: Commit**
`git add resources/views/students/create.blade.php resources/views/students/edit.blade.php tests/Feature/StudentViewsTest.php && git commit -m "feat(views): create student add and edit forms with institution dropdown and photo preview"`

---

### Task 7: Excel Export Feature

**Files:**
- Create: `app/Exports/StudentsExport.php`
- Modify: `app/Http/Controllers/StudentController.php`
- Modify: `resources/views/students/index.blade.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/StudentExportTest.php`

**Interfaces:**
- Produces: `GET /students/export` accepting query parameters `institution_id` and `search` to generate styled `.xlsx` file containing filtered student list.

- [ ] **Step 1: Write failing test for Excel Export**
Test export file download response and verify exported records match filter (all students when unfiltered, specific institution when filtered, specific search result when searched).

- [ ] **Step 2: Run test to verify it fails**
Run: `php artisan test --filter=StudentExportTest`

- [ ] **Step 3: Implement StudentsExport class and Controller export method**
Use `Maatwebsite\Excel` (or `PhpSpreadsheet`) with prepared query builder applying the exact `search` and `institution_id` parameters.

- [ ] **Step 4: Run test to verify it passes**
Run: `php artisan test --filter=StudentExportTest`
Expected: PASS

- [ ] **Step 5: Commit**
`git add app/Exports/StudentsExport.php app/Http/Controllers/StudentController.php routes/web.php tests/Feature/StudentExportTest.php && git commit -m "feat(export): add dynamic Excel export matching active filter and search query"`

---

### Task 8: Candidate Profile Menu

**Files:**
- Create: `app/Http/Controllers/ProfileController.php`
- Create: `resources/views/profile/index.blade.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/ProfileTest.php`

**Interfaces:**
- Produces: `GET /profile` and `POST/PUT /profile` showing and updating candidate name, candidate position, and candidate image.

- [ ] **Step 1: Write failing test for Profile view and update**
Test profile page displays candidate name, position, image, and allows updating profile details and image upload.

- [ ] **Step 2: Run test to verify it fails**
Run: `php artisan test --filter=ProfileTest`

- [ ] **Step 3: Implement ProfileController and Blade view**
Display candidate information card and update form with Tailwind CSS styling and avatar upload handling.

- [ ] **Step 4: Run test to verify it passes**
Run: `php artisan test --filter=ProfileTest`
Expected: PASS

- [ ] **Step 5: Commit**
`git add app/Http/Controllers/ProfileController.php resources/views/profile/ routes/web.php tests/Feature/ProfileTest.php && git commit -m "feat(profile): implement candidate profile page with position and photo update"`

---

### Task 9: Build Assets, Storage Symlink, & Full Suite Verification

**Files:**
- Modify: `package.json` / `vite.config.js` / assets if needed
- Test: All feature & unit test suites

- [ ] **Step 1: Create storage symlink**
Run: `php artisan storage:link`

- [ ] **Step 2: Build frontend assets**
Run: `npm run build`

- [ ] **Step 3: Run entire test suite**
Run: `php artisan test`
Expected: All tests PASS.

- [ ] **Step 4: Seed sample students for demo & manual review**
Create `database/seeders/StudentSeeder.php` with sample students for Latis Education and Tutor Indonesia.
Run: `php artisan db:seed --class=StudentSeeder`

- [ ] **Step 5: Final commit & documentation sync**
Commit all assets and verify all requirements fulfilled.
