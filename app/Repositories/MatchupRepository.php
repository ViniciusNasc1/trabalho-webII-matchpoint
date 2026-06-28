<?php

namespace App\Repositories;

use App\Models\Matchup;
use Override;

class MatchupRepository extends BaseRepository{

    protected Matchup $matchupModel;

    public function __construct(Matchup $matchupModel) {
        $this->$matchupModel = $matchupModel;
    }

    #[Override]
    public function getModel(): mixed
    {
        return $this->matchupModel;
    }
}
