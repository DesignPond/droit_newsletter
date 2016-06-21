# Newsletter module for laravel 5.2

Newsletter interface builder and send via mailjet api

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
```

## Usage

This package is used with Laravel 5.2.
Created for multiple websites of La Faculté de droit de l'Université de Neuchâtel.
The content il meant to be used with arrets and categories content

### Configuration

publish config files with php artisan vendor:publish
In newsletter.php define building blocs to use if you enable "groupe" you have to enable "arret", both go with another!
Define the models path.
Add Mailjet credentials to your .env file

### Usage with Arrets and Categories

You have to Implement ajax routes:
``` php
    Route::get('ajax/arrets/{id}',   'ArretController@simple'); // build.js
    Route::get('ajax/arrets',        'ArretController@arrets'); // build.js
    Route::get('ajax/categories',    'CategorieController@categories'); // utils.js
```

### Navigation menu items

+ Newsletters list: build/newsletter
+ Campagnes: build/campagne
+ Subscribers: build/subscribers
+ Import: build/import

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email cindy.leschaud@gmail.com instead of using the issue tracker.

## Credits

- [Cindy Leschaud][http://www.designpond.ch]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-downloads]: https://packagist.org/packages/:vendor/:package_name
[link-author]: https://github.com/DesignPond
