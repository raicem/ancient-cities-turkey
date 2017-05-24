<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruin extends Model
{
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('turkishLinks', function ($builder) {
            $builder->with('turkishLinks');
        });

        static::addGlobalScope('englishLinks', function ($builder) {
            $builder->with('englishLinks');
        });
    }

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

    public function turkishLinks()
    {
        return $this->links()->turkish()->orderBy('description', 'ASC');
    }

    public function englishLinks()
    {
        return $this->links()->english()->orderBy('description', 'ASC');
    }
}
