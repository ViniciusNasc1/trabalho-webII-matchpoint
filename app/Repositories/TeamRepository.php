<?php

namespace App\Repositories;

use App\Models\Team;
use Override;

class TeamRepository extends BaseRepository {
    protected Team $teamModel;

    public function __construct(Team $teamModel) {
        $this->teamModel = $teamModel;
    }

    #[Override]
    protected function getModel(): mixed
    {
        return $this->teamModel;
    }
}

?>
