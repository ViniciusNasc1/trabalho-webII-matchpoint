<?php

namespace App\Repositories;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Model;
use Override;

class TournamentRepository extends BaseRepository{

    protected Tournament $tournamentModel;

    public function __construct(Tournament $tournamentModel) {
        $this->tournamentModel = $tournamentModel->create;
    }

    #[Override]
    protected function getModel(): Model
    {
        return $this->tournamentModel->newInstance();
    }

}

?>
