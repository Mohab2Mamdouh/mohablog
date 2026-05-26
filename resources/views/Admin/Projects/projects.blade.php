@php
    $title = "Show Projects"
@endphp

@extends('Admin.layouts.page')

@section('section')

<style>
    .project-card {
        background: #fff;
        border-radius: 20px;
        padding: 0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 2px solid transparent;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        margin-bottom: 30px;
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
        transform: scaleX(0);
        transition: transform 0.4s ease;
    }

    .project-card:hover::before {
        transform: scaleX(1);
    }

    .project-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 50px rgba(99,102,241,0.2);
        border-color: rgba(99,102,241,0.2);
    }

    .project-header {
        padding: 25px 30px;
        background: linear-gradient(135deg, rgba(99,102,241,0.05), rgba(236,72,153,0.05));
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .project-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .project-actions {
        display: flex;
        gap: 10px;
    }

    .project-body {
        padding: 30px;
    }

    .project-link {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 15px 0;
        color: #64748b;
        font-size: 0.95rem;
    }

    .project-link i {
        color: #6366f1;
        font-size: 1.2rem;
        margin-top: 3px;
    }

    .project-link a {
        color: #6366f1;
        text-decoration: none;
        transition: all 0.3s ease;
        word-break: break-all;
    }

    .project-link a:hover {
        color: #ec4899;
    }

    .project-description {
        color: #64748b;
        line-height: 1.7;
        margin: 20px 0;
    }

    .project-tech {
        background: rgba(99,102,241,0.05);
        padding: 15px 20px;
        border-radius: 12px;
        margin: 20px 0;
    }

    .project-tech strong {
        color: #0f172a;
        font-weight: 700;
    }

    .project-tech span {
        color: #64748b;
    }

    .project-footer {
        padding: 15px 30px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        color: #94a3b8;
        font-size: 0.9rem;
    }

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

    .action-bar {
        padding: 24px 0;
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
        position: relative;
        overflow: hidden;
    }

    .action-btn i {
        font-size: 1rem;
        transition: transform 0.3s ease;
    }

    .action-btn:hover i {
        transform: scale(1.15);
    }

    .action-btn::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0.1);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .action-btn:hover::after {
        opacity: 1;
    }

    .action-btn--add {
        background: linear-gradient(135deg, #10b981, #059669);
        box-shadow: 0 4px 15px rgba(16,185,129,0.3);
    }

    .action-btn--add:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(16,185,129,0.4);
        color: #fff;
    }

    .action-btn--order {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        box-shadow: 0 4px 15px rgba(99,102,241,0.3);
    }

    .action-btn--order:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(99,102,241,0.4);
        color: #fff;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

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
        <div class="row">
            @forelse ($projects as $project)
                <div class="col-lg-6">
                    <div class="project-card">
                        <div class="project-header">
                            <h5 class="project-title">{{ $project->name }}</h5>
                            <div class="project-actions">
                                <a class="btn-sm-edit" href="{{ route('projects.edit', ['id' => $project->id]) }}">
                                    <i class="fa-solid fa-edit"></i> Edit
                                </a>
                                <a class="btn-sm-delete open-button" onclick="openForm{{ $loop->index }}()" href="#">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>

                        <div class="project-body">
                            <div class="project-link">
                                <i class="fab fa-github"></i>
                                <div>
                                    <strong>GitHub:</strong><br>
                                    <a href="{{ $project->url }}" target="_blank">{{ $project->url }}</a>
                                </div>
                            </div>

                            @if($project->appURL)
                                <div class="project-link">
                                    <i class="fas fa-external-link-alt"></i>
                                    <div>
                                        <strong>Live URL:</strong><br>
                                        <a href="{{ $project->appURL }}" target="_blank">{{ $project->appURL }}</a>
                                    </div>
                                </div>
                            @endif

                            <p class="project-description">{{ $project->caption }}</p>

                            <div class="project-tech">
                                <strong>Technology Stack:</strong> <span>{{ $project->techmologyStack }}</span>
                            </div>
                        </div>

                        <div class="project-footer">
                            <i class="far fa-calendar"></i> {{ __('End Date: ') . ($project->formattedEndDate ?? __('Ongoing')) }}
                            <div class="form-check form-switch ms-auto">
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
                <a href="#" class="btn-cancel" onclick="closeForm{{ $loop->index }}()">
                    {{ __('Cancel') }}
                </a>
            </div>
        </div>
    </div>
    <script>
        function openForm{{ $loop->index }}() {
            document.querySelectorAll('.form-popup').forEach(el => el.style.display = 'none');
            document.getElementById('myForm_{{ $loop->index }}').style.display = 'block';
            document.querySelector('.overlay').style.display = 'block';
        }

        function closeForm{{ $loop->index }}() {
            document.getElementById('myForm_{{ $loop->index }}').style.display = 'none';
            document.querySelector('.overlay').style.display = 'none';
        }
    </script>
@endforeach

<script>
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
            .then(data => { this.checked = data.show_at_cv; })
            .catch(() => { this.checked = !this.checked; });
        });
    });
</script>

@endsection
