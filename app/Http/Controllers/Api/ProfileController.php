<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalInfoRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function show(): JsonResponse
    {
        return response()->json($this->userService->getFirst());
    }

    public function update(PersonalInfoRequest $request): JsonResponse
    {
        return response()->json($this->userService->update($request));
    }
}
