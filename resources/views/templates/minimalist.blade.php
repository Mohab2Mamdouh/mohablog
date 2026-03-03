<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->fullName }} - {{ $user->currentPosition }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: #ffffff;
            --text: #1a1a1a;
            --accent: #FF2D20;
            --secondary: #6b7280;
            --border: #e5e7eb;
            --tag-bg: #f3f4f6;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.8;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 80px 20px;
        }
        h1 {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: -2px;
        }
        .subtitle {
            font-size: 1.5rem;
            color: var(--secondary);
            font-weight: 300;
            margin-bottom: 60px;
        }
        .section {
            margin: 80px 0;
            padding-bottom: 40px;
            border-bottom: 1px solid var(--border);
        }
        .section:last-child { border-bottom: none; }
        h2 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
        }
        h2:after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--accent);
        }
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }
        .skill-group {
            padding: 0;
        }
        .skill-group h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 2px;
            text-transform: uppercase;
            border-left: 3px solid var(--accent);
            padding: 8px 14px;
            background: var(--tag-bg);
            display: inline-block;
            border-radius: 0 4px 4px 0;
            margin-bottom: 15px;
        }
        .skill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .skill-item {
            font-size: 0.95rem;
            color: var(--text);
            padding: 8px 14px;
            position: relative;
            background: var(--tag-bg);
            border-radius: 6px;
        }
        .skill-item:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s;
            border-radius: 0 0 6px 6px;
        }
        .skill-item:hover:after { width: 100%; }
        .project {
            margin: 40px 0;
            padding: 30px 0;
            border-bottom: 1px solid var(--border);
        }
        .project:last-child { border-bottom: none; }
        .project h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .project-meta {
            color: var(--secondary);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        .project p {
            color: var(--secondary);
            line-height: 1.8;
        }
        .project a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
            margin-top: 10px;
        }
        .project a:hover { text-decoration: underline; }
        .work-item {
            margin: 30px 0;
        }
        .work-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .work-company {
            color: var(--accent);
            font-weight: 500;
            margin-bottom: 5px;
        }
        .work-period {
            color: var(--secondary);
            font-size: 0.9rem;
        }
        .nav-links {
            margin: 40px 0;
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
            text-align: center;
        }
        .nav-links a {
            margin: 0 15px;
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-links a:hover { color: var(--accent); }
        .dark-mode-toggle {
            position: fixed;
            top: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--accent);
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
            transition: transform 0.3s;
        }
        .dark-mode-toggle:hover { transform: scale(1.1); }
        .cv-download {
            position: fixed;
            top: 30px;
            right: 90px;
            height: 50px;
            padding: 0 20px;
            border-radius: 25px;
            background: var(--accent);
            border: none;
            color: white;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.3s, box-shadow 0.3s;
            z-index: 100;
        }
        .cv-download:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(255,45,32,0.4);
            color: white;
        }
        .tag {
            font-size: 0.8rem;
            padding: 4px 10px;
            background: var(--tag-bg);
            border-radius: 4px;
            color: var(--secondary);
        }
        body.dark {
            --bg: #0a0a0a;
            --text: #e5e7eb;
            --secondary: #9ca3af;
            --border: #1f2937;
            --tag-bg: #1f2937;
        }
        body.dark .nav-links { background: #1a1a1a; }
    </style>
</head>
<body class="dark">
    <a href="{{ route('downloadPDF') }}" class="cv-download">↓ Download CV</a>
    <button class="dark-mode-toggle" onclick="toggleDark()">◐</button>

    <div class="container">
        <h1>{{ $user->fullName }}</h1>
        <div class="subtitle">{{ $user->title }}</div>

{{--        <div class="nav-links">--}}
{{--            <a href="{{ route('template.terminal') }}">Terminal</a>--}}
{{--            <a href="{{ route('template.code-first') }}">Code-First</a>--}}
{{--            <a href="{{ route('template.architecture') }}">Architecture</a>--}}
{{--            <a href="{{ route('template.minimalist') }}">Minimalist</a>--}}
{{--            <a href="{{ route('portfolio') }}">← Back to Original</a>--}}
{{--        </div>--}}

        <div class="section">
            <h2>About</h2>
            <p style="font-size: 1.1rem; color: var(--secondary); margin-top: 20px;">
                {{ $user->profile }}
            </p>
            <div style="margin-top: 20px; color: var(--secondary); font-size: 0.95rem;">
                <p>📍 {{ $user->address }} &nbsp;|&nbsp; 📧 {{ $user->email }} &nbsp;|&nbsp; 📱 {{ $user->phone }}</p>
                <div style="margin-top: 10px; display: flex; gap: 15px; flex-wrap: wrap;">
                    @if($user->github)<a href="{{ $user->github }}" target="_blank" style="color: var(--accent); text-decoration: none;">GitHub ↗</a>@endif
                    @if($user->linked_in)<a href="{{ $user->linked_in }}" target="_blank" style="color: var(--accent); text-decoration: none;">LinkedIn ↗</a>@endif
                    @if($user->phone)<a href="https://wa.me/20{{$user->phone}}" target="_blank" style="color: var(--accent); text-decoration: none;">Whatsapp ↗</a>@endif
                        {{--                    @if($user->behance)<a href="{{ $user->behance }}" target="_blank" style="color: var(--accent); text-decoration: none;">Behance ↗</a>@endif--}}
{{--                    @if($user->my_site)<a href="{{ $user->my_site }}" target="_blank" style="color: var(--accent); text-decoration: none;">Website ↗</a>@endif--}}
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Skills</h2>
            <div class="skills-grid">
                @foreach(\App\Enums\SkillType::values() as $type)
                    @php $varName = str_replace(' ', '_', $type); @endphp
                    @if(isset($$varName) && count($$varName) > 0)
                        <div class="skill-group">
                            <h3>{{ $type }}</h3>
                            <div class="skill-list">
                                @foreach($$varName as $skill)
                                    <span class="skill-item">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="section">
            <h2>Projects</h2>
            @foreach($projects as $project)
                <div class="project">
                    <h3>{{ $project->name }}</h3>
                    <div class="project-meta">{{ $project->endDate ? $project->endDate->format('M Y') : 'Ongoing' }}</div>
                    <p>{{ $project->description ?: $project->caption }}</p>
                    @if($project->techmologyStack)
                        <div style="margin-top: 12px; display: flex; flex-wrap: wrap; gap: 8px;">
                            @foreach(explode(',', $project->techmologyStack) as $tech)
                                <span class="tag">{{ trim($tech) }}</span>
                            @endforeach
                        </div>
                    @endif
                    @if($project->link)
                        <a href="{{ $project->link }}" target="_blank">View Project →</a>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="section">
            <h2>Experience</h2>
            @foreach($works as $work)
                <div class="work-item">
                    <div class="work-title">{{ $work->title }}</div>
                    <div class="work-company">{{ $work->companyName }}</div>
                    <div class="work-period">{{ \Carbon\Carbon::parse($work->startDate)->format('M Y') }} - {{ $work->endDate ? \Carbon\Carbon::parse($work->endDate)->format('M Y') : 'Present' }}</div>
                    @if($work->caption)
                        <p style="color: var(--secondary); margin-top: 10px; line-height: 1.7;">{{ $work->caption }}</p>
                    @endif
                    @if($work->environment)
                        <div style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 8px;">
                            @foreach(explode(',', $work->environment) as $env)
                                <span class="tag">{{ trim($env) }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function toggleDark() {
            document.body.classList.toggle('dark');
            localStorage.setItem('darkMode', document.body.classList.contains('dark'));
        }
        if (localStorage.getItem('darkMode') === 'false') {
            document.body.classList.remove('dark');
        }
    </script>
</body>
</html>
