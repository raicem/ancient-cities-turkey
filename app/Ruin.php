<?php

namespace App;

use App\Events\RuinSaved;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Ruin extends Model
{
    use Sluggable, Notifiable;

    protected $guarded = [];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => RuinSaved::class,
    ];

    /**
     * Changes the key for route-model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Defines ruins and links relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Returns the turkish language informational links.
     *
     * @return mixed
     */
    public function turkishLinks()
    {
        return $this->links()->turkish()->orderBy('description', 'ASC');
    }

    /**
     * Returns the english language informational links.
     *
     * @return mixed
     */
    public function englishLinks()
    {
        return $this->links()->english()->orderBy('description', 'ASC');
    }

    /**
     * Maps the necessery values to turkish.
     *
     * @return $this
     */
    public function asTurkish()
    {
        $this->information = $this->information_tr;
        $this->name = $this->name_tr;
        $this->official_site_link = $this->official_site_tr;
        
        unset(
            $this->information_tr,
            $this->official_site_tr,
            $this->official_site_en,
            $this->name_tr
        );

        return $this;
    }

    /**
     * Since there is no official_site_link column we manually mutate it.
     * If we do change the column name this method is not
     * necessery.
     */
    public function asEnglish()
    {
        $this->official_site_link = $this->official_site_en;
        
        unset(
            $this->information_tr,
            $this->official_site_tr,
            $this->official_site_en,
            $this->name_tr
        );
        
        return $this;
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'separator' => '-'
            ]
        ];
    }

    /**
     * Returns the coordinates as string.
     *
     * @return string
     */
    public function coordinates(): string
    {
        return $this->longitude.','.$this->latitude;
    }
}
