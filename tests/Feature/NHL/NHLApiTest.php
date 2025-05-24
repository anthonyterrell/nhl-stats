<?php

use App\Api\NHL\NHLApi;

it('retrieves season schedule by abbreviated team', function (string $abbr) {
    $fullSchedule = app(NHLApi::class)->fullScheduleFor($abbr);
    $game = collect($fullSchedule->games)->first();

    expect($fullSchedule->games)->not->toBeEmpty();
    expect($game)->toHaveProperties(['gameDate', 'tvBroadcasts', 'awayTeam', 'homeTeam']);
})->with(['CHI', 'VGK']);

it('retrieves the upcoming schedule by abbreviated team', function (string $abbr) {
    fakeSeasonSchedule();

    $nextGameDate = app(NHLApi::class)->upcomingScheduleFor($abbr)->first()->gameDate;

    expect(now()->subDay()->setTimezone('America/Chicago')->lessThanOrEqualTo($nextGameDate))->toBeTrue();
})->with(['CHI', 'VGK']);

describe('isPreseason', function () {
    it('is true for preseason', function () {
        fakePreSeasonSchedule();

        $preseasonGame = app(NHLApi::class)->upcomingScheduleFor(myTeam())->first();

        expect($preseasonGame)->isPreseason->toBeTrue();
    });

    it('is false for regulation', function () {
        fakeSeasonSchedule();

        $regulationGame = app(NHLApi::class)->upcomingScheduleFor(myTeam())->first();

        expect($regulationGame)->isPreseason->toBeFalse();
    });
});

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
