<?php

namespace App\Repositories\Eloquent;

use App\Models\Skill;
use App\Repositories\Contracts\SkillRepositoryInterface;

class SkillRepository extends Repository implements SkillRepositoryInterface
{
    public function __construct(Skill $model)
    {
        parent::__construct($model);
    }
}

