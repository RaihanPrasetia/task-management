# Task Management System

Sistem manajemen tugas internal untuk memantau pekerjaan harian dari tim seperti IT, HR, dan Operasional. Dibangun dengan Laravel dan Filament Admin Panel.

## Deskripsi

Sistem ini memungkinkan perusahaan melacak tugas, mengelompokkan tugas berdasarkan proyek, dan menampilkan ringkasan status pekerjaan setiap user dan project. Dilengkapi dengan Role-Based Access Control untuk keamanan dan manajemen hak akses.

## Prasyarat

- PHP >= 8.1
- Composer
- Node.js & NPM
- Database (MySQL, PostgreSQL, atau SQLite)
- Git

## Langkah-Langkah Instalasi

### 1. Clone Repository dan Masuk ke Direktori Project

```bash
git clone [URL_REPOSITORY]
cd task-management
```

### 2. Install Dependencies PHP

```bash
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Buka file `.env` dan sesuaikan konfigurasi database:

#### Jika menggunakan SQLite:
1. Buat file database kosong:
```bash
touch database/database.sqlite
```

2. Edit konfigurasi database di `.env`:
```
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

#### Jika menggunakan MySQL/PostgreSQL:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=username_database
DB_PASSWORD=password_database
```

### 5. Migrasi Database dan Seeding

```bash
php artisan migrate
php artisan db:seed
```

### 6. Setup Filament Shield (RBAC)

Instal dan konfigurasi Shield:
```bash
php artisan shield:install
```
Ketik `admin` saat diminta untuk memilih guard.

### 7. Buat Permission untuk Resources

```bash
php artisan shield:generate --resource=AssignUserResource
php artisan shield:generate --resource=TaskResource
php artisan shield:generate --resource=UserResource
php artisan shield:generate --resource=ProjectResource
```

### 8. Buat Role Super Admin

```bash
php artisan shield:super-admin --user=1
```

### 9. Jalankan Aplikasi

```bash
php artisan serve
```

Sistem akan berjalan di `http://localhost:8000`

## Akses Sistem

### Administrator
- URL: `http://localhost:8000/task-management`
- Username: `admin`
- Password: `12345678`

### Manager
- URL: `http://localhost:8000/task-management`
- Username: `manager`
- Password: `12345678`

### User
- URL: `http://localhost:8000/task-management`
- Username: `user`
- Password: `12345678`

## Fitur Utama

- **Manajemen Project**: Mengelola semua proyek perusahaan
- **Manajemen Task**: Membuat dan mengelola tugas yang terkait dengan proyek
- **Dashboard**: Visualisasi status tugas berdasarkan pengguna dan proyek
- **Manajemen Hak Akses**: Mengelola peran dan izin pengguna

## Pengaturan Hak Akses

Admin dapat mengatur hak akses setiap peran melalui menu Roles. Pastikan untuk mengatur hak akses sesuai dengan kebutuhan organisasi Anda.

## Pemecahan Masalah

Jika mengalami masalah, coba langkah-langkah berikut:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

Jika ada masalah dengan permission direktori:
```bash
chmod -R 775 storage bootstrap/cache
```
