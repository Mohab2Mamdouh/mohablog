<?php

namespace App\Services;

use App\Enums\QueryReturnType;
use App\Http\Requests\ProjectRequest;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProjectService
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->projectRepository->getAll();
    }

    public function getAllOrdered(string $orderBy = 'endDate', string $order = 'DESC'): Collection
    {
        return $this->projectRepository->query(
            order: $order,
            orderBy: $orderBy,
        );
    }

    public function getById(int $id): ?Model
    {
        return $this->projectRepository->getById($id);
    }

    public function create(ProjectRequest $request): ?Model
    {
        $data = $request->validated();

        return $this->projectRepository->create($data);
    }

    public function update(int $id, ProjectRequest $request): ?Model
    {
        $data = $request->validated();

        return $this->projectRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->projectRepository->delete($id);
    }
}

