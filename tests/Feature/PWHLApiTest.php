<?php

use App\Api\PWHLApi;
use App\Data\GameData;
use App\Data\StandingData;

beforeEach(fn () => fakePWHLSchedule());

it('returns normalized schedule as GameData collection', function () {
    $games = app(PWHLApi::class)->schedule('');

    expect($games)->not->toBeEmpty()
        ->and($games->first())->toBeInstanceOf(GameData::class)
        ->and($games->first()->away_team->abbreviation)->toBe('BOS')
        ->and($games->first()->home_team->abbreviation)->toBe('MIN');
});

it('returns normalized standings as StandingData collection', function () {
    $standings = app(PWHLApi::class)->standings();

    expect($standings)->not->toBeEmpty()
        ->and($standings->first())->toBeInstanceOf(StandingData::class)
        ->and($standings->first()->abbreviation)->toBe('BOS')
        ->and($standings->first()->wins)->toBe(15);
});

it('returns team stats for a specific team', function () {
    $stats = app(PWHLApi::class)->teamStats('MIN');

    expect($stats)->not->toBeNull()
        ->and($stats['name'])->toBe('Minnesota Frost')
        ->and($stats['wins'])->toBe(12);
});

it('returns upcoming games', function () {
    $upcoming = app(PWHLApi::class)->upcomingGames('', 3);

    expect($upcoming)->not->toBeEmpty();
});
