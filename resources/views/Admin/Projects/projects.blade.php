@php
    $title = "Show Projects"
@endphp

@extends('Admin.layouts.page')

@section('section')

<style>
    /* ---------- toolbar ---------- */
    .action-bar {
        padding: 24px 0 8px;
        animation: fadeIn 0.6s ease;
    }

    .action-bar .container {
        display: flex;
        gap: 14px;
        align-items: center;
        flex-wrap: wrap;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 28px;
        border-radius: 14px;
        color: #fff;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .action-btn:hover {
        transform: translateY(-3px);
        color: #fff;
    }

    .action-btn--add {
        background: linear-gradient(135deg, #10b981, #059669);
        box-shadow: 0 4px 15px rgba(16,185,129,0.3);
    }

    .action-btn--add:hover {
        box-shadow: 0 10px 30px rgba(16,185,129,0.4);
    }

    .action-btn--order {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        box-shadow: 0 4px 15px rgba(99,102,241,0.3);
    }

    .action-btn--order:hover {
        box-shadow: 0 10px 30px rgba(99,102,241,0.4);
    }

    /* ---------- stats + filters ---------- */
    .projects-overview {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 16px 0 24px;
    }

    .project-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .stat-pill {
        display: inline-flex;
        align-items: baseline;
        gap: 8px;
        padding: 8px 16px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        color: #64748b;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .stat-pill strong {
        color: #0f172a;
        font-size: 1rem;
    }

    .stat-pill:hover,
    .stat-pill.is-active {
        border-color: #6366f1;
        color: #6366f1;
        box-shadow: 0 4px 14px rgba(99,102,241,0.15);
    }

    .stat-pill.is-active strong {
        color: #6366f1;
    }

    .project-search {
        position: relative;
        flex: 0 1 300px;
    }

    .project-search i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .project-search input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        font-size: 0.9rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .project-search input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    }

    /* ---------- card ---------- */
    .project-col {
        margin-bottom: 28px;
    }

    .project-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #eef2f7;
        transition: transform 0.3s ease, box-shadow 0.3s ease, opacity 0.3s ease;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .project-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #6366f1, #ec4899);
    }

    .project-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 45px rgba(99,102,241,0.18);
    }

    .project-card.is-hidden-cv {
        opacity: 0.72;
    }

    .project-card.is-hidden-cv::before {
        background: #cbd5e1;
    }

    .project-card.is-hidden-cv:hover {
        opacity: 1;
    }

    .project-header {
        padding: 24px 26px 16px;
        display: flex;
        gap: 16px;
        align-items: flex-start;
    }

    .project-order {
        flex-shrink: 0;
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(99,102,241,0.12), rgba(236,72,153,0.12));
        color: #6366f1;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
    }

    .project-heading {
        flex: 1;
        min-width: 0;
    }

    .project-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px;
        line-height: 1.3;
    }

    .project-caption {
        color: #64748b;
        font-size: 0.9rem;
        margin: 0;
        line-height: 1.5;
    }

    .project-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 10px;
    }

    .badge-soft {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-soft--ongoing   { background: rgba(16,185,129,0.12); color: #059669; }
    .badge-soft--completed { background: #f1f5f9; color: #64748b; }
    .badge-soft--cv        { background: rgba(99,102,241,0.12); color: #4f46e5; }
    .badge-soft--hidden    { background: rgba(239,68,68,0.10); color: #dc2626; }
    .badge-soft--featured  { background: rgba(245,158,11,0.14); color: #b45309; }

    .project-actions {
        display: flex;
        gap: 6px;
        flex-shrink: 0;
    }

    .icon-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .icon-btn--edit:hover {
        background: #6366f1;
        border-color: #6366f1;
        color: #fff;
    }

    .icon-btn--delete:hover {
        background: #ef4444;
        border-color: #ef4444;
        color: #fff;
    }

    .project-body {
        padding: 0 26px 20px;
        flex: 1;
    }

    .project-summary {
        color: #475569;
        line-height: 1.65;
        font-size: 0.92rem;
        margin: 0 0 6px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .project-summary.is-expanded {
        -webkit-line-clamp: unset;
    }

    .summary-toggle {
        background: none;
        border: none;
        padding: 0;
        color: #6366f1;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
    }

    .summary-hint {
        display: block;
        color: #94a3b8;
        font-size: 0.75rem;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 600;
    }

    .project-tech {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 16px;
    }

    .tech-chip {
        padding: 4px 10px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 0.78rem;
        font-weight: 500;
    }

    .project-links {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 18px;
    }

    .link-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        max-width: 100%;
        padding: 6px 12px;
        border-radius: 10px;
        background: rgba(99,102,241,0.06);
        color: #4f46e5;
        font-size: 0.82rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .link-chip span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .link-chip:hover {
        background: #6366f1;
        color: #fff;
    }

    .project-footer {
        padding: 14px 26px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        color: #94a3b8;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .project-footer .form-check {
        margin: 0;
    }

    .project-footer .form-check-label {
        color: #64748b;
        font-weight: 500;
    }

    .no-results {
        display: none;
    }

    /* ---------- delete modal ---------- */
    .delete-modal {
        background: #fff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 25px 80px rgba(0,0,0,0.3);
        max-width: 500px;
        animation: zoomIn 0.3s ease;
    }

    .delete-modal h5 {
        color: #0f172a;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .delete-modal-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .delete-modal-actions a {
        flex: 1;
        padding: 14px;
        border-radius: 12px;
        text-align: center;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-confirm-delete {
        background: #ef4444;
        color: #fff;
    }

    .btn-confirm-delete:hover {
        background: #dc2626;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(239,68,68,0.4);
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    @media (max-width: 576px) {
        .project-header { flex-wrap: wrap; }
        .project-actions { order: -1; width: 100%; justify-content: flex-end; }
        .project-search { flex-basis: 100%; }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

@php
    $inCvCount   = $projects->where('show_at_cv', true)->count();
    $ongoingCount = $projects->whereNull('end_date')->count();
    $featuredCount = $projects->where('is_featured', true)->count();
@endphp

<section class="breadcrumb-nav">
    <div class="container">
        <h4>
            <a href="{{ route('home') }}">{{ __('Dashboard') }}</a>
            <i class="fas fa-chevron-right" style="font-size: 0.8rem; color: #94a3b8;"></i>
            <span style="color: #64748b;">{{ __('Projects') }}</span>
        </h4>
    </div>
</section>

<div class="action-bar">
    <div class="container">
        <a href="{{ route('projects.create') }}" class="action-btn action-btn--add">
            <i class="fa-solid fa-plus"></i> {{ __('Add Project') }}
        </a>
        <a href="{{ route('projects.order') }}" class="action-btn action-btn--order">
            <i class="fa-solid fa-sort"></i> {{ __('Projects Order') }}
        </a>
    </div>
</div>

<section class="content">
    <div class="container">
        @if ($projects->isNotEmpty())
            <div class="projects-overview">
                <div class="project-stats">
                    <button type="button" class="stat-pill is-active" data-filter="all">
                        <strong>{{ $projects->count() }}</strong> {{ __('Total') }}
                    </button>
                    <button type="button" class="stat-pill" data-filter="cv">
                        <strong data-count="cv">{{ $inCvCount }}</strong> {{ __('In CV') }}
                    </button>
                    <button type="button" class="stat-pill" data-filter="hidden">
                        <strong data-count="hidden">{{ $projects->count() - $inCvCount }}</strong> {{ __('Hidden') }}
                    </button>
                    <button type="button" class="stat-pill" data-filter="ongoing">
                        <strong>{{ $ongoingCount }}</strong> {{ __('Ongoing') }}
                    </button>
                    <button type="button" class="stat-pill" data-filter="featured">
                        <strong>{{ $featuredCount }}</strong> {{ __('Featured') }}
                    </button>
                </div>
                <div class="project-search">
                    <i class="fas fa-search"></i>
                    <input type="search" id="projectSearch" placeholder="{{ __('Search name or technology…') }}">
                </div>
            </div>
        @endif

        <div class="row">
            @forelse ($projects as $project)
                <div class="col-lg-6 project-col"
                     data-cv="{{ $project->show_at_cv ? 1 : 0 }}"
                     data-ongoing="{{ $project->end_date ? 0 : 1 }}"
                     data-featured="{{ $project->is_featured ? 1 : 0 }}"
                     data-search="{{ Str::lower($project->name . ' ' . $project->caption . ' ' . $project->tech_stack) }}">
                    <div class="project-card {{ $project->show_at_cv ? '' : 'is-hidden-cv' }}">
                        <div class="project-header">
                            <div class="project-order" title="{{ __('Display order') }}">
                                {{ $project->order ?? '–' }}
                            </div>
                            <div class="project-heading">
                                <h5 class="project-title">{{ $project->name }}</h5>
                                @if ($project->caption)
                                    <p class="project-caption">{{ $project->caption }}</p>
                                @endif
                                <div class="project-badges">
                                    @if ($project->is_featured)
                                        <span class="badge-soft badge-soft--featured">
                                            <i class="fas fa-star"></i> {{ __('Featured') }}
                                        </span>
                                    @endif
                                    @if ($project->end_date)
                                        <span class="badge-soft badge-soft--completed">
                                            <i class="far fa-calendar-check"></i>
                                            {{ $project->start_date ? $project->start_date->format('M Y') . ' – ' : '' }}{{ $project->formattedEndDate }}
                                        </span>
                                    @else
                                        <span class="badge-soft badge-soft--ongoing">
                                            <i class="fas fa-circle" style="font-size: 0.45rem;"></i>
                                            {{ $project->start_date ? __('Since') . ' ' . $project->start_date->format('M Y') : __('Ongoing') }}
                                        </span>
                                    @endif
                                    <span class="badge-soft cv-badge {{ $project->show_at_cv ? 'badge-soft--cv' : 'badge-soft--hidden' }}">
                                        <i class="fas {{ $project->show_at_cv ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                        <span>{{ $project->show_at_cv ? __('In CV') : __('Hidden from CV') }}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="project-actions">
                                <a class="icon-btn icon-btn--edit" href="{{ route('projects.edit', ['id' => $project->id]) }}" title="{{ __('Edit') }}">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a class="icon-btn icon-btn--delete open-button" onclick="openDeleteForm({{ $loop->index }}); return false;" href="#" title="{{ __('Delete') }}">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </div>

                        <div class="project-body">
                            @if ($project->cvSummary)
                                <span class="summary-hint">{{ $project->summary ? __('CV summary') : __('Summary (fallback)') }}</span>
                                <p class="project-summary">{{ $project->cvSummary }}</p>
                                <button type="button" class="summary-toggle" hidden>{{ __('Show more') }}</button>
                            @endif

                            @if ($project->techList->isNotEmpty())
                                <div class="project-tech">
                                    @foreach ($project->techList as $tech)
                                        <span class="tech-chip">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif

                            @if ($project->github_url || $project->app_url)
                                <div class="project-links">
                                    @if ($project->github_url)
                                        <a class="link-chip" href="{{ $project->github_url }}" target="_blank" rel="noopener" title="{{ $project->github_url }}">
                                            <i class="fab fa-github"></i>
                                            <span>{{ Str::after($project->github_url, '://') }}</span>
                                        </a>
                                    @endif
                                    @if ($project->app_url)
                                        <a class="link-chip" href="{{ $project->app_url }}" target="_blank" rel="noopener" title="{{ $project->app_url }}">
                                            <i class="fas fa-arrow-up-right-from-square"></i>
                                            <span>{{ parse_url($project->app_url, PHP_URL_HOST) ?: $project->app_url }}</span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="project-footer">
                            <span>
                                <i class="far fa-clock"></i>
                                {{ __('Updated') }} {{ $project->updated_at?->diffForHumans() ?? '—' }}
                            </span>
                            <div class="form-check form-switch">
                                <input class="form-check-input toggle-cv" type="checkbox" role="switch"
                                    id="cv-{{ $project->id }}"
                                    data-id="{{ $project->id }}"
                                    data-url="{{ route('projects.toggleCV', $project->id) }}"
                                    {{ $project->show_at_cv ? 'checked' : '' }}>
                                <label class="form-check-label" for="cv-{{ $project->id }}">{{ __('Show in CV') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <h4>{{ __('No Projects Yet') }}</h4>
                        <p>{{ __('Start by adding your first project') }}</p>
                    </div>
                </div>
            @endforelse

            <div class="col-12 no-results">
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h4>{{ __('No matching projects') }}</h4>
                    <p>{{ __('Try a different search or filter') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="overlay"></div>

@foreach ($projects as $project)
    <div class="form-popup" id="myForm_{{ $loop->index }}">
        <div class="delete-modal">
            <h5>{{ __('Delete Project?') }}</h5>
            <p style="color: #64748b;">{{ __('Are you sure you want to delete "') . $project->name . '"? This action cannot be undone.' }}</p>
            <div class="delete-modal-actions">
                <a href="{{ route('projects.delete', ['id' => $project->id]) }}" class="btn-confirm-delete">
                    <i class="fas fa-trash"></i> {{ __('Delete') }}
                </a>
                <a href="#" class="btn-cancel" onclick="closeDeleteForm({{ $loop->index }}); return false;">
                    {{ __('Cancel') }}
                </a>
            </div>
        </div>
    </div>
@endforeach

<script>
    function openDeleteForm(index) {
        document.querySelectorAll('.form-popup').forEach(el => el.style.display = 'none');
        document.getElementById('myForm_' + index).style.display = 'block';
        document.querySelector('.overlay').style.display = 'block';
    }

    function closeDeleteForm(index) {
        document.getElementById('myForm_' + index).style.display = 'none';
        document.querySelector('.overlay').style.display = 'none';
    }

    // Only offer "Show more" on summaries that are actually clamped.
    document.querySelectorAll('.project-summary').forEach(function (summary) {
        const toggle = summary.nextElementSibling;
        if (summary.scrollHeight <= summary.clientHeight + 1) return;
        toggle.hidden = false;
        toggle.addEventListener('click', function () {
            const expanded = summary.classList.toggle('is-expanded');
            toggle.textContent = expanded ? @json(__('Show less')) : @json(__('Show more'));
        });
    });

    // Search + stat-pill filters.
    (function () {
        const cols = Array.from(document.querySelectorAll('.project-col'));
        const search = document.getElementById('projectSearch');
        const pills = document.querySelectorAll('.stat-pill');
        const noResults = document.querySelector('.no-results');
        let filter = 'all';

        function apply() {
            const term = (search?.value || '').trim().toLowerCase();
            let visible = 0;
            cols.forEach(function (col) {
                const matchesFilter = filter === 'all'
                    || (filter === 'cv' && col.dataset.cv === '1')
                    || (filter === 'hidden' && col.dataset.cv === '0')
                    || (filter === 'ongoing' && col.dataset.ongoing === '1')
                    || (filter === 'featured' && col.dataset.featured === '1');
                const show = matchesFilter && (!term || col.dataset.search.includes(term));
                col.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            if (noResults) noResults.style.display = cols.length && !visible ? 'block' : 'none';
        }

        pills.forEach(function (pill) {
            pill.addEventListener('click', function () {
                pills.forEach(p => p.classList.remove('is-active'));
                pill.classList.add('is-active');
                filter = pill.dataset.filter;
                apply();
            });
        });

        search?.addEventListener('input', apply);
        window.applyProjectFilters = apply;
    })();

    // Keep the card, badge and counters in sync with the "Show in CV" switch.
    function syncCvState(checkbox, inCv) {
        const col = checkbox.closest('.project-col');
        const card = col.querySelector('.project-card');
        const badge = col.querySelector('.cv-badge');

        col.dataset.cv = inCv ? '1' : '0';
        card.classList.toggle('is-hidden-cv', !inCv);
        badge.classList.toggle('badge-soft--cv', inCv);
        badge.classList.toggle('badge-soft--hidden', !inCv);
        badge.querySelector('i').className = 'fas ' + (inCv ? 'fa-eye' : 'fa-eye-slash');
        badge.querySelector('span').textContent = inCv ? @json(__('In CV')) : @json(__('Hidden from CV'));

        const total = document.querySelectorAll('.project-col').length;
        const cvCount = document.querySelectorAll('.project-col[data-cv="1"]').length;
        document.querySelector('[data-count="cv"]').textContent = cvCount;
        document.querySelector('[data-count="hidden"]').textContent = total - cvCount;
        window.applyProjectFilters();
    }

    document.querySelectorAll('.toggle-cv').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const url = this.dataset.url;
            fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                this.checked = data.show_at_cv;
                syncCvState(this, data.show_at_cv);
            })
            .catch(() => { this.checked = !this.checked; });
        });
    });
</script>

@endsection
