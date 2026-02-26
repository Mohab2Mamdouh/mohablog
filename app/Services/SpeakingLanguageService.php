<?php

namespace App\Services;

use App\Http\Requests\SpeakingLanguageRequest;
use App\Repositories\Contracts\SpeakingLanguageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SpeakingLanguageService
{
    public function __construct(
        private readonly SpeakingLanguageRepositoryInterface $speakingLanguageRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->speakingLanguageRepository->getAll();
    }

    public function getById(int $id): ?Model
    {
        return $this->speakingLanguageRepository->getById($id);
    }

    public function create(SpeakingLanguageRequest $request): ?Model
    {
        return $this->speakingLanguageRepository->create($request->validated());
    }

    public function update(int $id, SpeakingLanguageRequest $request): ?Model
    {
        return $this->speakingLanguageRepository->update($id, $request->validated());
    }

    public function delete(int $id): bool
    {
        return $this->speakingLanguageRepository->delete($id);
    }
}

