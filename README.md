# Newsletter module for laravel 5.2

Newsletter interface builder and send via mailjet api

!!! WARNING work in progress this is a specific package for specific content !!!

## Install

Via Composer

``` bash
$ composer require designpond/newsletter
```

## Require

``` json
"intervention/image": "dev-master",
"inlinestyle/inlinestyle": "1.*",
"maatwebsite/excel": "~2.0.0",
"mailjet/mailjet-apiv3-php": "^1.1"
```

## Usage

This package is used with Laravel 5.2 adn Mailjet API v3
Created for multiple websites of La Faculté de droit de l'Université de Neuchâtel.
The content is meant to be used with arrets, analyse, categories and multi sites

### Configuration

+ Publish with php artisan vendor:publish

    **Required**
     + Assets --tag=assets 
     + Migrations --tag=migrations
     + Seeders --tag=seeds
     
    **Optionnal**
     + Views --tag=views
     + Master layout --tag=layouts
     + Config --tag=config
     
+ In newsletter.php define building blocs to use if you enable "groupe" you have to enable "arret", both go with another!
+ Define the models and files/images paths.
+ Add Mailjet credentials to your .env file
+ Migrate tables and seed types with **php artisan db:seed --class=TypeSeeder**

### Usage simple

If you want routes with prefix set it in **env.js** in **newsletter/js**

### Master layout dependencies

Javascript and css
+ jquery.js v2.2
+ jquery-ui.js v1.11
+ bootstrap.css v3
+ bootstrap.js v3

**Elements to add**

In the head
```php
@if(isset($isNewsletter))
    @include('newsletter::Style.main', ['campagne' => isset($campagne) ? : null])
    @include('newsletter::Style.redactor')
@endif
```

Before end of the body
```php
@include('newsletter::Script.config')
     
@if(isset($isNewsletter))
    @include('newsletter::Script.date')
    @include('newsletter::Script.redactor')
    @include('newsletter::Script.angular')
    @include('newsletter::Script.datatables')
    @include('newsletter::Script.main')
@endif
```

You have to implement upload routes for wysiwyg redactor.js

```php
Route::post('uploadRedactor', 'UploadController@uploadRedactor');
Route::post('uploadJS', 'UploadController@uploadJS');
Route::get('imageJson/{id?}', ['uses' => 'UploadController@imageJson']);
Route::get('fileJson/{id?}', ['uses' => 'UploadController@fileJson']);
```

### Usage with Arrets and Categories

You have to Implement ajax routes:
``` php
Route::get('arret/{id}', 'ArretController@simple'); // build.js
Route::get('arrets/{id?}',     'ArretController@arrets'); // build.js
Route::get('categories/{id?}', 'CategorieController@categories'); // utils.js
```

And configure the path to you routes for angular`in newsletter/js/env.js

```javascript
// Admin url
window.__env.adminUrl = 'http://dev.local/admin/';
// Base url
window.__env.ajaxUrl = 'http://dev.local/admin/ajax/';
```


### Navigation menu items

+ Newsletters list: build/newsletter
+ Subscribers: build/subscriber
+ Import subscribers: build/import
+ External email lists: build/liste

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email cindy.leschaud@gmail.com instead of using the issue tracker.

## Credits

[Cindy Leschaud](http://www.designpond.ch)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-downloads]: https://packagist.org/packages/designpond/newsletter
[link-author]: https://github.com/DesignPond
