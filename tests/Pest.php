<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

pest()->extend(Tests\TestCase::class)->in('Feature');

function fakeNHLSchedule(bool $preseason = false): void
{
    $gameType = $preseason ? 1 : 2;
    $yesterday = Carbon::yesterday()->format('Y-m-d');
    $tomorrow = Carbon::tomorrow()->format('Y-m-d');
    $nextWeek = Carbon::now()->addWeek()->format('Y-m-d');

    $pastGame = [
        'gameDate' => $yesterday,
        'startTimeUTC' => Carbon::yesterday()->setTime(19, 0)->utc()->toIso8601String(),
        'gameType' => $gameType,
        'gameOutcome' => ['lastPeriodType' => 'REG'],
        'awayTeam' => [
            'abbrev' => 'VGK',
            'placeName' => ['default' => 'Vegas'],
            'logo' => 'https://example.com/vgk.png',
        ],
        'homeTeam' => [
            'abbrev' => 'CHI',
            'placeName' => ['default' => 'Chicago'],
            'logo' => 'https://example.com/chi.png',
        ],
    ];

    $upcomingGame1 = [
        'gameDate' => $tomorrow,
        'startTimeUTC' => Carbon::tomorrow()->setTime(0, 0)->utc()->toIso8601String(),
        'gameType' => $gameType,
        'awayTeam' => [
            'abbrev' => 'CHI',
            'placeName' => ['default' => 'Chicago'],
            'logo' => 'https://example.com/chi.png',
        ],
        'homeTeam' => [
            'abbrev' => 'VGK',
            'placeName' => ['default' => 'Vegas'],
            'logo' => 'https://example.com/vgk.png',
        ],
    ];

    $upcomingGame2 = [
        'gameDate' => $nextWeek,
        'startTimeUTC' => Carbon::now()->addWeek()->setTime(2, 0)->utc()->toIso8601String(),
        'gameType' => $gameType,
        'awayTeam' => [
            'abbrev' => 'DET',
            'placeName' => ['default' => 'Detroit'],
            'logo' => 'https://example.com/det.png',
        ],
        'homeTeam' => [
            'abbrev' => 'CHI',
            'placeName' => ['default' => 'Chicago'],
            'logo' => 'https://example.com/chi.png',
        ],
    ];

    Http::fake([
        '*/club-schedule-season/*/now' => Http::response([
            'games' => [$pastGame, $upcomingGame1, $upcomingGame2],
        ]),
        '*/standings/now' => Http::response([
            'standings' => [
                [
                    'teamAbbrev' => ['default' => 'CHI'],
                    'teamName' => ['default' => 'Chicago Blackhawks'],
                    'teamLogo' => 'https://example.com/chi.png',
                    'gamesPlayed' => 55,
                    'wins' => 20,
                    'losses' => 30,
                    'otLosses' => 5,
                    'points' => 45,
                ],
                [
                    'teamAbbrev' => ['default' => 'VGK'],
                    'teamName' => ['default' => 'Vegas Golden Knights'],
                    'teamLogo' => 'https://example.com/vgk.png',
                    'gamesPlayed' => 55,
                    'wins' => 35,
                    'losses' => 15,
                    'otLosses' => 5,
                    'points' => 75,
                ],
            ],
        ]),
    ]);
}

function fakePWHLSchedule(): void
{
    $tomorrow = Carbon::tomorrow()->format('Y-m-d');

    Http::fake([
        '*lscluster.hockeytech.com*schedule*' => Http::response([
            'SiteKit' => [
                'Parameters' => [
                    [
                        'date_with_day' => Carbon::tomorrow()->toIso8601String(),
                        'game_type' => 'Regular Season',
                        'visiting_team_code' => 'BOS',
                        'visiting_team_city' => 'Boston',
                        'visiting_team_logo' => 'https://example.com/bos.png',
                        'home_team_code' => 'MIN',
                        'home_team_city' => 'Minnesota',
                        'home_team_logo' => 'https://example.com/min.png',
                    ],
                ],
            ],
        ]),
        '*lscluster.hockeytech.com*standings*' => Http::response([
            'SiteKit' => [
                'Parameters' => [
                    [
                        'teams' => [
                            [
                                'team_code' => 'BOS',
                                'name' => 'Boston Fleet',
                                'logo' => 'https://example.com/bos.png',
                                'games_played' => '20',
                                'wins' => '15',
                                'losses' => '3',
                                'ot_losses' => '2',
                                'points' => '32',
                            ],
                            [
                                'team_code' => 'MIN',
                                'name' => 'Minnesota Frost',
                                'logo' => 'https://example.com/min.png',
                                'games_played' => '20',
                                'wins' => '12',
                                'losses' => '5',
                                'ot_losses' => '3',
                                'points' => '27',
                            ],
                        ],
                    ],
                ],
            ],
        ]),
    ]);
}
