<?php

namespace App;

use App\Events\RuinSaved;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Ruin extends Model
{
    use Sluggable;
    use Notifiable;
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'other_names' => 'array',
        'is_unesco' => 'bool',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'saved' => RuinSaved::class,
    ];

    /**
     * Defines ruins and links relationship.
     */
    public function links()
    {
        return $this->hasMany(Link::class);
    }

    /**
     * Defines ruins and city relationship.
     *
     * @return BelongsTo<City, $this>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function turkishLinks()
    {
        return $this->links()->turkish()->orderBy('description', 'ASC');
    }

    public function englishLinks()
    {
        // Tripadvisor is user-generated content, so it stays after the
        // editorial sources regardless of the alphabetical order.
        return $this->links()
            ->english()
            ->orderByRaw('description = ?', ['Tripadvisor'])
            ->orderBy('description', 'ASC');
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
        return $this->official_site_url;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'separator' => '-',
            ],
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
