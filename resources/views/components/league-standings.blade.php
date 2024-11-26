<div class="my-8 px-4 flow-root">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0"></th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">GP</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">W</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">L</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">OTL</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">PTS</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @foreach($standings->standings as $team)
                        <tr>
                            <td class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                <img src="{{ $team->teamLogo}}" class="h-12 w-12 sm:h-14 sm:w-14">
                            </td>
                            <td class="whitespace-nowrap px-3 py-1 text-xs sm:text-sm text-gray-500">{{ $team->gamesPlayed}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-xs sm:text-sm text-gray-500">{{ $team->wins}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-xs sm:text-sm text-gray-500">{{ $team->losses}}</td>
                            <td class="whitespace-nowrap px-3 py-1 text-xs sm:text-sm text-gray-500">{{ $team->otLosses}}</td>
                            <td class="whitespace-nowrap px-3 py-3 text-xs sm:text-sm text-gray-500">{{ $team->points}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-legend />
