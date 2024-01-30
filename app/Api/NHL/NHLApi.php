<?php

namespace App\Api\NHL;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NHLApi
{
    public const BASE_API_URL = 'https://api-web.nhle.com/v1/';

    public function scheduleFor(string $abbr)
    {
        return cache()->remember('schedule', 86400, function () use ($abbr) {
            // schedule is cached for a day
            return json_decode(Http::get(self::BASE_API_URL."club-schedule-season/$abbr/now")->body());
        });
    }

    public function standings()
    {
        return Cache::remember('standings', 3600, function () {
            // standings are cached for an hour
            return json_decode(Http::get(self::BASE_API_URL."standings/now")->body());
        });
    }
}
