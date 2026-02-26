<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Contracts
use App\Repositories\Contracts\SkillRepositoryInterface;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Repositories\Contracts\WorkExpRepositoryInterface;
use App\Repositories\Contracts\SpeakingLanguageRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

// Implementations
use App\Repositories\Eloquent\SkillRepository;
use App\Repositories\Eloquent\ProjectRepository;
use App\Repositories\Eloquent\WorkExpRepository;
use App\Repositories\Eloquent\SpeakingLanguageRepository;
use App\Repositories\Eloquent\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SkillRepositoryInterface::class, SkillRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(WorkExpRepositoryInterface::class, WorkExpRepository::class);
        $this->app->bind(SpeakingLanguageRepositoryInterface::class, SpeakingLanguageRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    public function boot(): void
    {
        //
    }
}

