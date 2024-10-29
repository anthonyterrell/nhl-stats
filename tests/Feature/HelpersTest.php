<?php

use App\Api\NHL\NHLApi;

it('can get my teams abbreviation from config', function () {
    config(['nhl.team' => 'VGK']);

    expect(myTeam())->toBe('VGK');
});

it('determines if we are in the pre-season', function () {
    fakePreSeasonSchedule();

    $preseasonGames = app(NHLApi::class)->upcomingScheduleFor(myTeam())->filter(
        fn ($game) => $game->gameType == NHLApi::GAME_TYPE_PRESEASON
    );

    expect(inPreSeason())->toBeTrue();
    expect($preseasonGames)->not->toBeEmpty();
});

it('determines if we are in the regular season', function () {
    fakeSeasonSchedule();

    $preseasonGames = app(NHLApi::class)->upcomingScheduleFor(myTeam())->filter(
        fn ($game) => $game->gameType == NHLApi::GAME_TYPE_PRESEASON
    );
    expect(inPreSeason())->toBeFalse();

    expect($preseasonGames)->toBeEmpty();
});
