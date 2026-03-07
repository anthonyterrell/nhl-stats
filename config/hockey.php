<?php

return [
    'timezone' => env('HOCKEY_TIMEZONE', 'America/Chicago'),

    'nhl' => [
        'url' => 'https://api-web.nhle.com/v1/',
        'ttl_schedule' => 86400,
        'ttl_standings' => 3600,
        'team' => env('NHL_TEAM', 'CHI'),
    ],

    'pwhl' => [
        'url' => 'https://lscluster.hockeytech.com/feed/',
        'key' => env('PWHL_API_KEY', '446521baf8c38984'),
        'client_code' => 'pwhl',
        'season_id' => env('PWHL_SEASON_ID', '5'),
        'ttl_schedule' => 86400,
        'ttl_standings' => 3600,
        'team' => env('PWHL_TEAM', ''),
    ],
];
