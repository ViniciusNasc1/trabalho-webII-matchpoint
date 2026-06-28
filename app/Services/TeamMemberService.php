<?php

    namespace App\Services;

use App\Repositories\BaseRepository;
use App\Repositories\TeamMemberRepository;
use Override;

    class TeamMemberService extends BaseService{

        public function __construct(protected TeamMemberRepository $teamMemberRepository) { }

        #[Override]
        protected function getRepository(): BaseRepository
        {
            return $this->teamMemberRepository;
        }
    }

?>
