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
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'name' => $locale === 'tr' ? $this->name_tr : $this->name,
            'slug' => $this->slug,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'information' => $locale === 'tr' ? $this->information_tr : $this->information,
            'image' => $this->image,
            'tripadvisor' => $this->tripadvisor,
            'foursquare' => $this->foursquare,
            'official_site' => (int)$this->official_site,
            'official_site_link' =>  $locale === 'tr' ? $this->official_site_tr : $this->official_site_en,
            'city_id' => $this->city ? $this->city->id : null,
            'turkish_links' => Link::collection($this->turkishLinks()->get()),
            'english_links' => Link::collection($this->englishLinks()->get()),
        ];
    }
}
