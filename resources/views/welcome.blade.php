<x-app>
    <div class="w-full md:max-w-2xl mx-auto p-4">
        <x-upcoming-games :games="$schedule->take(3)" />
        @include('standings')
    </div>
</x-app>
