<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $guarded = [];

    public function ruin()
    {
        return $this->belongsTo(Ruin::class);
    }

    public function scopeEnglish($query)
    {
        return $query->where('language', 'en');
    }

    public function scopeTurkish($query)
    {
        return $query->where('language', 'tr');
    }
}
