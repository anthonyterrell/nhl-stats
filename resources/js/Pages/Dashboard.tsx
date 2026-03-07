import { Layout } from '../Components/Layout';
import { UpcomingGames } from '../Components/UpcomingGames';
import { LeagueStandings } from '../Components/LeagueStandings';
import { DashboardProps } from '../types';

export default function Dashboard({ league, games, standings }: DashboardProps) {
    return (
        <Layout league={league}>
            <UpcomingGames games={games} />
            <LeagueStandings standings={standings} />
        </Layout>
    );
}
