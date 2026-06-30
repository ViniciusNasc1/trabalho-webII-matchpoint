<?php

namespace App\Repositories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Model;
use Override;

class TeamMemberRepository extends BaseRepository{

    protected TeamMember $teamMemberModel;

    public function __construct(TeamMember $teamMemberModel) {
        $this->teamMemberModel = $teamMemberModel;
    }

    #[Override]
    protected function getModel(): Model
    {
        return $this->teamMemberModel->newInstance();
    }
}

?>
