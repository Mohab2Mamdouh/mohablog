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

    public function getAllOrdered(string $orderBy = 'order', string $order = 'ASC'): Collection
    {
        return $this->projectRepository->query(
            scopes: ['showAtCV'],
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

    public function toggleCV(int $id): ?Model
    {
        $project = $this->projectRepository->getById($id);

        return $this->projectRepository->update($id, ['show_at_cv' => !$project->show_at_cv]);
    }

    /**
     *
     * @param array $orderedIds [position0 => projectId, position1 => projectId, …]
     */
    public function updateOrder(array $orderedIds): void
    {
        foreach ($orderedIds as $position => $id) {
            $this->projectRepository->update((int) $id, ['order' => $position + 1]);
        }
    }
}

