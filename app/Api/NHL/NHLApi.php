<?php

namespace App\Api\NHL;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class NHLApi
{
    public const BASE_API_URL = 'https://api-web.nhle.com/v1/';

    public function scheduleFor(string $abbr): Response
    {
        return Http::get(self::BASE_API_URL."club-schedule-season/$abbr/now");
    }
}
