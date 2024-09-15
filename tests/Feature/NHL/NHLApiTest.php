<?php

use App\Api\NHL\NHLApi;

it('retrieves season schedule by abbreviated team', function (string $abbr) {
    $fullSchedule = app(NHLApi::class)->fullScheduleFor($abbr);
    $game = collect($fullSchedule->games)->first();

    expect($fullSchedule->games)->not->toBeEmpty();
    expect($game)->toHaveProperties(['gameDate', 'tvBroadcasts', 'awayTeam', 'homeTeam']);
})->with(['CHI', 'VGK']);

it('retrieves the upcoming schedule by abbreviated team', function (string $abbr) {
    $nextGameDate = app(NHLApi::class)->upcomingScheduleFor($abbr)->first()->gameDate;

    expect(now()->lessThanOrEqualTo($nextGameDate))->toBeTrue();
})->with(['CHI', 'VGK']);

it('retrieves the current league standings', function () {
    $leagueStandings = app(NHLApi::class)->standings();
    $leader = collect($leagueStandings->standings)->first();

    expect($leagueStandings->standings)->not->toBeEmpty();
    expect($leader)->toHaveProperties(['teamName', 'teamLogo', 'wins', 'losses', 'otLosses']);
});

it('retrieves statistics for a team', function (string $abbr) {
    $teamStats = app(NHLApi::class)->statisticsFor($abbr);

    expect($teamStats)->toHaveProperties(['teamName', 'teamLogo', 'wins', 'losses', 'otLosses']);
})->with(['CHI', 'VGK']);
