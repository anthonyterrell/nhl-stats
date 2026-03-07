<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class StandingData extends Data
{
    public function __construct(
        public string $abbreviation,
        public string $name,
        public string $logo,
        public int $games_played,
        public int $wins,
        public int $losses,
        public int $ot_losses,
        public int $points,
    ) {}
}
