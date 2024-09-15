<div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow">
  <div class="px-4 py-5 sm:px-6 text-center font-semibold">Upcoming Games</div>
  <div class="px-4 py-5 sm:p-6">
    <ul role="list" class="divide-y divide-gray-200">
        @foreach($games as $game)
            <li class="flex justify-between gap-x-6 py-1 sm:py-2">
                <div class="flex flex-col min-w-0 gap-x-4">
                    <img src="{{ $game->awayTeam->logo}}" class="h-12 w-12">
                    @if($game->gameType == 1)
                        <p class="text-xs">Preseason</p>
                    @else
                        <p class="text-xs">
                            {{ $game->awayTeam->teamStatistics?->wins ?? 0 }}-{{ $game->awayTeam->teamStatistics?->losses ?? 0}}-{{ $game->awayTeam->teamStatistics?->otLosses ?? 0}}
                        </p>
                    @endunless
                </div>

                <div class="flex flex-col items-center justify-center">
                    <p class="text-sm font-medium">{{ now()->parse($game->gameDate)->format('M j') }}</p>
                    <p class="text-xs font-light">V.S.</p>
                </div>

                <div class="shrink-0 flex flex-col items-end">
                    <img src="{{ $game->homeTeam->logo}}" class="h-12 w-12">

                    @if($game->gameType == 1)
                        <p class="text-xs">Preseason</p>
                    @else
                        <p class="text-xs">
                            {{ $game->homeTeam->teamStatistics?->wins ?? 0 }}-{{ $game->homeTeam->teamStatistics?->losses ?? 0 }}-{{ $game->homeTeam->teamStatistics?->otLosses ?? 0 }}
                        </p>
                    @endunless
                </div>
            </li>
        @endforeach
    </ul>
  </div>
</div>
