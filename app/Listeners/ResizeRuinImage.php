<?php

namespace App\Listeners;

use App\Events\RuinSaved;
use Intervention\Image\Facades\Image;

class ResizeRuinImage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RuinSaved  $event
     * @return void
     */
    public function handle(RuinSaved $event)
    {
        $imagePath = 'public/' . $event->ruin->image;
        dd($imagePath);
        $image = Image::make($imagePath);

        $fileSize = $image->fileSize();
        $width = $image->width();
        dd($fileSize, $width);

        // Open the image with intervention

        // dissect the size and width
        // if its to high resize it and save it
    }
}
