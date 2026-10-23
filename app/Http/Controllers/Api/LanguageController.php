<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpeakingLanguageRequest;
use App\Services\SpeakingLanguageService;
use Illuminate\Http\JsonResponse;

class LanguageController extends Controller
{
    public function __construct(
        private readonly SpeakingLanguageService $speakingLanguageService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->speakingLanguageService->getAll());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->speakingLanguageService->getById($id));
    }

    public function store(SpeakingLanguageRequest $request): JsonResponse
    {
        return response()->json($this->speakingLanguageService->create($request), 201);
    }

    public function update(SpeakingLanguageRequest $request, int $id): JsonResponse
    {
        return response()->json($this->speakingLanguageService->update($id, $request));
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json(['deleted' => $this->speakingLanguageService->delete($id)]);
    }
}
