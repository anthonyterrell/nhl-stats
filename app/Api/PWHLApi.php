<?php

namespace App\Api;

use App\Concerns\FetchesHockeyData;
use App\Contracts\HockeyLeague;
use App\Data\GameData;
use App\Data\StandingData;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PWHLApi implements HockeyLeague
{
    use FetchesHockeyData;

    private string $baseUrl;

    private string $timezone;

    private string $key;

    private string $clientCode;

    private string $seasonId;

    public function __construct()
    {
        $this->baseUrl = config('hockey.pwhl.url');
        $this->timezone = config('hockey.timezone');
        $this->key = config('hockey.pwhl.key');
        $this->clientCode = config('hockey.pwhl.client_code');
        $this->seasonId = config('hockey.pwhl.season_id');
    }

    public function schedule(string $team = ''): Collection
    {
        $data = $this->cachedGet(
            "pwhl.schedule.{$this->seasonId}",
            config('hockey.pwhl.ttl_schedule'),
            fn () => $this->get([
                'feed' => 'modulekit',
                'view' => 'schedule',
                'season_id' => $this->seasonId,
            ]),
        );

        $games = collect($this->extractData($data));

        return $games
            ->reject(fn (array $game) => ! empty($game['final']))
            ->map(fn (array $game) => GameData::from([
                'date' => Carbon::parse($game['date_with_day'] ?? $game['date'] ?? '')
                    ->format('Y-m-d'),
                'start_time' => Carbon::parse($game['date_with_day'] ?? $game['date'] ?? '')
                    ->setTimezone($this->timezone)
                    ->format('g:i A'),
                'is_preseason' => ($game['game_type'] ?? '') === 'Preseason',
                'away_team' => $this->mapTeam($game, 'visiting'),
                'home_team' => $this->mapTeam($game, 'home'),
            ]))
            ->values();
    }

    public function standings(): Collection
    {
        $data = $this->cachedGet(
            "pwhl.standings.{$this->seasonId}",
            config('hockey.pwhl.ttl_standings'),
            fn () => $this->get([
                'feed' => 'modulekit',
                'view' => 'statviewtype',
                'type' => 'standings',
                'stat' => 'conference',
                'season_id' => $this->seasonId,
            ]),
        );

        $sections = collect($this->extractData($data));

        return $sections
            ->pluck('teams')
            ->flatten(1)
            ->map(fn (array $team) => StandingData::from([
                'abbreviation' => $team['team_code'] ?? '',
                'name' => $team['name'] ?? '',
                'logo' => $team['logo'] ?? '',
                'games_played' => (int) ($team['games_played'] ?? 0),
                'wins' => (int) ($team['wins'] ?? 0),
                'losses' => (int) ($team['losses'] ?? 0),
                'ot_losses' => (int) ($team['ot_losses'] ?? 0),
                'points' => (int) ($team['points'] ?? 0),
            ]));
    }

    public function teamStats(string $team): ?array
    {
        return $this->standings()
            ->first(fn (StandingData $s) => $s->abbreviation === $team)
            ?->toArray();
    }

    private function mapTeam(array $game, string $side): array
    {
        return [
            'abbreviation' => $game["{$side}_team_code"] ?? '',
            'name' => $game["{$side}_team_city"] ?? '',
            'logo' => $game["{$side}_team_logo"] ?? '',
            'stats' => null,
        ];
    }

    private function get(array $params): array
    {
        return Http::get($this->baseUrl.'index.php', array_merge($params, [
            'key' => $this->key,
            'client_code' => $this->clientCode,
            'fmt' => 'json',
        ]))->throw()->json();
    }

    private function extractData(array $response): array
    {
        return $response['SiteKit']['Parameters'] ?? $response['SiteKit'] ?? $response;
    }
}
