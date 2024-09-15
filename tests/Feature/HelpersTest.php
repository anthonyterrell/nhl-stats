<?php

use App\Api\NHL\NHLApi;

it('can get my teams abbreviation from config', function () {
        config(['nhl.team' => 'VGK']);

    expect(myTeam())->toBe('VGK');
});

it('determines if we are in the pre-season', function () {
    fakePreSeasonSchedule();

    $fullSchedule = collect(app(NHLApi::class)->fullScheduleFor(myTeam())->games);
    $upcomingSchedule = app(NHLApi::class)->upcomingScheduleFor(myTeam());

    expect(inPreSeason())->toBeTrue();
    expect($fullSchedule->count())->toEqual($upcomingSchedule->count());
});

it('determines if we are in the regular season', function () {
    fakeSeasonSchedule();

    $fullSchedule = collect(app(NHLApi::class)->fullScheduleFor(myTeam())->games);
    $upcomingSchedule = app(NHLApi::class)->upcomingScheduleFor(myTeam());

    expect(inPreSeason())->toBeFalse();
    expect($fullSchedule->count())->toBeGreaterThan($upcomingSchedule->count());
});
