<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Ruin
 */
class Ruin extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'information' => $this->information,
            'image' => $this->image,
            'tripadvisor' => $this->tripadvisor,
            'foursquare' => $this->foursquare,
            'official_site' => $this->official_site,
            'official_site_link' => $this->official_site_link,
            'city_id' => $this->city_id,
            'turkish_links' => Link::collection($this->turkishLinks()->get()),
            'english_links' => Link::collection($this->englishLinks()->get()),
        ];
    }
}
