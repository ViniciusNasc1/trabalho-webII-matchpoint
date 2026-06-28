<?php

namespace App\Repositories;

use App\Models\TournamentParticipant;
use Override;

class TournamentParticipantRepository extends BaseRepository{

    protected TournamentParticipant $tournamentParticipantModel;

    public function __construct(TournamentParticipant $tournamentParticipantModel) {
        $this->tournamentParticipantModel = $tournamentParticipantModel;
    }

    #[Override]
    protected function getModel(): mixed
    {
        return $this->tournamentParticipantModel;
    }

}
