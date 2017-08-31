<?php

use App\Ruin;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\ImageManagerStatic as Image;

Route::get('/', 'RuinsController@home');
Route::get('/sitemap', 'RuinsController@sitemap');
Route::get('/{ruin}', 'RuinsController@index');
Route::get('/{lang}/{ruin}', 'RuinsController@index');
