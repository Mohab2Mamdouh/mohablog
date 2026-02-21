@php
    $title = "Home"
@endphp

@extends('Admin.layouts.page')

@section('section')

<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        padding: 40px 20px;
    }

    .dashboard-card {
        position: relative;
        background: #fff;
        border-radius: 20px;
        padding: 40px 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 2px solid transparent;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .dashboard-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #6366f1, #ec4899);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .dashboard-card:hover::before {
        opacity: 1;
    }

    .dashboard-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 60px rgba(99,102,241,0.3);
        border-color: #6366f1;
    }

    .card-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, rgba(99,102,241,0.1), rgba(236,72,153,0.1));
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #6366f1;
        transition: all 0.4s ease;
        position: relative;
        z-index: 1;
    }

    .dashboard-card:hover .card-icon {
        background: rgba(255,255,255,0.2);
        color: #fff;
        transform: scale(1.1) rotate(5deg);
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: center;
        position: relative;
        z-index: 1;
        transition: color 0.3s ease;
    }

    .dashboard-card:hover .card-title {
        color: #fff;
    }

    .card-arrow {
        position: absolute;
        bottom: 20px;
        right: 20px;
        font-size: 1.5rem;
        color: #6366f1;
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.4s ease;
        z-index: 1;
    }

    .dashboard-card:hover .card-arrow {
        opacity: 1;
        transform: translateX(0);
        color: #fff;
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 20px;
        }
    }

    .dashboard-header {
        text-align: center;
        padding: 40px 20px;
        animation: fadeInDown 0.6s ease;
    }

    .dashboard-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #6366f1, #ec4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }

    .dashboard-header p {
        color: #64748b;
        font-size: 1.1rem;
    }
</style>

<section class="content content-home">
    <div class="container">
        <div class="dashboard-header">
            <h1>Dashboard</h1>
            <p>Manage your portfolio content</p>
        </div>
        
        <div class="dashboard-grid">
            <a href="{{ route('info.show') }}" class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-user"></i>
                </div>
                <h5 class="card-title">{{ __('Personal Info') }}</h5>
                <i class="fas fa-arrow-right card-arrow"></i>
            </a>

            <a href="{{ route('skills.show') }}" class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-code"></i>
                </div>
                <h5 class="card-title">{{ __('Skills') }}</h5>
                <i class="fas fa-arrow-right card-arrow"></i>
            </a>

            <a href="{{ route('projects.show') }}" class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h5 class="card-title">{{ __('Projects') }}</h5>
                <i class="fas fa-arrow-right card-arrow"></i>
            </a>

            <a href="{{ route('works.show') }}" class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h5 class="card-title">{{ __('Work Experience') }}</h5>
                <i class="fas fa-arrow-right card-arrow"></i>
            </a>

            <a href="{{ route('langs.show') }}" class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-language"></i>
                </div>
                <h5 class="card-title">{{ __('Speaking Language') }}</h5>
                <i class="fas fa-arrow-right card-arrow"></i>
            </a>
        </div>
    </div>
</section>

@endsection
