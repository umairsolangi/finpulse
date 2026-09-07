# FinPulse

**Learn. Track. Invest.**

FinPulse is a financial-education platform being built to take retail investors through a simple funnel: **free community → structured learning → paid subscriptions, research, and live sessions.** The long-term goal is to build enough trust through education that users eventually open a brokerage account through the platform.

This isn't a copy of any single competitor — it borrows proven pieces from platforms like Zerodha Varsity (deep free content builds trust) and applies them to a Pakistani retail audience that currently has no dedicated platform of its own.

## How it works — three phases

1. **Community (Weeks 1–6)** — Open discussion feed, short free explainer videos/glossaries, badges and lightweight gamification.
2. **Structured Learning (Weeks 7–12)** — A proper LMS: courses, chapters, quizzes, completion certificates, and weekly research summaries in plain language.
3. **Monetization & Live Access (Weeks 13–18)** — Paid subscriptions for research/advanced courses, paid live webinars and 1-on-1 sessions, and a direct path to brokerage account signup.

## Tech stack

| Layer | Choice |
|---|---|
| Framework | Laravel (monolith — backend and frontend in one project) |
| Frontend | Blade + Livewire (interactive components without a separate JS frontend) |
| Auth | Laravel Breeze |
| Database | MySQL |
| Testing | Pest |
| Real-time (planned) | Laravel Reverb |
| Roles & permissions (planned) | Spatie laravel-permission |

This stack was chosen deliberately over a Next.js + Supabase split because the team is already experienced with Laravel from prior client work, and it's a solo/small-team build — one codebase is the right tradeoff here, not a limitation.

## User roles

- **Guest** — browses free content only
- **Free Member** — community + free content
- **Paid Subscriber** — free tier + paid research, courses, and live sessions
- **Instructor / Content Manager** — uploads and tiers content
- **Moderator** — manages the community feed
- **Admin** — full access (kept to 1–2 people only)

## Local setup

```bash
git clone <repo-url> finpulse
cd finpulse
composer install
cp .env.example .env
php artisan key:generate
```

Update `.env` with your MySQL database credentials, then:

```bash
php artisan migrate
npm install
npm run dev
php artisan serve
```

Run tests with:

```bash
php artisan test
```

## Status

Early build — Phase 1 (community feed + free content) in progress. See the project proposal document for the full roadmap, cost estimates, and risk notes.

## License

Internal project — license to be determined.
