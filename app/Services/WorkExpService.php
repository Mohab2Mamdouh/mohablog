<?php

namespace App\Services;

use App\Enums\QueryReturnType;
use App\Http\Requests\WorkExpRequest;
use App\Repositories\Contracts\WorkExpRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class WorkExpService
{
    public function __construct(
        private readonly WorkExpRepositoryInterface $workExpRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->workExpRepository->getAll();
    }

    public function getAllOrdered(string $orderBy = 'startDate', string $order = 'DESC'): Collection
    {
        return $this->workExpRepository->query(
            order: $order,
            orderBy: $orderBy,
        );
    }

    public function getById(int $id): ?Model
    {
        return $this->workExpRepository->getById($id);
    }

    public function create(WorkExpRequest $request): ?Model
    {
        $data = $request->validated();

        if ($request->present) {
            $data['current'] = $request->present;
            $data['endDate'] = null;
        } else {
            $data['endDate'] = $request->endDate;
            $data['current'] = null;
        }

        return $this->workExpRepository->create($data);
    }

    public function update(int $id, WorkExpRequest $request): ?Model
    {
        $data = $request->validated();

        // The form uses both 'present' (store) and 'Present' (update)
        $presentValue = $request->Present ?? $request->present;

        if ($presentValue) {
            $data['current'] = $presentValue;
            $data['endDate'] = null;
        } else {
            $data['endDate'] = $request->endDate;
            $data['current'] = null;
        }

        return $this->workExpRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->workExpRepository->delete($id);
    }
}

