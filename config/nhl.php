<?php

return [
    'api' => [
        'url' => 'https://api-web.nhle.com/v1/',

        'ttl_standings' => 3600, // 1 hour
        'ttl_schedule' => 86400, // 1 day
    ],

    'team' => env('MY_TEAM_ABBREV','CHI'),
];
