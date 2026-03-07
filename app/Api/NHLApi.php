<?php

namespace App\Api;

use App\Concerns\FetchesHockeyData;
use App\Contracts\HockeyLeague;
use App\Data\GameData;
use App\Data\StandingData;
use App\Data\TeamStatsData;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class NHLApi implements HockeyLeague
{
    use FetchesHockeyData;

    private string $baseUrl;

    private string $timezone;

    public function __construct()
    {
        $this->baseUrl = config('hockey.nhl.url');
        $this->timezone = config('hockey.timezone');
    }

    public function schedule(string $team): Collection
    {
        $data = $this->cachedGet(
            "nhl.schedule.{$team}",
            config('hockey.nhl.ttl_schedule'),
            fn () => $this->get("club-schedule-season/{$team}/now"),
        );

        $standings = $this->standings();

        return collect($data['games'] ?? [])
            ->reject(fn (array $game) => isset($game['gameOutcome']))
            ->map(fn (array $game) => GameData::from([
                'date' => $game['gameDate'],
                'start_time' => Carbon::parse($game['startTimeUTC'])
                    ->setTimezone($this->timezone)
                    ->format('g:i A'),
                'is_preseason' => ($game['gameType'] ?? 2) === 1,
                'away_team' => $this->mapTeam($game['awayTeam'], $standings),
                'home_team' => $this->mapTeam($game['homeTeam'], $standings),
            ]))
            ->values();
    }

    public function standings(): Collection
    {
        $data = $this->cachedGet(
            'nhl.standings',
            config('hockey.nhl.ttl_standings'),
            fn () => $this->get('standings/now'),
        );

        return collect($data['standings'] ?? [])
            ->map(fn (array $team) => StandingData::from([
                'abbreviation' => $team['teamAbbrev']['default'] ?? '',
                'name' => $team['teamName']['default'] ?? '',
                'logo' => $team['teamLogo'] ?? '',
                'games_played' => $team['gamesPlayed'] ?? 0,
                'wins' => $team['wins'] ?? 0,
                'losses' => $team['losses'] ?? 0,
                'ot_losses' => $team['otLosses'] ?? 0,
                'points' => $team['points'] ?? 0,
            ]));
    }

    public function teamStats(string $team): ?array
    {
        return $this->standings()
            ->first(fn (StandingData $s) => $s->abbreviation === $team)
            ?->toArray();
    }

    private function mapTeam(array $team, Collection $standings): array
    {
        $abbr = $team['abbrev'] ?? '';
        $standing = $standings->first(fn (StandingData $s) => $s->abbreviation === $abbr);

        return [
            'abbreviation' => $abbr,
            'name' => $team['placeName']['default'] ?? $abbr,
            'logo' => $team['logo'] ?? '',
            'stats' => $standing ? TeamStatsData::from([
                'wins' => $standing->wins,
                'losses' => $standing->losses,
                'ot_losses' => $standing->ot_losses,
                'points' => $standing->points,
                'games_played' => $standing->games_played,
            ])->toArray() : null,
        ];
    }

    private function get(string $endpoint): array
    {
        return Http::baseUrl($this->baseUrl)
            ->get($endpoint)
            ->throw()
            ->json();
    }
}
