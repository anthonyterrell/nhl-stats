<?php

namespace App\Actions;

use App\Contracts\HockeyLeague;

class GetUpcomingGames
{
    public function execute(HockeyLeague $api, string $team, int $limit = 3): array
    {
        return $api->upcomingGames($team, $limit)->toArray();
    }
}
