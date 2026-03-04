<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageProcessingRequest;
use App\Services\ImageProcessingService;

class ImageProcessingController extends Controller
{
    public function __construct(
        private readonly ImageProcessingService $imageProcessingService
    ) {
        parent::__construct();
    }

    /**
     * Show the image processing form.
     */
    public function index()
    {
        return view('Admin.ImageProcessing.index');
    }

    /**
     * Process the image via Replicate API and return the result.
     */
    public function process(ImageProcessingRequest $request)
    {
        $imageBase64 = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $mime = $file->getMimeType();
            $imageBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        $result = $this->imageProcessingService->process(
            prompt: $request->validated('prompt'),
            negativePrompt: $request->validated('negative_prompt'),
            guidanceScale: (float) ($request->validated('guidance_scale') ?? 7.5),
            numInferenceSteps: (int) ($request->validated('num_inference_steps') ?? 50),
            imageBase64: $imageBase64,
        );

        return view('Admin.ImageProcessing.index', [
            'result'  => $result,
            'oldData' => $request->validated(),
        ]);
    }
}


