<?php

namespace App\Providers;

use App\Models\Game;
use App\Models\Matchup;
use App\Models\Result;
use App\Models\Team;
use App\Models\Tournament;
use App\Policies\GamePolicy;
use App\Policies\MatchupPolicy;
use App\Policies\ResultPolicy;
use App\Policies\TeamPolicy;
use App\Policies\TournamentPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Game::class, GamePolicy::class);
        Gate::policy(Team::class, TeamPolicy::class);
        Gate::policy(Tournament::class, TournamentPolicy::class);
        Gate::policy(Matchup::class, MatchupPolicy::class);
        Gate::policy(Result::class, ResultPolicy::class);
    }
}