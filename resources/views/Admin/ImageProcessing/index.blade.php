@php
    $title = "Image Processing"
@endphp

@extends('Admin.layouts.page')

@section('section')

<style>
    .breadcrumb-nav {
        padding: 20px 0;
        animation: fadeInDown 0.5s ease;
    }

    .breadcrumb-nav a {
        color: #6366f1;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .breadcrumb-nav a:hover {
        color: #ec4899;
    }

    .ip-card {
        background: #fff;
        border-radius: 20px;
        padding: 40px 35px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        animation: fadeIn 0.6s ease;
    }

    .ip-card h5 {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 25px;
        color: #1e293b;
    }

    .ip-card h5 i {
        background: linear-gradient(135deg, #6366f1, #ec4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-right: 10px;
    }

    .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }

    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    }

    .form-text {
        color: #94a3b8;
        font-size: 0.85rem;
    }

    .btn-process {
        background: linear-gradient(135deg, #6366f1, #ec4899);
        border: none;
        padding: 14px 40px;
        border-radius: 12px;
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(99,102,241,0.3);
    }

    .btn-process:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(99,102,241,0.4);
        color: #fff;
    }

    .btn-process:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .result-section {
        animation: fadeInUp 0.6s ease;
    }

    .result-image {
        width: 100%;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .alert-danger {
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        padding: 16px 20px;
    }

    .alert-success {
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        padding: 16px 20px;
    }

    .image-preview-container {
        position: relative;
        display: inline-block;
        margin-top: 10px;
    }

    .image-preview-container img {
        max-height: 200px;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
    }

    .spinner-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,255,255,0.85);
        z-index: 99999;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 20px;
    }

    .spinner-overlay.active {
        display: flex;
    }

    .spinner-overlay .spinner-border {
        width: 3rem;
        height: 3rem;
        color: #6366f1;
    }

    .spinner-overlay p {
        font-weight: 600;
        color: #334155;
        font-size: 1.1rem;
    }

    .range-value {
        display: inline-block;
        background: linear-gradient(135deg, #6366f1, #ec4899);
        color: #fff;
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        min-width: 40px;
        text-align: center;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- Loading Spinner Overlay -->
<div class="spinner-overlay" id="loadingOverlay">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Processing...</span>
    </div>
    <p>Processing your image with AI... This may take a moment.</p>
</div>

<section class="breadcrumb-nav">
    <div class="container">
        <h4>
            <a href="{{ route('home') }}">{{ __('Dashboard') }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ __('Image Processing') }}</span>
        </h4>
    </div>
</section>

<div class="row">
    <!-- Form Section -->
    <div class="col-xl-7">
        <div class="ip-card">
            <h5><i class="fas fa-magic"></i> <span>AI Image Processing</span></h5>

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('image-processing.process') }}" method="POST" enctype="multipart/form-data" id="processForm">
                @csrf

                <!-- Prompt -->
                <div class="mb-4">
                    <label for="prompt" class="form-label">Prompt <span class="text-danger">*</span></label>
                    <textarea name="prompt" id="prompt" class="form-control" rows="3"
                              placeholder="e.g. A bedroom, interior design, 4K, high resolution, photorealistic"
                    >{{ old('prompt', $oldData['prompt'] ?? '') }}</textarea>
                    <div class="form-text">Describe the image you want to generate or how you want to transform the uploaded image.</div>
                </div>

                <!-- Negative Prompt -->
                <div class="mb-4">
                    <label for="negative_prompt" class="form-label">Negative Prompt</label>
                    <textarea name="negative_prompt" id="negative_prompt" class="form-control" rows="2"
                              placeholder="e.g. low quality, blurry, watermark, unrealistic"
                    >{{ old('negative_prompt', $oldData['negative_prompt'] ?? 'low quality, blurry, watermark, unrealistic') }}</textarea>
                    <div class="form-text">Describe what you don't want in the result.</div>
                </div>

                <div class="row">
                    <!-- Guidance Scale -->
                    <div class="col-md-6 mb-4">
                        <label for="guidance_scale" class="form-label">
                            Guidance Scale <span class="range-value" id="guidanceValue">{{ old('guidance_scale', $oldData['guidance_scale'] ?? 7.5) }}</span>
                        </label>
                        <input type="range" name="guidance_scale" id="guidance_scale"
                               class="form-range" min="1" max="20" step="0.5"
                               value="{{ old('guidance_scale', $oldData['guidance_scale'] ?? 7.5) }}">
                        <div class="form-text">Higher values = closer to prompt (1–20)</div>
                    </div>

                    <!-- Inference Steps -->
                    <div class="col-md-6 mb-4">
                        <label for="num_inference_steps" class="form-label">
                            Inference Steps <span class="range-value" id="stepsValue">{{ old('num_inference_steps', $oldData['num_inference_steps'] ?? 50) }}</span>
                        </label>
                        <input type="range" name="num_inference_steps" id="num_inference_steps"
                               class="form-range" min="1" max="100" step="1"
                               value="{{ old('num_inference_steps', $oldData['num_inference_steps'] ?? 50) }}">
                        <div class="form-text">More steps = higher quality, slower (1–100)</div>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="mb-4">
                    <label for="image" class="form-label">Upload Image (Optional)</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    <div class="form-text">Upload a reference image for image-to-image processing. Max 10MB.</div>
                    <div class="image-preview-container" id="imagePreviewContainer" style="display:none;">
                        <img id="imagePreview" src="" alt="Preview">
                    </div>
                </div>

                <button type="submit" class="btn btn-process" id="submitBtn">
                    <i class="fas fa-wand-magic-sparkles"></i> Process Image
                </button>
            </form>
        </div>
    </div>

    <!-- Result Section -->
    <div class="col-xl-5">
        <div class="ip-card result-section" id="resultSection">
            <h5><i class="fas fa-image"></i> <span>Result</span></h5>
            <div id="resultContent">
                <div style="text-align:center; padding: 40px 20px;">
                    <i class="fas fa-image" style="font-size: 4rem; background: linear-gradient(135deg, #6366f1, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 20px;"></i>
                    <h5 style="color: #94a3b8; font-weight: 500;">Your result will appear here</h5>
                    <p style="color: #cbd5e1; font-size: 0.9rem;">Fill in the form and click "Process Image" to get started.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Range slider live values
    document.getElementById('guidance_scale').addEventListener('input', function() {
        document.getElementById('guidanceValue').textContent = this.value;
    });

    document.getElementById('num_inference_steps').addEventListener('input', function() {
        document.getElementById('stepsValue').textContent = this.value;
    });

    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const container = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                preview.src = ev.target.result;
                container.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            container.style.display = 'none';
        }
    });

    // AJAX form submission + polling
    document.getElementById('processForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);
        const overlay = document.getElementById('loadingOverlay');
        const overlayText = overlay.querySelector('p');
        const submitBtn = document.getElementById('submitBtn');
        const resultContent = document.getElementById('resultContent');

        // Show loading
        overlay.classList.add('active');
        submitBtn.disabled = true;
        overlayText.textContent = 'Uploading and creating prediction...';

        resultContent.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status" style="width:2.5rem;height:2.5rem;">
                    <span class="visually-hidden">Processing...</span>
                </div>
                <p class="text-muted" id="statusText">Creating prediction...</p>
                <div class="progress mt-3" style="height:6px;border-radius:3px;">
                    <div class="progress-bar" id="progressBar" role="progressbar"
                         style="width: 5%; background: linear-gradient(135deg, #6366f1, #ec4899); transition: width 0.5s ease;"
                         aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <pre class="mt-3 text-start" id="logsOutput" style="font-size:0.8rem; max-height:200px; overflow-y:auto; background:#f8fafc; border-radius:10px; padding:12px; display:none;"></pre>
            </div>
        `;

        // Step 1: Create prediction
        fetch('{{ route("image-processing.process") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                showError(data.error || 'Failed to create prediction.');
                return;
            }

            // If output is already available
            if (data.output) {
                showResult(data.output, data.status);
                return;
            }

            // Start polling
            const pollUrl = data.poll_url;
            if (!pollUrl) {
                showError('No poll URL returned. Raw response: ' + JSON.stringify(data.data, null, 2));
                return;
            }

            overlayText.textContent = 'Prediction created! Waiting for processing...';
            document.getElementById('statusText').textContent = 'Status: ' + (data.status || 'starting') + ' — Polling for result...';
            document.getElementById('progressBar').style.width = '15%';

            pollPrediction(pollUrl, 0);
        })
        .catch(err => {
            showError('Network error: ' + err.message);
        });

        function pollPrediction(pollUrl, attempt) {
            const maxAttempts = 120;
            const interval = 2000; // 2 seconds

            if (attempt >= maxAttempts) {
                showError('Prediction timed out after ' + (maxAttempts * 2) + ' seconds.');
                return;
            }

            setTimeout(() => {
                fetch('{{ route("image-processing.poll") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ poll_url: pollUrl }),
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        showError(data.error || 'Failed to poll prediction.');
                        return;
                    }

                    const status = data.status || 'unknown';
                    const progress = Math.min(15 + (attempt / maxAttempts) * 80, 90);
                    document.getElementById('progressBar').style.width = progress + '%';

                    // Show logs if available
                    if (data.logs) {
                        const logsEl = document.getElementById('logsOutput');
                        logsEl.style.display = 'block';
                        logsEl.textContent = data.logs;
                        logsEl.scrollTop = logsEl.scrollHeight;
                    }

                    if (status === 'succeeded') {
                        document.getElementById('progressBar').style.width = '100%';
                        showResult(data.output, status);
                        return;
                    }

                    if (status === 'failed' || status === 'canceled') {
                        showError('Prediction ' + status + ': ' + (data.error || 'Unknown error'));
                        return;
                    }

                    // Still processing
                    const statusLabels = {
                        'starting': 'Starting up model...',
                        'processing': 'Generating image...',
                    };
                    const statusLabel = statusLabels[status] || ('Status: ' + status);
                    document.getElementById('statusText').textContent = statusLabel;
                    overlayText.textContent = statusLabel;

                    pollPrediction(pollUrl, attempt + 1);
                })
                .catch(err => {
                    // Retry on network error
                    if (attempt < maxAttempts - 1) {
                        pollPrediction(pollUrl, attempt + 1);
                    } else {
                        showError('Network error during polling: ' + err.message);
                    }
                });
            }, interval);
        }

        function showResult(output, status) {
            overlay.classList.remove('active');
            submitBtn.disabled = false;

            let imagesHtml = '';

            if (Array.isArray(output)) {
                output.forEach(function(url) {
                    imagesHtml += renderImage(url);
                });
            } else if (typeof output === 'string') {
                imagesHtml = renderImage(output);
            } else {
                resultContent.innerHTML = `
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Unexpected output format.
                        <pre class="mt-2 mb-0" style="font-size: 0.85rem;">${JSON.stringify(output, null, 2)}</pre>
                    </div>
                `;
                return;
            }

            resultContent.innerHTML = `
                <div class="alert alert-success mb-3">
                    <i class="fas fa-check-circle"></i> Image processed successfully! Status: <strong>${status}</strong>
                </div>
                ${imagesHtml}
            `;
        }

        function renderImage(url) {
            return `
                <div class="mb-3">
                    <img src="${url}" alt="Generated Image" class="result-image" style="width:100%;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.1);">
                    <div class="mt-2">
                        <a href="${url}" target="_blank" class="btn btn-sm btn-outline-primary" download>
                            <i class="fas fa-download"></i> Download
                        </a>
                        <a href="${url}" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-external-link-alt"></i> Open Full Size
                        </a>
                    </div>
                </div>
            `;
        }

        function showError(message) {
            overlay.classList.remove('active');
            submitBtn.disabled = false;

            resultContent.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <strong>Error:</strong> ${message}
                </div>
            `;
        }
    });
</script>

@endsection

