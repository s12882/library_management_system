## Requirements

- PHP 8.3+ with standard extensions (`pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`)
- Composer 2.x
- Node.js 20+ and npm
- MySQL 8.x (or another MySQL-compatible server) running locally

## 1. Install dependencies

```bash
composer install
npm install
```

## 2. Configure the environment

.env:

```bash
cp .env.example .env
```

Application key:

```bash
php artisan key:generate
```

By default `.env` is set up for a local MySQL server:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_management_system
DB_USERNAME=root
DB_PASSWORD=
```

Adjust these to match your local MySQL setup, then create the database ( or skip if already exists):

```bash
mysql -u root -e "CREATE DATABASE library_management_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
```

## 3. Run migrations and seed test data

```bash
php artisan migrate --seed
```

This creates the `authors`, `books`, `readers`, and `loans` tables and seeds realistic, varied test data — enough to exercise pagination on every list page:

- ~18 authors
- ~50 books (real titles, unique ISBNs, 1–8 copies each; several intentionally fully checked out)
- ~25 readers
- ~95 loans, a mix of active and overdue, spread across books and readers

## 4. Build frontend assets

Prod:

```bash
npm run build
```

Dev:

```bash
npm run dev
```

## 5. Serve the application

Start the PHP dev server:

```bash
php artisan serve
```

Or run the PHP server and the Vite dev server in one command:

```bash
composer run dev
```

Open **http://127.0.0.1:8000** in your browser. App redirects `/` to `/books`.
