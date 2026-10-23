<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectOrderRequest;
use App\Http\Requests\ProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectService $projectService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json(
            $this->projectService->getAll()
                ->sortBy(fn ($project) => $project->order ?? PHP_INT_MAX)
                ->values()
        );
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->projectService->getById($id));
    }

    public function store(ProjectRequest $request): JsonResponse
    {
        return response()->json($this->projectService->create($request), 201);
    }

    public function update(ProjectRequest $request, int $id): JsonResponse
    {
        return response()->json($this->projectService->update($id, $request));
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json(['deleted' => $this->projectService->delete($id)]);
    }

    public function toggleCV(int $id): JsonResponse
    {
        return response()->json($this->projectService->toggleCV($id));
    }

    public function updateOrder(ProjectOrderRequest $request): JsonResponse
    {
        $this->projectService->updateOrder($request->validated('order'));

        return $this->index();
    }
}
