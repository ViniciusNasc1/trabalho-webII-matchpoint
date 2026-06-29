<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function create(): bool
    {
        return true;
    }

    public function update(User $user, Team $team): bool
    {
        return $user->isAdmin() || $user->id === $team->owner_id;
    }

    public function delete(User $user, Team $team): bool
    {
        return $user->isAdmin() || $user->id === $team->owner_id;
    }
}
