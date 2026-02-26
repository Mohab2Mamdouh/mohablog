<?php

namespace App\Repositories\Eloquent;

use App\Models\SpeakingLanguage;
use App\Repositories\Contracts\SpeakingLanguageRepositoryInterface;

class SpeakingLanguageRepository extends Repository implements SpeakingLanguageRepositoryInterface
{
    public function __construct(SpeakingLanguage $model)
    {
        parent::__construct($model);
    }
}

