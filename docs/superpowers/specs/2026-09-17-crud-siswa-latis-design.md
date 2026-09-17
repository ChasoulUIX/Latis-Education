# Design Specification: CRUD Siswa Latis Education & Tutor Indonesia

- **Date**: 2026-09-17
- **Project**: Latis-Education
- **Status**: Approved

## 1. Overview
Aplikasi web berbasis Laravel 11++ untuk manajemen data siswa di dua lembaga: **Latis Education** dan **Tutor Indonesia**. Mendukung fitur autentikasi (session management), DataTables interaktif, CRUD data siswa dengan upload foto, export Excel dinamis sesuai filter/pencarian, navigasi sidebar, dan menu profil kandidat.

## 2. Requirements & Constraints
1. **Framework**: Laravel 11++ (saat ini Laravel 13).
2. **CSS Library**: Tailwind CSS.
3. **Session Management**: Session auth (Login, Logout, Auth Middleware).
4. **Database**: MySQL dengan Prepared Statements pada query.
5. **Kriteria Siswa**:
   - Lembaga: Dropdown relasi tabel `institutions` (Latis Education, Tutor Indonesia).
   - NIS: Required, unik, angka.
   - Nama Siswa: Required.
   - Email: Required, format email valid.
   - Foto: Format JPG & PNG, ukuran maksimal 100KB.
6. **DataTables (datatables.net)**:
   - Action button Edit & Delete.
   - Paginasi data.
   - Search: hanya mencari di kolom NIS dan Nama Siswa.
   - Filter dropdown lembaga (dinamis dari database).
7. **Ekspor Excel**:
   - Menampilkan data siswa sesuai filter & search aktif saat itu.
8. **Sidebar Navigation**:
   - Menu: Siswa, Profile, Logout.
9. **Menu Profile**:
   - Nama kandidat, Position kandidat, Image kandidat.

## 3. Architecture & Database Design

### 3.1 Database Tables
1. `users`
   - `id` (BIGINT PK)
   - `name` (VARCHAR)
   - `email` (VARCHAR UNIQUE)
   - `password` (VARCHAR)
   - `position` (VARCHAR, default: "Fullstack Developer")
   - `image` (VARCHAR nullable)
   - `remember_token` (VARCHAR nullable)
   - `created_at`, `updated_at`

2. `institutions`
   - `id` (BIGINT PK)
   - `name` (VARCHAR: "Latis Education", "Tutor Indonesia")
   - `created_at`, `updated_at`

3. `students`
   - `id` (BIGINT PK)
   - `institution_id` (BIGINT FK -> institutions.id)
   - `nis` (VARCHAR UNIQUE, numeric validation)
   - `name` (VARCHAR)
   - `email` (VARCHAR)
   - `photo` (VARCHAR nullable)
   - `created_at`, `updated_at`

### 3.2 Security & Query Execution
- Semua interaksi query menggunakan Eloquent / Query Builder Laravel berparameter (PDO prepared statements) untuk mencegah SQL Injection.
- Proteksi CSRF di seluruh form action.
- Validasi file upload: `mimes:jpg,jpeg,png` dan `max:100` (100KB).

## 4. Components & Flow

### 4.1 Auth & Session
- `AuthController`:
  - `loginView()` -> render login blade
  - `login()` -> `Auth::attempt()`, regenerate session, redirect ke `/students`
  - `logout()` -> `Auth::logout()`, invalidate session, regenerate CSRF token

### 4.2 Student Management (CRUD & DataTables)
- `StudentController`:
  - `index()`: Menampilkan view DataTables + list lembaga untuk filter.
  - `data(Request $request)`: Endpoint AJAX JSON untuk DataTables server-side / client-side format dengan filter lembaga dan search pada NIS & Nama.
  - `create()` & `store(StoreStudentRequest $request)`: Form & simpan siswa + upload foto (max 100KB).
  - `edit(Student $student)` & `update(UpdateStudentRequest $request, Student $student)`: Form edit & update.
  - `destroy(Student $student)`: Hapus siswa beserta file foto.
  - `export(Request $request)`: Download Excel sesuai query pencarian/filter lembaga aktif.

### 4.3 Profile Management
- `ProfileController`:
  - `index()`: Tampilkan profil kandidat (Nama, Posisi, Foto).
  - `update(Request $request)`: Update nama, posisi, dan foto profil kandidat.

## 5. UI / Layout (Tailwind CSS)
- `layouts.app`: Layout utama dengan sidebar navigasi (Siswa, Profile, Logout) dan topbar responsive.
- Responsive mobile & desktop dengan styling rapi dan modern.
- DataTables integrasi Tailwind CSS styling.

## 6. Testing & Validation Strategy
- Unit & Feature tests via PHPUnit/Pest:
  - Auth test (login, logout, session protection).
  - Student CRUD test with validation rules (NIS unique & numeric, email valid, photo max 100KB).
  - Export test (filtered dataset vs all dataset).
  - Profile update test.
