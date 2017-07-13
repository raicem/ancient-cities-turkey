<?php

use App\Ruin;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\ImageManagerStatic as Image;

Route::get('/', 'RuinsController@home');
Route::get('/sitemap', 'RuinsController@index');
Route::get('/{ruin}', 'RuinsController@show');






Route::get('/tools/get-images', function () {
    set_time_limit(0);
    Image::configure(array('driver' => 'imagick'));
    $ruins = Ruin::all();
    foreach ($ruins as $ruin) {
        $pathToSave = base_path("public/img/ruins/{$ruin->slug}.jpg");

        if (file_exists($pathToSave)) {
            continue;
        }

        try {
            $ruinImage = Image::make($ruin->image);
        } catch (NotReadableException $e) {
            echo $ruin->slug . " " .  $e->getMessage() . '<br>';
            continue;
        }

        $ruinImage->fit(800, null, function ($constraint) {
            $constraint->upsize();
        });
        $ruinImage->save($pathToSave);
        $ruin->image = $ruin->slug . ".jpg";
        $ruin->save();
    }
});
