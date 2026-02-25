@php
    $title = "Personal Info"
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

    .action-buttons {
        padding: 20px 0;
        animation: fadeIn 0.6s ease;
    }

    .btn-edit {
        background: linear-gradient(135deg, #6366f1, #ec4899);
        border: none;
        padding: 14px 32px;
        border-radius: 12px;
        color: #fff;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(99,102,241,0.3);
    }

    .btn-edit:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(99,102,241,0.4);
    }

    .profile-card {
        background: #fff;
        border-radius: 24px;
        padding: 50px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        border: 1px solid rgba(99,102,241,0.1);
        animation: fadeInUp 0.6s ease;
        margin-bottom: 40px;
    }

    .profile-card:hover {
        box-shadow: 0 20px 60px rgba(99,102,241,0.15);
    }

    .profile-image-section {
        text-align: center;
        padding: 20px;
    }

    .profile-image-section img {
        width: 250px;
        height: 250px;
        border-radius: 50%;
        border: 6px solid #6366f1;
        box-shadow: 0 15px 50px rgba(99,102,241,0.3);
        object-fit: cover;
        transition: all 0.4s ease;
    }

    .profile-image-section img:hover {
        transform: scale(1.05) rotate(3deg);
        box-shadow: 0 20px 60px rgba(99,102,241,0.4);
    }

    .profile-details {
        padding: 30px;
    }

    .profile-header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f1f5f9;
    }

    .profile-header h2 {
        font-size: 2.2rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .profile-header h5 {
        font-size: 1.2rem;
        color: #6366f1;
        font-weight: 600;
    }

    .info-row {
        display: flex;
        padding: 18px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .info-row:hover {
        background: rgba(99,102,241,0.03);
        padding-left: 10px;
        border-left: 3px solid #6366f1;
    }

    .info-label {
        font-weight: 700;
        color: #64748b;
        min-width: 180px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        color: #0f172a;
        flex: 1;
        font-weight: 500;
    }

    .info-value a {
        color: #6366f1;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
    }

    .info-value a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: #ec4899;
        transition: width 0.3s ease;
    }

    .info-value a:hover::after {
        width: 100%;
    }

    .info-value a:hover {
        color: #ec4899;
    }

    @media (max-width: 768px) {
        .profile-card {
            padding: 30px 20px;
        }
        
        .info-row {
            flex-direction: column;
            gap: 8px;
        }
        
        .info-label {
            min-width: auto;
        }
    }
</style>

<section class="breadcrumb-nav">
    <div class="container">
        <h4>
            <a href="{{ route('home') }}">{{ __('Dashboard') }}</a> 
            <i class="fas fa-chevron-right" style="font-size: 0.8rem; color: #94a3b8;"></i> 
            <span style="color: #64748b;">{{ __('Personal Info') }}</span>
        </h4>
    </div>
</section>

<div class="action-buttons">
    <div class="container">
        <a href="{{ route('info.edit') }}" class="btn btn-edit">
            <i class="fa-solid fa-edit"></i> {{ __('Edit Info') }}
        </a>
    </div>
</div>

<section class="content">
    <div class="container">
        <div class="profile-card">
            <div class="row">
                <div class="col-xl-4 profile-image-section">
                    <img src="{{ asset('storage/users/'. $user->profileImage) }}" alt="{{ $user->username }}">
                </div>
                <div class="col-xl-8 profile-details">
                    <div class="profile-header">
                        <h2>{{ $user->fullName }}</h2>
                        <h5>{{ $user->title }}</h5>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $user->phone }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Address</div>
                        <div class="info-value">{{ $user->address }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Experience Years</div>
                        <div class="info-value">{{ $user->expYear }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">LinkedIn</div>
                        <div class="info-value"><a href="{{ $user->linked_in }}" target="_blank">{{ $user->linked_in }}</a></div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Behance</div>
                        <div class="info-value"><a href="{{ $user->behance }}" target="_blank">{{ $user->behance }}</a></div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">GitHub</div>
                        <div class="info-value"><a href="{{ $user->github }}" target="_blank">{{ $user->github }}</a></div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Website</div>
                        <div class="info-value"><a href="{{ $user->my_site }}" target="_blank">{{ $user->my_site }}</a></div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Profile</div>
                        <div class="info-value">{{ $user->profile }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
