<ul role="list" class="divide-y divide-gray-800">
@foreach($schedule->games as $game)
    <li class="flex justify-between gap-x-6 py-5">
    <div class="flex min-w-0 gap-x-4">
        <img src="{{ $game->awayTeam->logo}}" class="h-16 w-16">
    </div>

    <div class="hidden sm:flex sm:flex-col sm:items-center">
        <p class="text-sm leading-6">{{ $game->gameDate }}</p>
        <p class="text-sm leading-6">V.S.</p>
    </div>

    <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
        <img src="{{ $game->homeTeam->logo}}" class="h-16 w-16">
    </div>
    </li>
@endforeach
</ul>
