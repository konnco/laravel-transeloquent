# Laravel Transeloquent

**If you want the faster way to translate your model and store it in a single table, this package is built for you.**

This is a Laravel package for translatable models. Its goal is to remove the complexity in retrieving and storing multilingual model instances. With this package you write less code, as the translations are being fetched/saved when you fetch/save your instance.

Maybe out there there's so many package that work the same way, and has more performance, but the purpose this package is make your development time faster.

***This package is still in alpha version, so the update may broke your application.***

## Installation
```php
composer require konnco/laravel-transeloquent
```

```php
php artisan vendor:publish
```

```php
php artisan migrate
```

## Configuration
add this configuration into your `config/app.php`
```php
/*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */
    
    'locale' => 'en',
    
    'transeloquent' => [
        // default locale for model
        'model_locale' => 'en'
    ],
```

Add transeloquent traits into your model

```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model {
    use \konnco\Transeloquent\Transeloquent;
}
```

and the default excluded field is `id`, `created_at`, `updated_at` these fields will not saved into database.

if you want to add more excluded field you may have to add `$transeloquentExcluded` into your model.

```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use konnco\Transeloquent\Transeloquent;

class News extends Model {
    use Transeloquent;
    
    protected $transeloquentExcluded = ['dont-translate-1','dont-translate-2'];
}
```

## Quick Example
### Getting translated attributes
Original Attributes In English or based on configuration in `app.transeloquent.default_locale`
```php
//in the original language
$post = Post::first();
echo $post->title; // My first post
```
---
Translated attributes
```php
App::setLocale('id');
$post = Post::first();
echo $post->title; // Post Pertama Saya
```

### Saving translated attributes
To save translation you must have the initial data.

for example you want to save indonesian translation.
```php
App::setLocale('id');
$post = Post::first();
$post->title = "Post Pertama Saya";
$post->save();
```

it will directly save your translation into database.

## Authors

* **Franky So** - *Initial work* - [Konnco](https://github.com/konnco)
