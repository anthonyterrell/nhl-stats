<?php

use App\Api\NHLApi;
use App\Data\GameData;
use App\Data\StandingData;
use Illuminate\Support\Facades\Cache;

beforeEach(fn () => Cache::flush());

it('returns normalized schedule as GameData collection', function () {
    fakeNHLSchedule();

    $games = app(NHLApi::class)->schedule('CHI');

    expect($games)->toHaveCount(2)
        ->and($games->first())->toBeInstanceOf(GameData::class)
        ->and($games->first()->away_team->abbreviation)->toBe('CHI')
        ->and($games->first()->home_team->abbreviation)->toBe('VGK');
});

it('returns normalized standings as StandingData collection', function () {
    fakeNHLSchedule();

    $standings = app(NHLApi::class)->standings();

    expect($standings)->not->toBeEmpty()
        ->and($standings->first())->toBeInstanceOf(StandingData::class)
        ->and($standings->first())->toHaveProperties(['abbreviation', 'name', 'logo', 'wins', 'losses', 'ot_losses', 'points', 'games_played']);
});

it('returns team stats for a specific team', function () {
    fakeNHLSchedule();

    $stats = app(NHLApi::class)->teamStats('CHI');

    expect($stats)->not->toBeNull()
        ->and($stats['abbreviation'])->toBe('CHI')
        ->and($stats['wins'])->toBe(20);
});

it('returns upcoming games filtered and limited', function () {
    fakeNHLSchedule();

    $upcoming = app(NHLApi::class)->upcomingGames('CHI', 1);

    expect($upcoming)->toHaveCount(1);
});

it('identifies preseason games', function () {
    fakeNHLSchedule(preseason: true);

    $games = app(NHLApi::class)->schedule('CHI');

    expect($games->first()->is_preseason)->toBeTrue();
});

it('marks regular season games as not preseason', function () {
    fakeNHLSchedule();

    $games = app(NHLApi::class)->schedule('CHI');

    expect($games->first()->is_preseason)->toBeFalse();
});

it('enriches games with team stats from standings', function () {
    fakeNHLSchedule();

    $games = app(NHLApi::class)->schedule('CHI');
    $away = $games->first()->away_team;

    expect($away->stats)->not->toBeNull()
        ->and($away->stats->wins)->toBe(20);
});
