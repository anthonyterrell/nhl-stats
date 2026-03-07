export interface TeamStats {
    wins: number;
    losses: number;
    ot_losses: number;
    points: number;
    games_played: number;
}

export interface TeamInfo {
    abbreviation: string;
    name: string;
    logo: string;
    stats: TeamStats | null;
}

export interface Game {
    date: string;
    start_time: string;
    is_preseason: boolean;
    away_team: TeamInfo;
    home_team: TeamInfo;
}

export interface TeamStanding {
    abbreviation: string;
    name: string;
    logo: string;
    games_played: number;
    wins: number;
    losses: number;
    ot_losses: number;
    points: number;
}

export interface DashboardProps {
    league: 'nhl' | 'pwhl';
    games: Game[];
    standings: TeamStanding[];
}
