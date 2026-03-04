<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImageProcessingService
{
    private string $apiUrl = 'https://api.replicate.com/v1/predictions';
    private string $version = '82889ab45063cf4fdaf7cf386fc739da0b5ddc4b6a6b0f8ff31a2951b0c1ca4d';

    private int $maxPollAttempts = 120; // max ~4 minutes of polling
    private int $pollIntervalSeconds = 2;

    /**
     * Create a prediction on Replicate (non-blocking).
     * Returns the prediction data including the 'get' URL for polling.
     */
    public function createPrediction(
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
            ])->timeout(60)->post($this->apiUrl, [
                'version' => $this->version,
                'input'   => $input,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success'       => true,
                    'data'          => $data,
                    'prediction_id' => $data['id'] ?? null,
                    'status'        => $data['status'] ?? 'unknown',
                    'output'        => $data['output'] ?? null,
                    'poll_url'      => $data['urls']['get'] ?? null,
                    'stream_url'    => $data['urls']['stream'] ?? null,
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

    /**
     * Poll a prediction by its GET URL until it completes or fails.
     */
    public function pollPrediction(string $pollUrl): array
    {
        $token = config('services.replicate.api_token');

        if (empty($token)) {
            return [
                'success' => false,
                'error'   => 'Replicate API token is not configured.',
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->timeout(30)->get($pollUrl);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'data'    => $data,
                    'status'  => $data['status'] ?? 'unknown',
                    'output'  => $data['output'] ?? null,
                    'error'   => $data['error'] ?? null,
                    'logs'    => $data['logs'] ?? '',
                ];
            }

            return [
                'success' => false,
                'error'   => 'Poll returned status ' . $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('Replicate poll exception', ['message' => $e->getMessage()]);

            return [
                'success' => false,
                'error'   => 'Failed to poll prediction: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Synchronous process: create prediction, then poll until complete.
     * Kept for backward compatibility.
     */
    public function process(
        string  $prompt,
        ?string $negativePrompt = 'low quality, blurry, watermark, unrealistic',
        float   $guidanceScale = 7.5,
        int     $numInferenceSteps = 50,
        ?string $imageBase64 = null,
    ): array {
        $createResult = $this->createPrediction($prompt, $negativePrompt, $guidanceScale, $numInferenceSteps, $imageBase64);

        if (!$createResult['success']) {
            return $createResult;
        }

        // If output is already available (Prefer: wait worked), return immediately
        if (!empty($createResult['output'])) {
            return $createResult;
        }

        $pollUrl = $createResult['poll_url'] ?? null;
        if (!$pollUrl) {
            return [
                'success' => false,
                'error'   => 'No poll URL returned from Replicate API.',
                'data'    => $createResult['data'] ?? [],
            ];
        }

        // Poll until done
        for ($i = 0; $i < $this->maxPollAttempts; $i++) {
            sleep($this->pollIntervalSeconds);

            $pollResult = $this->pollPrediction($pollUrl);

            if (!$pollResult['success']) {
                return $pollResult;
            }

            $status = $pollResult['status'];

            if ($status === 'succeeded') {
                return [
                    'success' => true,
                    'data'    => $pollResult['data'],
                    'output'  => $pollResult['output'],
                    'status'  => 'succeeded',
                ];
            }

            if (in_array($status, ['failed', 'canceled'])) {
                return [
                    'success' => false,
                    'error'   => 'Prediction ' . $status . ': ' . ($pollResult['error'] ?? 'Unknown error'),
                    'data'    => $pollResult['data'],
                ];
            }

            // Still processing, continue polling...
        }

        return [
            'success' => false,
            'error'   => 'Prediction timed out after polling ' . $this->maxPollAttempts . ' times.',
        ];
    }
}

