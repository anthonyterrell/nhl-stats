<?php

namespace App\Actions;

use App\Contracts\HockeyLeague;

class GetStandings
{
    public function execute(HockeyLeague $api): array
    {
        return $api->standings()->toArray();
    }
}
