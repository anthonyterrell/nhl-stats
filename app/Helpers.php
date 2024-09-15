<?php

use App\Api\NHL\NHLApi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

if (!function_exists('currentSeason')) {
    function currentSeason()
    {
        return Cache::remember('currentSeason', 86400, function () {
            $season =  collect(app(NHLApi::class)->fullScheduleFor(myTeam())->games)->first()?->season;

            if(!$season || now()->gt(new Carbon('first day of june'))) {
                return now()->format('Y') . '-' . now()->addYear()->format('Y');
            }

            $startingYear = Carbon::createFromFormat('Y',substr($season, 0, 4));

            return $startingYear->format('Y') . '-' . $startingYear->addYear()->format('Y');
         });
    }
}

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
