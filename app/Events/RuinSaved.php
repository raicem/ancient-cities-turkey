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
     * @param Ruin     $ruin
     */
    public function __construct(Ruin $ruin)
    {
        $this->ruin = $ruin;
    }
}
