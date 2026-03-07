import { router } from '@inertiajs/react';

interface LeagueSwitcherProps {
    current: 'nhl' | 'pwhl';
}

const leagues = [
    { key: 'nhl' as const, label: 'NHL', path: '/nhl' },
    { key: 'pwhl' as const, label: 'PWHL', path: '/pwhl' },
];

export function LeagueSwitcher({ current }: LeagueSwitcherProps) {
    return (
        <div className="mt-4 inline-flex rounded-lg bg-slate-800 p-1">
            {leagues.map(({ key, label, path }) => (
                <button
                    key={key}
                    onClick={() => router.visit(path)}
                    className={`rounded-md px-4 py-2 text-sm font-medium transition-colors ${
                        current === key
                            ? 'bg-slate-600 text-white'
                            : 'text-slate-400 hover:text-white'
                    }`}
                >
                    {label}
                </button>
            ))}
        </div>
    );
}
