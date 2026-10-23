<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillRequest;
use App\Services\SkillService;
use Illuminate\Http\JsonResponse;

class SkillController extends Controller
{
    public function __construct(
        private readonly SkillService $skillService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->skillService->getAll());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->skillService->getById($id));
    }

    public function store(SkillRequest $request): JsonResponse
    {
        return response()->json($this->skillService->create($request), 201);
    }

    public function update(SkillRequest $request, int $id): JsonResponse
    {
        return response()->json($this->skillService->update($id, $request));
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json(['deleted' => $this->skillService->delete($id)]);
    }
}
