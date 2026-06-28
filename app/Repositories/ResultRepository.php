<?php

namespace App\Repositories;

use App\Models\Result;
use Override;

class ResultRepository extends BaseRepository{

    protected Result $resultModel;

    public function __construct(Result $resultModel) {
        $this->resultModel = $resultModel;
    }

    #[Override]
    protected function getModel(): mixed
    {
        return $this->resultModel;
    }
}


?>
