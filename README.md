<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Air Reservation System

A modern Laravel-based Air Reservation System with a responsive Bootstrap 5 admin dashboard, DataTables, AJAX CRUD, and multi-currency support.

## Setup Instructions

Follow these steps to set up the app from Git:

### 1. Clone the Repository
```bash
git clone <your-repo-url>.git
cd flight-reservation
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Copy and Configure Environment File
```bash
cp .env.example .env
```
- Edit `.env` to set your database credentials and other settings.

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Run Migrations and Seeders
```bash
php artisan migrate:fresh --seed
```
This will create all tables and seed demo data (cities, flights, customers, currency rates, etc).

### 6. Install Node.js Dependencies and Build Assets
```bash
npm install
npm run build
```

### 7. Start the Development Server
```bash
php artisan serve
```
Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

---

## Features
- Responsive admin dashboard (Bootstrap 5)
- DataTables with AJAX CRUD for all entities
- Multi-currency booking and dynamic currency rates
- Modals for view, edit, create, and print
- SweetAlert2 for confirmations and toasts
- jQuery, Font Awesome, and more

---

## Troubleshooting
- If you change migrations or seeders, re-run `php artisan migrate:fresh --seed`.
- For asset changes, re-run `npm run build`.
- For any issues, check `storage/logs/laravel.log`.

---

## License
MIT
