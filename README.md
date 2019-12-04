# Laravel Transeloquent

**If you want the faster way to translate your model and store it in a single table, this package is built for you.**

[![Build Status](https://travis-ci.org/Konnco/laravel-transeloquent.svg?branch=master)](https://travis-ci.org/Konnco/laravel-transeloquent)
[![Latest Stable Version](https://poser.pugx.org/konnco/laravel-transeloquent/v/stable)](https://packagist.org/packages/konnco/laravel-transeloquent)
[![Total Downloads](https://poser.pugx.org/konnco/laravel-transeloquent/downloads)](https://packagist.org/packages/konnco/laravel-transeloquent)
[![Latest Unstable Version](https://poser.pugx.org/konnco/laravel-transeloquent/v/unstable)](https://packagist.org/packages/konnco/laravel-transeloquent)
[![License](https://poser.pugx.org/konnco/laravel-transeloquent/license)](https://packagist.org/packages/konnco/laravel-transeloquent)
[![StyleCI](https://github.styleci.io/repos/225027362/shield?branch=master)](https://github.styleci.io/repos/225027362)

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
    'transeloquent' => [
        // default locale for model
        'model_locale' => 'en'
    ],
```

below this section

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

if you want to add only some fields to be translated, you may have to add `$onlyFields` into your model.
```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use konnco\Transeloquent\Transeloquent;

class News extends Model {
    use Transeloquent;
    
    protected $onlyFields = ['only-translate-1', 'only-translate-2'];
}
```

if you want to add more excluded field from translated, you may have to add `$excludeFields` into your model.

```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use konnco\Transeloquent\Transeloquent;

class News extends Model {
    use Transeloquent;
    
    protected $excludeFields = ['dont-translate-1', 'dont-translate-2'];
}
```
**Note** : If you have set `$onlyFields` variable, it will be executed first. Make sure you don't use `$onlyFields` variable in your model if you want to use `$excludeFields` variable.

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

// or set locale for specific model

$post = Post::first();
$post->setLocale('id')
$post->title = "Post Pertama Saya";
$post->save();
```

### Checking if Translation Available
```php
$post = Post::first();
$post->translationExist('id'); //return boolean
```

## Authors

* **Franky So** - *Initial work* - [Konnco](https://github.com/konnco)
* **Rizal Nasution** - *Initial work* - [Konnco](https://github.com/konnco)
