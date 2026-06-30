<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Override;

class TeamRepository extends BaseRepository {
    protected Team $teamModel;

    public function __construct(Team $teamModel) {
        $this->teamModel = $teamModel;
    }

    #[Override]
    protected function getModel(): Model
    {
        return $this->teamModel->newInstance();
    }
}

?>
