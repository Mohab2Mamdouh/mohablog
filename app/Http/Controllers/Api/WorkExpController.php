<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkExpRequest;
use App\Services\WorkExpService;
use Illuminate\Http\JsonResponse;

class WorkExpController extends Controller
{
    public function __construct(
        private readonly WorkExpService $workExpService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->workExpService->getAllOrdered());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->workExpService->getById($id));
    }

    public function store(WorkExpRequest $request): JsonResponse
    {
        return response()->json($this->workExpService->create($request), 201);
    }

    public function update(WorkExpRequest $request, int $id): JsonResponse
    {
        return response()->json($this->workExpService->update($id, $request));
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json(['deleted' => $this->workExpService->delete($id)]);
    }
}
