<?php

namespace App\Http\Controllers;

use App\Actions\GetStandings;
use App\Actions\GetUpcomingGames;
use App\Api\NHLApi;
use App\Api\PWHLApi;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(
        GetUpcomingGames $getUpcomingGames,
        GetStandings $getStandings,
        string $league = 'nhl',
    ): Response {
        $api = match ($league) {
            'pwhl' => app(PWHLApi::class),
            default => app(NHLApi::class),
        };

        $team = config("hockey.{$league}.team");

        return Inertia::render('Dashboard', [
            'league' => $league,
            'games' => $getUpcomingGames->execute($api, $team),
            'standings' => $getStandings->execute($api),
        ]);
    }
}
