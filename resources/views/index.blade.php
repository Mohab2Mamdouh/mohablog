@php
    $title  = 'Portfolio'
@endphp

@extends('layouts.app')

@section('content')

<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="hero-text">
            <h1 class="hero-title">{{ $user->fullName }}</h1>
            <p class="hero-subtitle">{{ $user->title }}</p>
            <div class="hero-social">
                <a href="{{ $user->linked_in }}" target="_blank" class="social-btn">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="{{ $user->github }}" target="_blank" class="social-btn">
                    <i class="fab fa-github"></i>
                </a>
                <a href="{{ $user->behance }}" target="_blank" class="social-btn">
                    <i class="fab fa-behance"></i>
                </a>
            </div>
            <a href="#about" class="scroll-down">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </div>
</section>

<section class="portfolio-content" id="about">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- About Section -->
                <div class="content-card">
                    <div class="card-header-custom">
                        <i class="fas fa-user"></i>
                        <h2>{{ __('About Me') }}</h2>
                    </div>
                    <div class="card-body-custom">
                        <p class="about-text">{{ $user->profile }}</p>

                        <div class="quick-info">
                            <div class="info-item">
                                <i class="fas fa-briefcase"></i>
                                <div>
                                    <span class="info-label">Experience</span>
                                    <span class="info-value">{{ $user->expYear }}+ Years</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <span class="info-label">Location</span>
                                    <span class="info-value">{{ $user->address }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skills Section -->
                <div class="content-card">
                    <div class="card-header-custom">
                        <i class="fas fa-code"></i>
                        <h2>{{ __('Skills') }}</h2>
                    </div>
                    <div class="card-body-custom">
                        @php
                            $types = ['Backend', 'Fontend', 'Database', 'Prior Knowledge', 'Little Knowledge', 'Other Skills']
                        @endphp

                        @foreach ($types as $type)
                            @php
                                $t = str_replace(" ", "_", $type);
                            @endphp
                            @if(isset($$t) && count($$t) > 0)
                                <div class="skill-category">
                                    <h5>{{ str_replace("_", " ", $t) }}</h5>
                                    <div class="skill-tags">
                                        @foreach ($$t as $skill)
                                            <span class="skill-tag">
                                                {{ $skill->languageName }}
                                                @if ($skill->main != 'null')
                                                    <small>{{ $skill->main }}</small>
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Projects Section -->
                <div class="content-card">
                    <div class="card-header-custom">
                        <i class="fas fa-folder-open"></i>
                        <h2>{{ __('Latest Projects') }}</h2>
                    </div>
                    <div class="card-body-custom">
                        @foreach ($projects as $p)
                            <div class="project-item">
                                <div class="project-header">
                                    <h5>{{ $p->name }}</h5>
                                    <a href="{{ $p->appURL ? $p->appURL : $p->url }}" target="_blank" class="project-link">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                                <p class="project-desc">{{ $p->caption }}</p>
                                <div class="project-tech">
                                    <i class="fas fa-layer-group"></i>
                                    {{ $p->techmologyStack }}
                                </div>
                                <div class="project-date">
                                    <i class="far fa-calendar"></i>
                                    {{ date("F Y", strtotime($p->endDate)) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Work Experience Section -->
                <div class="content-card">
                    <div class="card-header-custom">
                        <i class="fas fa-briefcase"></i>
                        <h2>{{ __('Work Experience') }}</h2>
                    </div>
                    <div class="card-body-custom">
                        @foreach ($works as $w)
                            <div class="work-item">
                                <div class="work-header">
                                    <h5>{{ $w->title }}</h5>
                                    <span class="work-company">{{ $w->companyName }}</span>
                                </div>
                                <div class="work-period">
                                    <i class="far fa-calendar"></i>
                                    {{ date("F Y", strtotime($w->startDate)) }} - {{ $w->endDate == null ? $w->current : date("F Y", strtotime($w->endDate)) }}
                                </div>
                                <p class="work-desc">{{ $w->caption }}</p>
                                <div class="work-env">
                                    <i class="fas fa-tools"></i>
                                    {{ $w->environment }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Contact Card -->
                <div class="sidebar-card sticky-sidebar">
                    <div class="card-header-custom">
                        <i class="fas fa-address-card"></i>
                        <h2>{{ __('Contact') }}</h2>
                    </div>
                    <div class="card-body-custom">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $user->address }}</span>
                        </div>
                        <a href="{{ route('downloadPDF') }}" class="download-cv-btn">
                            <i class="fas fa-download"></i>
                            {{ __('Download CV') }}
                        </a>
                    </div>
                </div>

                <!-- Languages Card -->
                <div class="sidebar-card">
                    <div class="card-header-custom">
                        <i class="fas fa-language"></i>
                        <h2>{{ __('Languages') }}</h2>
                    </div>
                    <div class="card-body-custom">
                        @foreach ($sLanguages as $sl)
                            <div class="language-item">
                                <div class="language-name">{{ $sl->languageName }}</div>
                                <div class="language-level">
                                    @php
                                        $level = match($sl->level) {
                                            'Level 1' => 1,
                                            'Level 2' => 2,
                                            'Level 3' => 3,
                                            'Level 4' => 4,
                                            'Level 5' => 5,
                                            default => 0
                                        };
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-circle {{ $i <= $level ? 'active' : '' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.hero-section {
    min-height: 100vh;
    background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%);
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('https://cdn.pixabay.com/photo/2014/12/30/13/44/programming-583923_960_720.jpg');
    opacity: 0.08;
    background-size: cover;
    animation: slowZoom 20s ease-in-out infinite alternate;
}

.hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
}

.hero-title {
    font-size: 4rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -2px;
    animation: fadeInUp 0.8s ease;
    text-shadow: 0 4px 30px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: 1.8rem;
    color: rgba(255,255,255,0.95);
    margin-bottom: 40px;
    animation: fadeInUp 0.8s ease 0.2s both;
}

.hero-social {
    display: flex;
    gap: 20px;
    justify-content: center;
    animation: fadeInUp 0.8s ease 0.4s both;
}

.social-btn {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.5rem;
    transition: all 0.3s ease;
}

.social-btn:hover {
    background: #fff;
    color: #6366f1;
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.scroll-down {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    color: #fff;
    font-size: 2rem;
    animation: bounce 2s ease infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50% { transform: translateX(-50%) translateY(-10px); }
}

.portfolio-content {
    padding: 80px 0;
    background: #f8fafc;
}

.content-card {
    background: #fff;
    border-radius: 24px;
    padding: 0;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(99,102,241,0.08);
    overflow: hidden;
    animation: fadeInUp 0.6s ease both;
}

.card-header-custom {
    background: linear-gradient(135deg, rgba(99,102,241,0.05), rgba(236,72,153,0.05));
    padding: 30px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.card-header-custom i {
    font-size: 1.8rem;
    color: #6366f1;
}

.card-header-custom h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}

.card-body-custom {
    padding: 40px;
}

.about-text {
    color: #64748b;
    line-height: 1.8;
    font-size: 1.05rem;
    margin-bottom: 30px;
}

.quick-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: rgba(99,102,241,0.05);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.info-item:hover {
    background: rgba(99,102,241,0.1);
    transform: translateX(5px);
}

.info-item i {
    font-size: 1.5rem;
    color: #6366f1;
}

.info-label {
    display: block;
    font-size: 0.85rem;
    color: #94a3b8;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    display: block;
    font-size: 1.1rem;
    color: #0f172a;
    font-weight: 700;
}

.skill-category {
    margin-bottom: 35px;
}

.skill-category h5 {
    color: #0f172a;
    font-weight: 700;
    margin-bottom: 15px;
    font-size: 1.1rem;
}

.skill-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.skill-tag {
    background: linear-gradient(135deg, rgba(99,102,241,0.1), rgba(236,72,153,0.1));
    padding: 10px 18px;
    border-radius: 20px;
    color: #0f172a;
    font-weight: 600;
    font-size: 0.9rem;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.skill-tag:hover {
    border-color: #6366f1;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(99,102,241,0.2);
}

.skill-tag small {
    font-size: 0.75rem;
    color: #64748b;
    margin-top: 3px;
}

.project-item {
    padding: 30px;
    background: rgba(99,102,241,0.02);
    border-radius: 16px;
    margin-bottom: 25px;
    border-left: 4px solid #6366f1;
    transition: all 0.3s ease;
}

.project-item:hover {
    background: #fff;
    transform: translateX(10px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.project-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.project-header h5 {
    color: #0f172a;
    font-weight: 700;
    font-size: 1.3rem;
    margin: 0;
}

.project-link {
    width: 40px;
    height: 40px;
    background: #6366f1;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    transition: all 0.3s ease;
}

.project-link:hover {
    background: #ec4899;
    transform: scale(1.1);
    color: #fff;
}

.project-desc {
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 15px;
}

.project-tech,
.project-date {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #94a3b8;
    font-size: 0.9rem;
    margin-top: 10px;
}

.project-tech i,
.project-date i {
    color: #6366f1;
}

.work-item {
    padding: 30px;
    background: rgba(99,102,241,0.02);
    border-radius: 16px;
    margin-bottom: 25px;
    border-left: 4px solid #ec4899;
    transition: all 0.3s ease;
}

.work-item:hover {
    background: #fff;
    transform: translateX(10px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.work-header h5 {
    color: #0f172a;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 8px;
}

.work-company {
    color: #6366f1;
    font-weight: 600;
    font-size: 1.05rem;
}

.work-period,
.work-env {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #94a3b8;
    font-size: 0.9rem;
    margin: 10px 0;
}

.work-period i,
.work-env i {
    color: #ec4899;
}

.work-desc {
    color: #64748b;
    line-height: 1.7;
    margin: 15px 0;
}

.sidebar-card {
    background: #fff;
    border-radius: 24px;
    padding: 0;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(99,102,241,0.08);
    overflow: hidden;
    animation: fadeInUp 0.6s ease both;
}

.sticky-sidebar {
    position: sticky;
    top: 20px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #f1f5f9;
}

.contact-item:last-of-type {
    border-bottom: none;
    margin-bottom: 20px;
}

.contact-item i {
    font-size: 1.2rem;
    color: #6366f1;
    width: 30px;
}

.contact-item a,
.contact-item span {
    color: #64748b;
    text-decoration: none;
    transition: color 0.3s ease;
    word-break: break-word;
}

.contact-item a:hover {
    color: #6366f1;
}

.download-cv-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #6366f1, #ec4899);
    color: #fff;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(99,102,241,0.3);
}

.download-cv-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(99,102,241,0.4);
    color: #fff;
}

.language-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #f1f5f9;
}

.language-item:last-child {
    border-bottom: none;
}

.language-name {
    color: #0f172a;
    font-weight: 600;
}

.language-level {
    display: flex;
    gap: 5px;
}

.language-level i {
    font-size: 0.7rem;
    color: #e2e8f0;
    transition: all 0.3s ease;
}

@media (max-width: 992px) {
    .hero-title {
        font-size: 2.5rem;
    }

    .hero-subtitle {
        font-size: 1.3rem;
    }

    .sticky-sidebar {
        position: static;
    }
}

@keyframes slowZoom {
    from { transform: scale(1); }
    to { transform: scale(1.1); }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

@endsection
