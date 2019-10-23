# Namespaced Laravel Models

This package extends the Laravel make:model command to allow setting
the default namespace.

* [Installation](#installation)

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
    Netpok\\NamespacedLaravelModels\\ModelMakeProvider::class,
];
```
