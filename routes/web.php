<?php

Route::get('/{locale?}', 'HomeController')->name('ruins.index');

Route::get('/{locale}/{city}-antik-kentleri', 'CityController')->name('city.list.tr');
Route::get('/{locale}/ancient-cities-in-{city}', 'CityController')->name('city.list.en');

Route::get('/{locale}/hakkinda', 'HomeController')->name('ruins.about.tr');
Route::get('/{locale}/about', 'HomeController')->name('ruins.about.en');

Route::get('/{locale}/{ruin}', 'RuinsController@show')->name('ruins.show');
