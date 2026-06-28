<?php

    namespace App\Services;

use App\Repositories\BaseRepository;
use App\Repositories\GameRepository;
use Override;

    class GameService extends BaseService{
        public function __construct(protected GameRepository $gameRepository){}

        #[Override]
        protected function getRepository(): BaseRepository
        {
            return $this->gameRepository;
        }
    }

?>
