<x-app>
    <div class="w-full md:max-w-2xl mx-auto p-4">
        <h1 class="text-2xl text-center mb-8 font-bold"> {{ currentSeason() . ' Season' }}</h1>

        <x-upcoming-games :games="$schedule->take(3)" />

        @if(inPreSeason())
            <div class="mt-8">
                <p class="text-sm text-gray-500">
                    <span class="font-bold">These are last seasons standings</span>.
                    Preseason games are not counted towards the regular season standings.
                </p>
            </div>
        @endif

        <x-league-standings :standings="$standings" />
    </div>
</x-app>
