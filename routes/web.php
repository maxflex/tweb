<?php

use App\Models\Variable;
use App\Models\Master;

URL::forceSchema('https');

Route::post('upload', 'UploadController@original');

Route::get('sitemap.xml', 'SitemapController@index');

Route::get('/full', function () {
    unset($_SESSION['force_mobile']);
    $_SESSION['force_full'] = true;
    $_SESSION['page_was_refreshed'] = true;
    return redirect()->back();
});

Route::get('/mobile', function () {
    unset($_SESSION['force_full']);
    $_SESSION['force_mobile'] = true;
    $_SESSION['page_was_refreshed'] = true;
    return redirect()->back();
});

# Templates for angular directives
Route::get('directives/{directive}', function ($directive) {
    return view("directives.{$directive}");
});

# Entity profile page
Route::get(Master::URL . '/{id}', 'PagesController@master')->where('id', '[0-9]+');

Route::get('about', 'PagesController@about');

# All serp pages
Route::get('{url?}', 'PagesController@index')->where('url', '.*');

Route::get('/sitemap.xml', 'PagesController@sitemap');
