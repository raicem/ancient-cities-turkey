<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'last_checked_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<Ruin, $this>
     */
    public function ruin(): BelongsTo
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
