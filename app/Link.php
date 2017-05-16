<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public function scopeEnglish($query)
    {
        return $query->where('language', 'en');
    }

    public function scopeTurkish($query)
    {
        return $query->where('language', 'tr');
    }
}
