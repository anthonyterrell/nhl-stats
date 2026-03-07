import { ReactNode } from 'react';
import { LeagueSwitcher } from './LeagueSwitcher';

interface LayoutProps {
    league: 'nhl' | 'pwhl';
    children: ReactNode;
}

export function Layout({ league, children }: LayoutProps) {
    return (
        <div className="min-h-screen bg-slate-900 text-white">
            <div className="mx-auto max-w-4xl px-4 py-8">
                <header className="mb-8 text-center">
                    <h1 className="text-3xl font-bold tracking-tight">Standings</h1>
                    <LeagueSwitcher current={league} />
                </header>
                <main>{children}</main>
            </div>
        </div>
    );
}
