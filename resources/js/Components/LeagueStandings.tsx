import { TeamStanding } from '../types';

interface LeagueStandingsProps {
    standings: TeamStanding[];
}

export function LeagueStandings({ standings }: LeagueStandingsProps) {
    if (standings.length === 0) {
        return (
            <div className="rounded-lg bg-slate-800 p-8 text-center">
                <p className="text-slate-400">Standings unavailable</p>
            </div>
        );
    }

    return (
        <div className="mt-8">
            <h2 className="mb-3 text-lg font-semibold">Standings</h2>
            <div className="overflow-x-auto rounded-lg bg-slate-800">
                <table className="min-w-full">
                    <thead>
                        <tr className="border-b border-slate-700 text-left text-xs font-medium uppercase tracking-wider text-slate-400">
                            <th className="px-4 py-3">Team</th>
                            <th className="px-3 py-3">GP</th>
                            <th className="px-3 py-3">W</th>
                            <th className="px-3 py-3">L</th>
                            <th className="px-3 py-3">OTL</th>
                            <th className="px-3 py-3">PTS</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-700">
                        {standings.map((team) => (
                            <tr key={team.abbreviation} className="text-sm">
                                <td className="whitespace-nowrap px-4 py-2">
                                    <div className="flex items-center gap-3">
                                        <img
                                            src={team.logo}
                                            alt={team.name}
                                            className="h-8 w-8 sm:h-10 sm:w-10"
                                        />
                                        <span className="hidden font-medium sm:inline">
                                            {team.name}
                                        </span>
                                    </div>
                                </td>
                                <td className="whitespace-nowrap px-3 py-2 text-slate-300">
                                    {team.games_played}
                                </td>
                                <td className="whitespace-nowrap px-3 py-2 text-slate-300">
                                    {team.wins}
                                </td>
                                <td className="whitespace-nowrap px-3 py-2 text-slate-300">
                                    {team.losses}
                                </td>
                                <td className="whitespace-nowrap px-3 py-2 text-slate-300">
                                    {team.ot_losses}
                                </td>
                                <td className="whitespace-nowrap px-3 py-2 font-semibold text-white">
                                    {team.points}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
}
