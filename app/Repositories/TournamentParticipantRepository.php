<?php

namespace App\Repositories;

use App\Models\TournamentParticipant;
use Illuminate\Database\Eloquent\Model;
use Override;

class TournamentParticipantRepository extends BaseRepository{

    protected TournamentParticipant $tournamentParticipantModel;

    public function __construct(TournamentParticipant $tournamentParticipantModel) {
        $this->tournamentParticipantModel = $tournamentParticipantModel;
    }

    #[Override]
    protected function getModel(): Model
    {
        return $this->tournamentParticipantModel->newInstance();
    }

}
