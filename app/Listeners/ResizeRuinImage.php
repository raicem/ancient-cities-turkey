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
     * @return void
     */
    public function handle(RuinSaved $event)
    {
        if ($event->ruin->image) {
            $image = Image::make(public_path() . '/' . $event->ruin->image);

            if ($image->filesize() > 350000) {
                $image->resize(1080, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $image->save();
            }
        }
    }
}
