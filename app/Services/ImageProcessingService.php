<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImageProcessingService
{
    private string $apiUrl = 'https://api.replicate.com/v1/predictions';
    private string $version = '82889ab45063cf4fdaf7cf386fc739da0b5ddc4b6a6b0f8ff31a2951b0c1ca4d';

    /**
     * Call the Replicate API with the given parameters.
     *
     * @param string $prompt
     * @param string|null $negativePrompt
     * @param float $guidanceScale
     * @param int $numInferenceSteps
     * @param string|null $imageBase64  Base64-encoded image (data URI) for image-to-image
     * @return array
     */
    public function process(
        string  $prompt,
        ?string $negativePrompt = 'low quality, blurry, watermark, unrealistic',
        float   $guidanceScale = 7.5,
        int     $numInferenceSteps = 50,
        ?string $imageBase64 = null,
    ): array {
        $token = config('services.replicate.api_token');

        if (empty($token)) {
            return [
                'success' => false,
                'error'   => 'Replicate API token is not configured. Please set REPLICATE_API_TOKEN in your .env file.',
            ];
        }

        $input = [
            'prompt'              => $prompt,
            'guidance_scale'      => $guidanceScale,
            'negative_prompt'     => $negativePrompt ?? '',
            'num_inference_steps' => $numInferenceSteps,
        ];

        if ($imageBase64) {
            $input['image'] = $imageBase64;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
                'Prefer'        => 'wait',
            ])->timeout(300)->post($this->apiUrl, [
                'version' => $this->version,
                'input'   => $input,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'data'    => $data,
                    'output'  => $data['output'] ?? null,
                    'status'  => $data['status'] ?? 'unknown',
                ];
            }

            Log::error('Replicate API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return [
                'success' => false,
                'error'   => 'API returned status ' . $response->status() . ': ' . $response->body(),
            ];
        } catch (\Exception $e) {
            Log::error('Replicate API exception', ['message' => $e->getMessage()]);

            return [
                'success' => false,
                'error'   => 'Failed to call Replicate API: ' . $e->getMessage(),
            ];
        }
    }
}

