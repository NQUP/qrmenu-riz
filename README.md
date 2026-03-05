# QR Menu Riz

Aplikasi QR Menu berbasis Laravel untuk manajemen menu dan pemesanan.

## Stack

- Laravel
- MySQL
- Vite

## Menjalankan Project

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
npm install
npm run dev
php artisan serve
```

## Login Admin

- URL admin: `http://127.0.0.1:8000/admin`
- Email (dev): `admin@qrmenu.local`
- Password (dev): `admin12345`

Jika akun belum ada, jalankan:

```bash
php artisan tinker
```

Lalu paste:

```php
\App\Models\User::updateOrCreate(
    ['email' => 'admin@qrmenu.local'],
    ['name' => 'Admin', 'password' => 'admin12345']
);
```

## Repository

- Owner: NQUP (RIZQI AL FAREZA)
- Email: rizqialfareza07@gmail.com
- URL: https://github.com/NQUP/qrmenu-riz.git

## License

**MIT License.**
