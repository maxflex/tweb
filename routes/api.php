<?php
URL::forceSchema('https');
Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {
    Route::post('masters/search', 'MastersController@search');
    Route::resource('requests', 'RequestsController', ['only' => 'store']);
    Route::resource('prices', 'PricesController', ['only' => 'index']);
    Route::get('reviews/block', 'ReviewsController@block');
    Route::resource('reviews', 'ReviewsController');
    Route::resource('videos', 'VideosController', ['only' => 'index']);
    Route::post('gallery/init', 'GalleryController@init');
    Route::resource('gallery', 'GalleryController');
    Route::resource('stats', 'StatsController', ['only' => 'index']);
    // Route::post('cv/uploadPhoto', 'CvController@uploadPhoto');
    Route::resource('cv', 'CvController', ['only' => 'store']);
    Route::resource('stream', 'StreamController', ['only' => 'store']);
    // Route::resource('sms', 'SmsController');
});
