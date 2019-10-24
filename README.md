# Namespaced Laravel Models

This package's sole purpose is to allow setting the default namespace
for the Laravel make:model command.

* [Installation](#installation)
* [Configuration](#configuration)

## Installation
You can install this package via composer:

``` bash
composer require netpok/namespaced-laravel-models
```

The service provider will automatically register or you may manually add the
service provider in your ```config/app.php``` file:

``` php
'providers' => [
    // ...
    Netpok\\NamespacedLaravelModels\\ModelMakeServiceProvider::class,
];
```

## Configuration
By default this package sets the namespace to Models, but feel free to
publish the configuration and set your preferred namespace.

``` bash
php artisan vendor:publish --provider="Netpok\NamespacedLaravelModels\ModelMakeServiceProvider"
```
