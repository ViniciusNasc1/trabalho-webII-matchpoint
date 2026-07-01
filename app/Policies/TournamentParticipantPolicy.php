<?php

namespace App\Policies;

use App\Models\TournamentParticipant;
use App\Models\User;

class TournamentParticipantPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TournamentParticipant $participant): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, TournamentParticipant $participant): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, TournamentParticipant $participant): bool
    {
        return $user->isAdmin();
    }
}