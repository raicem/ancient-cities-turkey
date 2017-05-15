<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruin extends Model
{
    protected $guarded = [];

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
}
