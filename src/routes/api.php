<?php

Route::group([
    'prefix'    => 'vendor-payments',
    'as'        => 'payments.',
    'namespace' => 'vdvcoder\Payment\App'
], function () {
    Route::group(['namespace' => 'Providers'], function () {
        Route::post('webhooks/mollie', 'MolliePaymentProvider@webhook')->name('webhooks.mollie');
    });

    Route::group(['namespace' => 'Http\Controllers'], function () {
        Route::get('validate/{payment}', 'ValidatePaymentController@validate')->name('validate');
    });

});
