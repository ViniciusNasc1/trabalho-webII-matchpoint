<?php

    namespace App\Services;

use App\Repositories\BaseRepository;
use App\Repositories\ResultRepository;
use Override;

    class ResultService extends BaseService{

        public function __construct(protected ResultRepository $resultRepository) {
        }

        #[Override]
        protected function getRepository(): BaseRepository
        {
            return $this->resultRepository;
        }
    }

?>
