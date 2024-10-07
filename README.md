# Laravel Geography

The Laravel Languages package provides a ready-to-use list of languages for your Laravel application. This package simplifies the task of managing languages across your app, allowing you to easily retrieve language codes (alpha-2, alpha-3) and names for a variety of purposes like localization, language selection in forms, or general language-related data management.

## Setup

- Install

```bash
composer require dazza-dev/laravel-geography
```

- Publish migrations and seeders

```php
php artisan vendor:publish --tag="laravel-geography"
```

- Run migrations and seeders

```php
php artisan migrate
php artisan db:seed --class=GeographySeeder
```

## Usage

- Get all Languages

```php
use DazzaDev\Languages\Facades\Languages;

Languages::all();
```

- Get only active languages

```php
use DazzaDev\Languages\Facades\Languages;

Languages::active();
```

- Get language by code

```php
use DazzaDev\Languages\Facades\Languages;

Languages::getByCode('en'); // Returns English
Languages::getByCode('eng'); // Also returns English
```

- Activate language by code or name

```php
use DazzaDev\Languages\Facades\Languages;

Languages::activate('en');
Languages::activate('eng');
```

- Deactivate language by code or name

```php
use DazzaDev\Languages\Facades\Languages;

Languages::deactivate('en');
Languages::deactivate('eng');
```

## Contributions

Contributions are welcome. If you find any bugs or have ideas for improvements, please open an issue or send a pull request. Make sure to follow the contribution guidelines.

## Author

Laravel Languages was created by [DAZZA](https://github.com/dazza-dev).

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
