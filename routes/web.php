<?php

use App\Ruin;

Route::get('/testing', function () {
    $ruins = Ruin::all();
    $ruins->map(function (Ruin $item) {
        $item->image = 'img/ruins/' . $item->image;
        $item->save();
    });
});
Route::get('/sitemap', 'RuinsController@sitemap');
Route::get('/', 'RuinsController@index');
Route::get('/{ruin}', 'RuinsController@index');
Route::get('/{lang}/{ruin}', 'RuinsController@index');
