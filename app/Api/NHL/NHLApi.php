<?php

namespace App\Api\NHL;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NHLApi
{
    const GAME_TYPE_PRESEASON = 1;

    public function fullScheduleFor(string $abbr)
    {
        return cache()->remember('schedule', config('nhl.api.ttl_schedule'), function () use ($abbr) {
            return json_decode($this->get("club-schedule-season/$abbr/now"));
        });
    }

    public function upcomingScheduleFor(string $abbr)
    {
        return collect($this->fullScheduleFor($abbr)->games)
            ->filter(fn ($game) => ! isset($game->gameOutcome))
            ->values()->map(function ($game) {
                $game->isPreseason = $game->gameType == self::GAME_TYPE_PRESEASON;
                $game->startTime = isset($game->startTimeUTC)
                    ? now()->parse($game->startTimeUTC)->setTimezone('America/Chicago')->format('h:m A')
                    : now()->setTimezone('America/Chicago')->format('h:m A');
                $game->awayTeam->teamStatistics = $this->statisticsFor($game->awayTeam->abbrev);
                $game->homeTeam->teamStatistics = $this->statisticsFor($game->homeTeam->abbrev);

                return $game;
            });
    }

    public function standings()
    {
        return Cache::remember('standings', config('nhl.api.ttl_standings'), function () {
            return json_decode($this->get('standings/now'));
        });
    }

    public function statisticsFor(string $abbr)
    {
        return collect($this->standings()->standings)->filter(function ($team) use ($abbr) {
            return $team->teamAbbrev->default == $abbr;
        })->first();
    }

    private function get(string $path): string
    {
        return Http::get(config('nhl.api.url').$path)->body();
    }
}
