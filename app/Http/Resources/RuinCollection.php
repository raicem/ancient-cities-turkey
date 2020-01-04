<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RuinCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $locale = app()->getLocale();

        $collection = $this->collection->map(function ($ruin) use ($locale) {
            return [
                'id' => $ruin->id,
                'name' => $locale === 'tr' ? $ruin->name_tr : $ruin->name,
                'slug' => $ruin->slug,
                'latitude' => $ruin->latitude,
                'longitude' => $ruin->longitude,
            ];
        });

        return $collection->toArray();
    }
}
