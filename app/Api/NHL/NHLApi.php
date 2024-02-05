<?php

namespace App\Api\NHL;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NHLApi
{
    public const BASE_API_URL = 'https://api-web.nhle.com/v1/';

    public function fullScheduleFor(string $abbr)
    {
        return cache()->remember('schedule', 86400, function () use ($abbr) {
            // schedule is cached for a day
            return json_decode(Http::get(self::BASE_API_URL."club-schedule-season/$abbr/now")->body());
        });
    }

    public function upcomingScheduleFor(string $abbr)
    {
        return collect($this->fullScheduleFor($abbr)->games)
            ->filter(fn ($game) => $game->gameDate >= now()->toDateString())
            ->values()->map(function ($game) {
                $game->awayTeam->teamStatistics = $this->statisticsFor($game->awayTeam->abbrev);
                $game->homeTeam->teamStatistics = $this->statisticsFor($game->homeTeam->abbrev);
                return $game;
            });
    }

    public function standings()
    {
        return Cache::remember('standings', 3600, function () {
            // standings are cached for an hour
            return json_decode(Http::get(self::BASE_API_URL.'standings/now')->body());
        });
    }

    public function statisticsFor(string $abbr)
    {
        return collect($this->standings()->standings)->filter(function ($team) use ($abbr) {
            return $team->teamAbbrev->default == $abbr;
        })->first();
    }
}
