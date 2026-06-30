<?php

namespace App\Repositories;

use App\Models\Matchup;
use Illuminate\Database\Eloquent\Model;
use Override;

class MatchupRepository extends BaseRepository{

    protected Matchup $matchupModel;

    public function __construct(Matchup $matchupModel) {
        $this->matchupModel = $matchupModel;
    }

    #[Override]
    protected function getModel(): Model
    {
        return $this->matchupModel->newInstance();
    }
}
