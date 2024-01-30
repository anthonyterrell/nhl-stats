<?php

use App\Api\NHL\NHLApi;

it('has a base URL', function () {
    expect(NHLApi::BASE_API_URL)->toBe('https://api-web.nhle.com/v1/');
});

it('retrieves season schedule by abbreviated team', function (string $abbr) {
    $response = app(NHLApi::class)->scheduleFor($abbr);
    $schedule = json_decode($response->body());
    $game = collect($schedule->games)->first();

    expect($response->successful())->toBeTrue();
    expect($response->body())->toBeJson();
    expect($schedule->games)->not->toBeEmpty();
    expect($game)->toHaveProperties(['gameDate', 'tvBroadcasts', 'awayTeam', 'homeTeam']);
})->with(['CHI', 'VGK']);
