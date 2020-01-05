<?php

namespace App\Events;

use App\Ruin;
use Illuminate\Queue\SerializesModels;

class RuinSaved
{
    use SerializesModels;

    public $ruin;

    /**
     * Create a new event instance.
     *
     */
    public function __construct(Ruin $ruin)
    {
        $this->ruin = $ruin;
    }
}
