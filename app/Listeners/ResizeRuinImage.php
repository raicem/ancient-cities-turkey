<?php

namespace App\Listeners;

use App\Events\RuinSaved;
use Intervention\Image\ImageManager;

class ResizeRuinImage
{
    public function __construct(private readonly ImageManager $images)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(RuinSaved $event): void
    {
        if (! $event->ruin->image) {
            return;
        }

        $path = public_path($event->ruin->image);

        if (! file_exists($path)) {
            return;
        }

        if (filesize($path) > 350000) {
            $this->images->read($path)->scale(width: 1080)->save($path);
        }
    }
}
