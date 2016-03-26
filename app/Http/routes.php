<?php

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', 'PagesController@index');

    Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
        Route::get('total', 'ProductsController@total');
        Route::get('products', 'ProductsController@index');
        Route::post('products', 'ProductsController@store');
        Route::delete('products/{id}', 'ProductsController@destroy');
    });
});
