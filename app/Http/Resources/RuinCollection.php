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
        $collection = $this->collection->map(function ($ruin) {
            return [
                'id' => $ruin->id,
                'name' => $ruin->name,
                'slug' => $ruin->slug,
                'latitude' => $ruin->latitude,
                'longitude' => $ruin->longitude,
                'image' => $ruin->image,
                'city' => $ruin->city?->name,
                'district' => $ruin->district,
                'site_type' => $ruin->site_type,
                'is_unesco' => $ruin->is_unesco,
                'official_site_link' => $ruin->official_site_link,
            ];
        });

        return $collection->toArray();
    }
}
