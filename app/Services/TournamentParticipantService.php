<?php

    namespace App\Services;

use App\Repositories\BaseRepository;
use App\Repositories\TournamentParticipantRepository;
use Override;

    class TournamentParticipantService extends BaseService{
        public function __construct(protected TournamentParticipantRepository $tournamentParticipantRepository){ }

        #[Override]
        protected function getRepository(): BaseRepository
        {
            return $this->tournamentParticipantRepository;
        }
    }



?>
