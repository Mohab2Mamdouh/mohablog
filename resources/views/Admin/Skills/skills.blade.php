@php
    $title = "Show Skills"
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

    .action-bar {
        padding: 20px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        animation: fadeIn 0.6s ease;
    }

    .btn-add {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        padding: 14px 32px;
        border-radius: 12px;
        color: #fff;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16,185,129,0.3);
        text-decoration: none;
        display: inline-block;
    }

    .btn-add:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(16,185,129,0.4);
        color: #fff;
    }

    .skills-section {
        margin-bottom: 50px;
        animation: fadeInUp 0.6s ease both;
    }

    .skills-section:nth-child(1) { animation-delay: 0s; }
    .skills-section:nth-child(2) { animation-delay: 0.1s; }
    .skills-section:nth-child(3) { animation-delay: 0.2s; }

    .section-header {
        background: linear-gradient(135deg, rgba(99,102,241,0.1), rgba(236,72,153,0.1));
        padding: 20px 30px;
        border-radius: 16px;
        margin-bottom: 25px;
    }

    .section-header h3 {
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        font-size: 1.5rem;
    }

    .skill-card {
        background: #fff;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 2px solid transparent;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .skill-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 0;
        background: linear-gradient(180deg, #6366f1, #ec4899);
        transition: height 0.4s ease;
    }

    .skill-card:hover::before {
        height: 100%;
    }

    .skill-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 50px rgba(99,102,241,0.2);
        border-color: rgba(99,102,241,0.2);
    }

    .skill-card h5 {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 15px;
        font-size: 1.3rem;
    }

    .skill-card p {
        color: #64748b;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .skill-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-edit {
        background: #6366f1;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        color: #fff;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-edit:hover {
        background: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99,102,241,0.3);
        color: #fff;
    }

    .btn-delete {
        background: #ef4444;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        color: #fff;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-delete:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239,68,68,0.3);
    }

    @media (max-width: 768px) {
        .skill-actions {
            flex-direction: column;
        }

        .btn-edit, .btn-delete {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<section class="breadcrumb-nav">
    <div class="container">
        <h4>
            <a href="{{ route('home') }}">{{ __('Dashboard') }}</a>
            <i class="fas fa-chevron-right" style="font-size: 0.8rem; color: #94a3b8;"></i>
            <span style="color: #64748b;">{{ __('Skills') }}</span>
        </h4>
    </div>
</section>

<div class="action-bar">
    <div class="container">
        <a href="{{ route('skills.create') }}" class="btn-add">
            <i class="fa-solid fa-plus"></i> {{ __('Add Skill') }}
        </a>
    </div>
</div>

<section class="content">
    <div class="container">
        @php
            $types = ['Backend', 'Fontend', 'Database', 'Prior Knowledge', 'Little Knowledge', 'Other Skills']
        @endphp

        @foreach ($types as $type)
            @php
                $typeSkills = $skills->where('type', $type);
            @endphp

            @if($typeSkills->count() > 0)
                <div class="skills-section">
                    <div class="section-header">
                        <h3>{{ $type }}</h3>
                    </div>

                    <div class="row">
                        @foreach ($typeSkills as $skill)
                            <div class="col-md-6 mb-4">
                                <div class="skill-card">
                                    <h5>{{ $skill->languageName }}</h5>
                                    <p>
                                        {{ $skill->type }}
                                        @if ($skill->main != 'null')
                                            - {{ $skill->main }}
                                        @endif
                                    </p>
                                    <div class="skill-actions">
                                        <a href="{{ route('skills.edit', ['id' => $skill->id]) }}" class="btn-edit">
                                            <i class="fa-solid fa-edit"></i> {{ __('Edit') }}
                                        </a>
                                        <a class="btn-delete open-button" onclick="openForm{{ $loop->parent->index * 100 + $loop->index }}()" href="#">
                                            <i class="fa-solid fa-trash"></i> {{ __('Delete') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach



            </div>
        </section>

<div class="overlay"></div>

@for ($i = 0; $i < count($skills); $i++)
    <div class="form-popup" id="myForm_{{ $i }}">
        <div class="card border-danger mb-3" style="max-width: 60rem;">
            <div class="card-header">{{ $skills[$i]->languageName }}</div>
            <div class="card-body text-danger">
                <h5 class="card-title">{{ __('Delete the project "') . $skills[$i]->languageName . '"?' }}</h5>
                <p class="card-text">
                    <a href="{{ route('skills.delete', ['id' => $skills[$i]->id]) }}" class="card-link">{{ __('Delete') }}</a>
                    <a href="#" class="card-link cancel" onclick="closeForm{{ $i }}()">{{ __('Cancel') }}</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        let overlay = $('.overlay');
        overlay.css('height', $('body').css('height'));
        function openForm{{ $i }}() {
            for (let index = 0; index < {{count($skills)}}; index++) {
                if (index === {{$i}}) {
                    continue;
                }
                console.log(index);
                $('#myForm_' + index).css('display', 'none');
            }
            $('#myForm_' + {{ $i }}).css('display', 'block');
            overlay.css('display', 'block');

        }

        function closeForm{{ $i }}() {
            $('#myForm_' + {{ $i }}).css('display', 'none');
            overlay.css('display', 'none');
        }
    </script>
@endfor


@endsection
