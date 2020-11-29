<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ruin extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Ruin $ruin */
        $ruin = $this;

        return [
            'id' => $ruin->id,
            'name' => $ruin->name,
            'slug' => $ruin->slug,
            'latitude' => $ruin->latitude,
            'longitude' => $ruin->longitude,
            'information' => $ruin->information,
            'image' => $ruin->image,
            'tripadvisor' => $ruin->tripadvisor,
            'foursquare' => $ruin->foursquare,
            'official_site' => $ruin->official_site,
            'official_site_link' => $ruin->official_site_link,
            'city_id' => $ruin->city->id ?? null, /* @phpstan-ignore-line */
            'turkish_links' => Link::collection($ruin->turkishLinks()->get()),
            'english_links' => Link::collection($ruin->englishLinks()->get()),
        ];
    }
}
