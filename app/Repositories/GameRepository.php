<?php

namespace App\Repositories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Model;
use Override;

class GameRepository extends BaseRepository{

    protected Game $gameModel;

    public function __construct(Game $gameModel) {
        $this->gameModel = $gameModel;
    }

    #[Override]
    protected function getModel(): Model
    {
        return $this->gameModel->newInstance();
    }
}
