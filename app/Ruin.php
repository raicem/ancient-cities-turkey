<?php

namespace App;

use App\Events\RuinSaved;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Ruin extends Model
{
    use Sluggable;
    use Notifiable;

    protected $guarded = [];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'official_site' => 'int',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => RuinSaved::class,
    ];

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

    public function turkishLinks()
    {
        return $this->links()->turkish()->orderBy('description', 'ASC');
    }

    public function englishLinks()
    {
        return $this->links()->english()->orderBy('description', 'ASC');
    }

    public function getCoordinatesAttribute(): string
    {
        return $this->longitude . ',' . $this->latitude;
    }

    public function getNameAttribute($value)
    {
        if (app()->getLocale() === 'tr') {
            return $this->name_tr;
        }

        return $value;
    }

    public function getInformationAttribute($value)
    {
        if (app()->getLocale() === 'tr') {
            return $this->information_tr;
        }

        return $value;
    }

    public function getOfficialSiteLinkAttribute()
    {
        if (app()->getLocale() === 'tr') {
            return $this->official_site_tr;
        }

        return $this->official_site_en;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'separator' => '-'
            ]
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
