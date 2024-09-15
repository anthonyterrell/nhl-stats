<?php

use App\Api\NHL\NHLApi;
use Illuminate\Support\Facades\Cache;

if (!function_exists('myTeam')) {
    function myTeam()
    {
        return config('nhl.team');
    }
}

if (!function_exists('inPreSeason')) {
    function inPreSeason()
    {
        return Cache::remember('inPreSeason', 86400, function () {
            return collect(app(NHLApi::class)->fullScheduleFor(myTeam())->games)->count()
                == app(NHLApi::class)->upcomingScheduleFor(myTeam())->count();
         });
    }
}
