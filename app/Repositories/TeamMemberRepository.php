<?php

namespace App\Repositories;

use App\Models\TeamMember;
use Override;

class TeamMemberRepository extends BaseRepository{

    protected TeamMember $teamMemberModel;

    public function __construct(TeamMember $teamMemberModel) {
        $this->teamMemberModel = $teamMemberModel;
    }

    #[Override]
    protected function getModel(): mixed
    {
        return $this->teamMemberModel;
    }
}

?>
