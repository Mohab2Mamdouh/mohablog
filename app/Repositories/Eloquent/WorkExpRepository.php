<?php

namespace App\Repositories\Eloquent;

use App\Models\WorkExp;
use App\Repositories\Contracts\WorkExpRepositoryInterface;

class WorkExpRepository extends Repository implements WorkExpRepositoryInterface
{
    public function __construct(WorkExp $model)
    {
        parent::__construct($model);
    }
}

