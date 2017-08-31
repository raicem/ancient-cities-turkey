<?php

use App\Ruin;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\ImageManagerStatic as Image;

Route::get('/sitemap', 'RuinsController@sitemap');
Route::get('/', 'RuinsController@index');
Route::get('/{ruin}', 'RuinsController@index');
Route::get('/{lang}/{ruin}', 'RuinsController@index');
