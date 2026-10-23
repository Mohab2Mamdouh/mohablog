<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use App\Services\SkillService;
use App\Services\SpeakingLanguageService;
use App\Services\UserService;
use App\Services\WorkExpService;
use Illuminate\Http\JsonResponse;

class ExportController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly ProjectService $projectService,
        private readonly SkillService $skillService,
        private readonly WorkExpService $workExpService,
        private readonly SpeakingLanguageService $speakingLanguageService,
    ) {}

    public function __invoke(): JsonResponse
    {
        return response()->json([
            'exported_at'    => now()->toIso8601String(),
            'profile'        => $this->userService->getFirst(),
            'projects'       => $this->projectService->getAll()->sortBy(fn ($p) => $p->order ?? PHP_INT_MAX)->values(),
            'skills'         => $this->skillService->getAll(),
            'work_exps'      => $this->workExpService->getAllOrdered(),
            'languages'      => $this->speakingLanguageService->getAll(),
            'cv_pdf_url'     => route('downloadPDF'),
            'cv_markdown_url'=> route('cv.markdown'),
        ]);
    }
}
