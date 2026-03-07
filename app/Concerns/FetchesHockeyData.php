<?php

namespace App\Concerns;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait FetchesHockeyData
{
    protected function cachedGet(string $key, int $ttl, Closure $fetcher): mixed
    {
        return Cache::remember($key, $ttl, $fetcher);
    }

    /** @return Collection<int, \App\Data\GameData> */
    public function upcomingGames(string $team, int $limit = 3): Collection
    {
        return $this->schedule($team)
            ->filter(fn ($game) => $game->date >= now()->format('Y-m-d'))
            ->take($limit)
            ->values();
    }
}
