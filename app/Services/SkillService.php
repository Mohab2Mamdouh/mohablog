<?php

namespace App\Services;

use App\Http\Requests\SkillRequest;
use App\Repositories\Contracts\SkillRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SkillService
{
    public function __construct(
        private readonly SkillRepositoryInterface $skillRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->skillRepository->getAll();
    }

    public function getByType(string $type): array|Collection
    {
        return $this->skillRepository->get('type', $type);
    }

    public function getById(int $id): ?Model
    {
        return $this->skillRepository->getById($id);
    }

    public function create(SkillRequest $request): ?Model
    {
        $data = $request->validated();
        return $this->skillRepository->create($data);
    }

    public function update(int $id, SkillRequest $request): ?Model
    {
        $data = $request->validated();

        return $this->skillRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->skillRepository->delete($id);
    }
}

