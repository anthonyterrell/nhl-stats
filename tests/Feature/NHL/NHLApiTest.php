<?php

use App\Api\NHL\NHLApi;

it('has a base URL', function () {
    expect(NHLApi::BASE_API_URL)->toBe('https://api-web.nhle.com/v1/');
});

it('retrieves season schedule by abbreviated team', function (string $abbr) {
    $schedule = app(NHLApi::class)->scheduleFor($abbr);
    $game = collect($schedule->games)->first();

    expect($schedule->games)->not->toBeEmpty();
    expect($game)->toHaveProperties(['gameDate', 'tvBroadcasts', 'awayTeam', 'homeTeam']);
})->with(['CHI', 'VGK']);

it('retrieves the current league standings', function () {
    $leagueStandings = app(NHLApi::class)->standings();
    $leader = collect($leagueStandings->standings)->first();

    expect($leagueStandings->standings)->not->toBeEmpty();
    expect($leader)->toHaveProperties(['teamName', 'teamLogo', 'wins', 'losses', 'otLosses']);
});
