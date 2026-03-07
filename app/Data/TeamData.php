<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class TeamData extends Data
{
    public function __construct(
        public string $abbreviation,
        public string $name,
        public string $logo,
        public ?TeamStatsData $stats = null,
    ) {}
}
