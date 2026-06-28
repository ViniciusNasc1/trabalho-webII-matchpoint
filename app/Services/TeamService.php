<?php

    namespace App\Services;

use App\Repositories\BaseRepository;
use App\Repositories\TeamRepository;
use Override;

    class TeamService extends BaseService{
        public function __construct(protected TeamRepository $teamRepository) {  }

        #[Override]
        protected function getRepository(): BaseRepository
        {
            return $this->teamRepository;
        }
    }

?>
