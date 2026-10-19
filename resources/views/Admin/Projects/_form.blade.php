{{-- Shared create/edit form. Expects $action, $submitLabel and an optional $project. --}}
@php
    $project ??= null;
@endphp

<style>
    .project-form-wrap {
        padding: 10px 0 50px;
    }

    .project-form {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
        gap: 24px;
        align-items: start;
    }

    .pf-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #eef2f7;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        padding: 26px 28px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .pf-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #6366f1, #ec4899);
    }

    .pf-card h6 {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 20px;
        font-size: 1rem;
    }

    .pf-card h6 i {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(99,102,241,0.12);
        color: #6366f1;
        font-size: 0.85rem;
    }

    .pf-field {
        margin-bottom: 18px;
    }

    .pf-field:last-child {
        margin-bottom: 0;
    }

    .pf-field label {
        display: block;
        font-weight: 600;
        font-size: 0.85rem;
        color: #334155;
        margin-bottom: 6px;
    }

    .pf-field label .req {
        color: #ef4444;
    }

    .pf-field input[type="text"],
    .pf-field input[type="url"],
    .pf-field input[type="date"],
    .pf-field textarea {
        width: 100%;
        padding: 11px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        font-size: 0.92rem;
        color: #0f172a;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .pf-field textarea {
        resize: vertical;
        line-height: 1.6;
    }

    .pf-field input:focus,
    .pf-field textarea:focus {
        outline: none;
        background: #fff;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    }

    .pf-field.has-error input,
    .pf-field.has-error textarea {
        border-color: #ef4444;
    }

    .pf-help {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        color: #94a3b8;
        font-size: 0.78rem;
        margin-top: 6px;
    }

    .pf-error {
        color: #dc2626;
        font-size: 0.8rem;
        margin-top: 6px;
    }

    .pf-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .pf-input-icon {
        position: relative;
    }

    .pf-input-icon i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .pf-input-icon input {
        padding-left: 40px !important;
    }

    .pf-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 10px;
        min-height: 4px;
    }

    .pf-chips span {
        padding: 4px 10px;
        border-radius: 8px;
        background: rgba(99,102,241,0.08);
        color: #4f46e5;
        font-size: 0.78rem;
        font-weight: 500;
    }

    .pf-switch {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        padding: 14px 0;
        border-top: 1px solid #f1f5f9;
    }

    .pf-switch:first-of-type {
        border-top: none;
        padding-top: 0;
    }

    .pf-switch strong {
        display: block;
        color: #0f172a;
        font-size: 0.9rem;
    }

    .pf-switch small {
        color: #94a3b8;
        font-size: 0.78rem;
    }

    .pf-switch .form-check-input {
        margin: 2px 0 0;
        width: 2.4em;
        height: 1.3em;
        cursor: pointer;
    }

    .pf-actions {
        display: flex;
        gap: 12px;
    }

    .pf-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 13px 20px;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        font-size: 0.92rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .pf-btn--primary {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        box-shadow: 0 4px 15px rgba(99,102,241,0.3);
    }

    .pf-btn--primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(99,102,241,0.4);
        color: #fff;
    }

    .pf-btn--ghost {
        background: #f1f5f9;
        color: #64748b;
    }

    .pf-btn--ghost:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .pf-sticky {
        position: sticky;
        top: 20px;
    }

    @media (max-width: 992px) {
        .project-form { grid-template-columns: 1fr; }
        .pf-sticky { position: static; }
    }

    @media (max-width: 576px) {
        .pf-row { grid-template-columns: 1fr; }
        .pf-card { padding: 22px 18px; }
    }
</style>

<section class="project-form-wrap">
    <div class="container">
        <form action="{{ $action }}" method="post" class="project-form" novalidate>
            @csrf

            <div>
                <div class="pf-card">
                    <h6><i class="fa-solid fa-diagram-project"></i> {{ __('Basics') }}</h6>

                    <div class="pf-field @error('name') has-error @enderror">
                        <label for="name">{{ __('Project name') }} <span class="req">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $project?->name) }}" required>
                        @error('name') <div class="pf-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="pf-field @error('caption') has-error @enderror">
                        <label for="caption">{{ __('Caption') }} <span class="req">*</span></label>
                        <input type="text" name="caption" id="caption" value="{{ old('caption', $project?->caption) }}" required>
                        <div class="pf-help"><span>{{ __('One line shown under the project name.') }}</span></div>
                        @error('caption') <div class="pf-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="pf-card">
                    <h6><i class="fa-solid fa-align-left"></i> {{ __('Content') }}</h6>

                    <div class="pf-field @error('summary') has-error @enderror">
                        <label for="summary">{{ __('CV summary') }}</label>
                        <textarea name="summary" id="summary" rows="3" data-counter="300">{{ old('summary', $project?->summary) }}</textarea>
                        <div class="pf-help">
                            <span>{{ __('Printed in the CV/PDF. Falls back to the caption when empty.') }}</span>
                            <span class="pf-count"></span>
                        </div>
                        @error('summary') <div class="pf-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="pf-field @error('description') has-error @enderror">
                        <label for="description">{{ __('Full description') }}</label>
                        <textarea name="description" id="description" rows="8">{{ old('description', $project?->description) }}</textarea>
                        <div class="pf-help"><span>{{ __('The full case study shown on the site.') }}</span></div>
                        @error('description') <div class="pf-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="pf-card">
                    <h6><i class="fa-solid fa-layer-group"></i> {{ __('Technology stack') }}</h6>

                    <div class="pf-field @error('tech_stack') has-error @enderror">
                        <label for="tech_stack">{{ __('Technologies') }} <span class="req">*</span></label>
                        <textarea name="tech_stack" id="tech_stack" rows="2" required>{{ old('tech_stack', $project?->tech_stack) }}</textarea>
                        <div class="pf-help"><span>{{ __('Comma separated, e.g. Laravel 12, MySQL, Redis') }}</span></div>
                        <div class="pf-chips" id="techPreview"></div>
                        @error('tech_stack') <div class="pf-error">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="pf-sticky">
                <div class="pf-card">
                    <h6><i class="fa-solid fa-link"></i> {{ __('Links') }}</h6>

                    <div class="pf-field @error('github_url') has-error @enderror">
                        <label for="github_url">{{ __('Repository URL') }}</label>
                        <div class="pf-input-icon">
                            <i class="fab fa-github"></i>
                            <input type="url" name="github_url" id="github_url" placeholder="https://github.com/…" value="{{ old('github_url', $project?->github_url) }}">
                        </div>
                        @error('github_url') <div class="pf-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="pf-field @error('app_url') has-error @enderror">
                        <label for="app_url">{{ __('Live URL') }}</label>
                        <div class="pf-input-icon">
                            <i class="fas fa-globe"></i>
                            <input type="url" name="app_url" id="app_url" placeholder="https://…" value="{{ old('app_url', $project?->app_url) }}">
                        </div>
                        @error('app_url') <div class="pf-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="pf-card">
                    <h6><i class="fa-regular fa-calendar"></i> {{ __('Timeline') }}</h6>

                    <div class="pf-row">
                        <div class="pf-field @error('start_date') has-error @enderror">
                            <label for="start_date">{{ __('Start') }}</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $project?->start_date?->format('Y-m-d')) }}">
                            @error('start_date') <div class="pf-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="pf-field @error('end_date') has-error @enderror">
                            <label for="end_date">{{ __('End') }}</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $project?->end_date?->format('Y-m-d')) }}">
                            @error('end_date') <div class="pf-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="pf-help"><span>{{ __('Leave the end date empty for an ongoing project.') }}</span></div>
                </div>

                <div class="pf-card">
                    <h6><i class="fa-solid fa-eye"></i> {{ __('Visibility') }}</h6>

                    <div class="pf-switch">
                        <label for="show_at_cv">
                            <strong>{{ __('Show in CV') }}</strong>
                            <small>{{ __('Include this project in the portfolio and PDF.') }}</small>
                        </label>
                        <input type="hidden" name="show_at_cv" value="0">
                        <input class="form-check-input" type="checkbox" role="switch" name="show_at_cv" id="show_at_cv" value="1"
                            {{ old('show_at_cv', $project?->show_at_cv ?? true) ? 'checked' : '' }}>
                    </div>

                    <div class="pf-switch">
                        <label for="is_featured">
                            <strong>{{ __('Featured') }}</strong>
                            <small>{{ __('Highlight this project in the dashboard.') }}</small>
                        </label>
                        <input type="hidden" name="is_featured" value="0">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_featured" id="is_featured" value="1"
                            {{ old('is_featured', $project?->is_featured ?? false) ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="pf-actions">
                    <a href="{{ route('projects.show') }}" class="pf-btn pf-btn--ghost">{{ __('Cancel') }}</a>
                    <button type="submit" class="pf-btn pf-btn--primary">
                        <i class="fa-solid fa-check"></i> {{ $submitLabel }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    (function () {
        const stack = document.getElementById('tech_stack');
        const preview = document.getElementById('techPreview');

        function renderChips() {
            preview.innerHTML = '';
            [...new Set(stack.value.split(',').map(t => t.trim()).filter(Boolean))].forEach(function (tech) {
                const chip = document.createElement('span');
                chip.textContent = tech;
                preview.appendChild(chip);
            });
        }

        stack.addEventListener('input', renderChips);
        renderChips();

        document.querySelectorAll('textarea[data-counter]').forEach(function (field) {
            const limit = parseInt(field.dataset.counter, 10);
            const counter = field.closest('.pf-field').querySelector('.pf-count');

            function update() {
                const length = field.value.trim().length;
                counter.textContent = length + ' / ' + limit;
                counter.style.color = length > limit ? '#dc2626' : '';
            }

            field.addEventListener('input', update);
            update();
        });
    })();
</script>
