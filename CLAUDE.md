# Standings — Hockey Dashboard

## Architecture

- **Backend**: Laravel 11 (PHP 8.4)
- **Frontend**: React 19 + Inertia.js + TypeScript
- **Styling**: Tailwind CSS v4 (via `@tailwindcss/vite`)
- **Testing**: Pest PHP
- **Data layer**: Spatie Laravel Data DTOs — no database, read-only from external APIs

## Commands

- `php artisan serve` — start backend dev server
- `npm run dev` — start Vite dev server (run alongside artisan)
- `npm run build` — production frontend build
- `php artisan test` — run Pest test suite
- `./vendor/bin/pint` — fix PHP code style

## Project Conventions

### Backend

- Both NHL and PWHL APIs implement the `HockeyLeague` interface (`app/Contracts/HockeyLeague.php`)
- Shared caching/filtering logic lives in the `FetchesHockeyData` trait (`app/Concerns/FetchesHockeyData.php`)
- API responses are mapped to Spatie Data DTOs (`app/Data/`) for type safety and consistent structure
- Actions (`app/Actions/`) encapsulate controller-level business logic
- Lean on Laravel collections to avoid nested conditionals; call `->toArray()` at boundaries
- Configuration lives in `config/hockey.php` — NHL and PWHL settings, timezone, cache TTLs
- No global helper functions — use dependency injection and actions

### Frontend

- Inertia entry point: `resources/js/app.tsx`
- Pages in `resources/js/Pages/`, components in `resources/js/Components/`
- TypeScript interfaces in `resources/js/types.ts` mirror the Spatie Data DTO shapes
- League switching uses `router.visit()` — no client-side state for league selection

### Testing

- Use `Http::fake()` to mock external API calls
- Test normalized DTO shapes from both APIs
- Test Inertia page rendering with correct props

## API Sources

- **NHL**: `https://api-web.nhle.com/v1/` (no auth)
- **PWHL**: `https://lscluster.hockeytech.com/feed/` (key + client_code params)

## Environment Variables

- `NHL_TEAM` — default NHL team abbreviation (default: `CHI`)
- `PWHL_TEAM` — default PWHL team identifier (default: empty)
- `PWHL_API_KEY` — HockeyTech API key (default provided)
- `PWHL_SEASON_ID` — current PWHL season ID (default: `5`)
- `HOCKEY_TIMEZONE` — display timezone (default: `America/Chicago`)
