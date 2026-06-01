<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageProcessingRequest;
use App\Services\ImageProcessingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImageProcessingController extends Controller
{
    public function __construct(
        private readonly ImageProcessingService $imageProcessingService
    ) {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Show the image processing form.
     */
    public function index()
    {
        return view('Admin.ImageProcessing.index');
    }

    /**
     * Create a prediction via AJAX. Returns prediction ID + poll URL.
     */
    public function process(ImageProcessingRequest $request): JsonResponse
    {
        $imageBase64 = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $mime = $file->getMimeType();
            $imageBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        $result = $this->imageProcessingService->createPrediction(
            prompt: $request->validated('prompt'),
            negativePrompt: $request->validated('negative_prompt'),
            guidanceScale: (float) ($request->validated('guidance_scale') ?? 7.5),
            numInferenceSteps: (int) ($request->validated('num_inference_steps') ?? 50),
            imageBase64: $imageBase64,
        );

        return response()->json($result);
    }

    /**
     * Poll the prediction status via AJAX.
     */
    public function poll(Request $request): JsonResponse
    {
        $pollUrl = $request->input('poll_url');

        if (empty($pollUrl)) {
            return response()->json([
                'success' => false,
                'error'   => 'No poll URL provided.',
            ], 400);
        }

        $result = $this->imageProcessingService->pollPrediction($pollUrl);

        return response()->json($result);
    }
}


