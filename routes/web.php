<?php

use App\Ruin;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\ImageManagerStatic as Image;

Route::get('/', 'RuinsController@home');
Route::get('/{ruin}', 'RuinsController@home');
Route::get('/{lang}/{ruin}', 'RuinsController@home');
Route::get('/sitemap', 'RuinsController@index');
