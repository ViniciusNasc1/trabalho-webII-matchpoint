<?php

namespace App\Repositories;

use App\Models\Tournament;
use Override;

class TournamentRepository extends BaseRepository{

    protected Tournament $tournamentModel;

    public function __construct(Tournament $tournamentModel) {
        $this->tournamentModel = $tournamentModel;
    }

    #[Override]
    protected function getModel(): mixed
    {
        return $this->tournamentModel;
    }

}

?>
