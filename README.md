# 📘 Soli LMS - Modular Laravel Project

**Soli LMS** is a collaborative Learning Management System designed using a custom modular architecture in Laravel. It allows developers to build independent functional packages and plug them into the system seamlessly.

---

## 📂 Project Structure

Your project uses a custom modular system. All modules live under the `modules/` directory.

Example:
```

modules/
├── Core/
│   └── App/
│       ├── Controllers/
│       ├── Models/
│       ├── Services/
│       ├── Requests/
│       ├── Routes/
│       ├── Providers/
│       └── ...
├── PkgSanction/
│   └── App/
│       ├── Controllers/
│       ├── Models/
│       ├── Services/
│       ├── Requests/
│       ├── Routes/
│       └── ...

```

Each module follows a Laravel-like internal structure:
- **App/** → Contains MVC components and services.
- **Routes/** → Defines module-specific routes (e.g., `web.php`, `api.php`).
- **Resources/** → For module views, translations, assets.
- **Database/** → For migrations, seeders, factories.

---

## 🧩 How to Create a New Module

To add your own module:

1. Inside `modules/`, create a new folder (e.g., `PkgExample`).

2. Follow this folder structure:
```

modules/PkgExample/
└── App/
├── Controllers/
├── Models/
├── Services/
├── Requests/
├── Providers/
├── Routes/
└── ...

````

3. Create a `ServiceProvider` in `App/Providers/ExampleServiceProvider.php` and register it.

4. In the service provider, load routes, views, and translations:
```php
public function boot()
{
    $this->loadRoutesFrom(__DIR__.'/../../Routes/web.php');
    $this->loadViewsFrom(__DIR__.'/../../Resources/views', 'pkgexample');
    $this->loadTranslationsFrom(__DIR__.'/../../Resources/lang', 'pkgexample');
}
````

5. Register your service provider in `config/app.php` or via a module auto-loader if implemented.

---

## 🧑‍💻 Installation Guide

1. Clone the repository:

```bash
git clone https://github.com/your-org/soli-lms.git
cd soli-lms
```

2. Install dependencies:

```bash
composer install
npm install && npm run dev
```

3. Configure `.env` and set up your database:

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate
```

---

## 🧠 Developer Guidelines

* Create your module in `/modules/PkgYourFeatureName`.
* Avoid editing `Core` unless necessary.
* Follow Laravel coding standards.
* Use `render()` for Blade views or Inertia components.
* Use services to isolate business logic.

---

## 📚 Existing Modules

| Module      | Description                                  |
| ----------- | -------------------------------------------- |
| Core        | Shared logic, base classes, helpers          |
| PkgSanction | Handles sanction rules and application logic |
| ...         | Other packages are welcome to be integrated  |

---

## 📜 License

This project is licensed under the MIT License.

---

## 🤝 Contributing

> Everyone is welcome to contribute! Just follow these steps:

1. Fork the repo
2. Create a new branch: `git checkout -b feature/YourFeature`
3. Commit your changes
4. Push and create a Pull Request
