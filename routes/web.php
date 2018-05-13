<?php

Route::get('/sitemap', 'RuinsController@sitemap');
Route::get('/{locale?}', 'RuinsController@index')->name('ruins.index');
Route::get('/{locale}/{ruin}', 'RuinsController@show')->name('ruins.show');
