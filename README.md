# Namespaced Laravel Models

This package's sole purpose is to allow setting the default namespace
for the Laravel make:model command and the other commands accepting models as parameters.

* [Installation](#installation)
* [Configuration](#configuration)

## Abandoned
This package is abandoned since this feature is natively supported in Laravel 8 and later

## Installation
You can install this package via composer:

``` bash
composer require netpok/namespaced-laravel-models --dev
```

The service provider will automatically register or you may manually add the
service provider in your ```config/app.php``` file:

``` php
'providers' => [
    // ...
    Netpok\NamespacedLaravelModels\ServiceProvider::class,
];
```

## Configuration
By default this package sets the namespace to Models under your route namespace (App\Models),
but feel free to publish the configuration and set your preferred namespace.

``` bash
php artisan vendor:publish --provider="Netpok\\NamespacedLaravelModels\\ServiceProvider"
```

## Laravel 7 support
Laravel 7 is under heavy development, but the current state (2019-10-24) is supported by the
[next](https://github.com/netpok/namespaced-laravel-models/tree/next) branch.
