<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class GameData extends Data
{
    public function __construct(
        public string $date,
        public string $start_time,
        public bool $is_preseason,
        public TeamData $away_team,
        public TeamData $home_team,
    ) {}
}
