<?php

$middleware = !empty(config('newsletter.middlewares')) ? config('newsletter.middlewares') : [];

/*
|--------------------------------------------------------------------------
| designpond\newsletter\Http\Controllers\Frontend Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'web'], function () {

    Route::post('unsubscribe', 'designpond\newsletter\Http\Controllers\Frontend\InscriptionController@unsubscribe');
    Route::post('subscribe', 'designpond\newsletter\Http\Controllers\Frontend\InscriptionController@subscribe');
    Route::get('activation/{token}/{newsletter_id}', 'designpond\newsletter\Http\Controllers\Frontend\InscriptionController@activation');
    Route::post('resend', 'designpond\newsletter\Http\Controllers\Frontend\InscriptionController@resend');

    Route::get('campagne/{id}', 'designpond\newsletter\Http\Controllers\Frontend\CampagneController@show');
    Route::get('pdf/{id}', 'designpond\newsletter\Http\Controllers\Frontend\CampagneController@pdf');

    Route::group(['prefix' => 'display'], function () {
        Route::resource('newsletter', 'designpond\newsletter\Http\Controllers\Frontend\NewsletterController');
        Route::get('newsletter/campagne/{id}', 'designpond\newsletter\Http\Controllers\Frontend\NewsletterController@campagne');
        Route::resource('campagne', 'designpond\newsletter\Http\Controllers\Frontend\CampagneController');
    });
});

Route::group(['middleware' => $middleware], function () {

    /*
    |--------------------------------------------------------------------------
    | designpond\newsletter\Http\Controllers\Backend Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'build'], function () {

        /*
       |--------------------------------------------------------------------------
       | designpond\newsletter\Http\Controllers\Backend subscriptions, newsletters and campagnes Routes
       |--------------------------------------------------------------------------
       */

        Route::get('newsletter/archive/{newsletter}/{year}', 'designpond\newsletter\Http\Controllers\Backend\NewsletterController@archive');
        Route::resource('newsletter', 'designpond\newsletter\Http\Controllers\Backend\NewsletterController');

        Route::get('campagne/create/{newsletter}', 'designpond\newsletter\Http\Controllers\Backend\CampagneController@create');
        Route::get('campagne/simple/{id}', 'designpond\newsletter\Http\Controllers\Backend\CampagneController@simple');
        Route::get('campagne/preview/{id}', 'designpond\newsletter\Http\Controllers\Backend\CampagneController@preview');
        Route::get('campagne/cancel/{id}', 'designpond\newsletter\Http\Controllers\Backend\CampagneController@cancel');
        Route::resource('campagne', 'designpond\newsletter\Http\Controllers\Backend\CampagneController');

        // Content building blocs
        Route::post('sorting', 'designpond\newsletter\Http\Controllers\Backend\ContentController@sorting');
        Route::post('sortingGroup', 'designpond\newsletter\Http\Controllers\Backend\ContentController@sortingGroup');
        Route::resource('content', 'designpond\newsletter\Http\Controllers\Backend\ContentController');

        Route::post('send/campagne', 'designpond\newsletter\Http\Controllers\Backend\SendController@campagne');
        Route::post('send/test', 'designpond\newsletter\Http\Controllers\Backend\SendController@test');
        Route::post('send/forward', 'designpond\newsletter\Http\Controllers\Backend\SendController@forward');

        Route::post('clipboard/copy', 'designpond\newsletter\Http\Controllers\Backend\ClipboardController@copy');
        Route::post('clipboard/paste', 'designpond\newsletter\Http\Controllers\Backend\ClipboardController@paste');

        Route::resource('subscriber', 'designpond\newsletter\Http\Controllers\Backend\SubscriberController');
        Route::get('subscribers', ['uses' => 'designpond\newsletter\Http\Controllers\Backend\SubscriberController@subscribers']);

        Route::resource('statistics', 'designpond\newsletter\Http\Controllers\Backend\StatsController');

        Route::resource('import', 'designpond\newsletter\Http\Controllers\Backend\ImportController');
        Route::resource('emails', 'designpond\newsletter\Http\Controllers\Backend\EmailController');

        Route::post('liste/send', 'designpond\newsletter\Http\Controllers\Backend\ListController@send');
        Route::resource('liste', 'designpond\newsletter\Http\Controllers\Backend\ListController');

    });

});
