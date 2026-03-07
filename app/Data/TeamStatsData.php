<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class TeamStatsData extends Data
{
    public function __construct(
        public int $wins,
        public int $losses,
        public int $ot_losses,
        public int $points,
        public int $games_played,
    ) {}
}
