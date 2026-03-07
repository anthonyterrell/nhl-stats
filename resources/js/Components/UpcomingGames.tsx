import { Game } from '../types';

interface UpcomingGamesProps {
    games: Game[];
}

function TeamBlock({ team }: { team: Game['away_team'] }) {
    const record = team.stats
        ? `${team.stats.wins}-${team.stats.losses}-${team.stats.ot_losses}`
        : '';

    return (
        <div className="flex flex-col items-center gap-1">
            <img src={team.logo} alt={team.name} className="h-12 w-12 sm:h-14 sm:w-14" />
            <span className="text-xs text-slate-400">{record}</span>
        </div>
    );
}

export function UpcomingGames({ games }: UpcomingGamesProps) {
    if (games.length === 0) {
        return (
            <div className="rounded-lg bg-slate-800 p-8 text-center">
                <p className="text-slate-400">No upcoming games scheduled</p>
            </div>
        );
    }

    return (
        <div className="space-y-3">
            <h2 className="text-lg font-semibold">Upcoming Games</h2>
            {games.map((game, i) => (
                <div
                    key={i}
                    className="flex items-center justify-between rounded-lg bg-slate-800 px-4 py-3 sm:px-6"
                >
                    <TeamBlock team={game.away_team} />

                    <div className="flex flex-col items-center gap-1 text-center">
                        <span className="text-sm text-slate-300">{game.date}</span>
                        <span className="text-xs text-slate-400">{game.start_time}</span>
                        {game.is_preseason && (
                            <span className="rounded bg-amber-600 px-2 py-0.5 text-xs font-medium">
                                Preseason
                            </span>
                        )}
                    </div>

                    <TeamBlock team={game.home_team} />
                </div>
            ))}
        </div>
    );
}
