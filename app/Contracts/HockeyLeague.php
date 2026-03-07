<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface HockeyLeague
{
    /** @return Collection<int, \App\Data\GameData> */
    public function schedule(string $team): Collection;

    /** @return Collection<int, \App\Data\StandingData> */
    public function standings(): Collection;

    public function teamStats(string $team): ?array;
}
