# Filament App

A Laravel 12 application with Filament 4 admin panel for managing orders, customers, services, and user roles.

## Tech Stack

- **PHP** 8.2+
- **Laravel** 12
- **Filament** 4.2 (Admin Panel)
- **SQLite** (default database)
- **Vite** (frontend bundling)

## Features

- 📦 **Order Management** - Create and manage orders with order details
- 👥 **Customer Management** - Track customer information
- 🛠️ **Services** - Configure available services
- 👤 **User Management** - Manage system users
- 🔐 **Roles & Permissions** - Role-based access control
- 📥 **Bulk Import** - Import data via Filament's import system

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd filament-app
   ```

2. **Run the setup script**
   ```bash
   composer setup
   ```

   This will:
   - Install PHP dependencies
   - Copy `.env.example` to `.env` (if not exists)
   - Generate application key
   - Run database migrations
   - Install NPM dependencies
   - Build frontend assets

3. **Create an admin user**
   ```bash
   php artisan make:filament-user
   ```

## Development

Start the development server with hot-reloading:

```bash
composer dev
```

This runs concurrently:
- Laravel development server (`php artisan serve`)
- Queue worker (`php artisan queue:listen`)
- Vite dev server (`npm run dev`)

### Individual Commands

```bash
# Run Laravel server only
php artisan serve

# Run Vite dev server only
npm run dev

# Run tests
composer test
```

## Project Structure

```
app/
├── Enums/              # Status enums (OrderStatus, OrderDetailStatus)
├── Filament/
│   ├── Imports/        # Import configurations
│   ├── Pages/          # Custom Filament pages
│   └── Resources/      # CRUD resources
│       ├── Customers/
│       ├── Orders/
│       ├── OrderDetails/
│       ├── Roles/
│       ├── Services/
│       └── Users/
├── Models/             # Eloquent models
│   ├── Customer.php
│   ├── Order.php
│   ├── OrderDetail.php
│   ├── Role.php
│   ├── Service.php
│   └── User.php
└── Policies/           # Authorization policies
```

## Admin Panel

Access the Filament admin panel at `/admin` after starting the development server.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
