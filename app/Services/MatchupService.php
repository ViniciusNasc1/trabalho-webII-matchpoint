<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use App\Repositories\MatchupRepository;
use Override;

    class MatchupService extends BaseService{
        public function __construct(protected MatchupRepository $matchupRepository) {
        }

        #[Override]
        protected function getRepository(): BaseRepository
        {
            return $this->matchupRepository;
        }

    }
?>
