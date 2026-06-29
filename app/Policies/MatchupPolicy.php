<?php

namespace App\Policies;

use App\Models\Matchup;
use App\Models\User;

class MatchupPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Matchup $matchup): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Matchup $matchup): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Matchup $matchup): bool
    {
        return $user->isAdmin();
    }
}
