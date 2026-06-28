<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use App\Repositories\TournamentRepository;
use Override;

    class TournamentService extends BaseService{
        public function __construct(protected TournamentRepository $tournamentRepository) { }

        #[Override]
        protected function getRepository(): BaseRepository
        {
            return $this->tournamentRepository;
        }
    }

?>
