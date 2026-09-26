<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->fullName }} - {{ $user->currentPosition }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($user->profile), 155) }}">
    <meta name="theme-color" content="#0a0a0a">

    @include('partials.machine-readable-meta')

    <script>
        // Applied before first paint so a light-mode visitor never sees a dark flash.
        if (localStorage.getItem('darkMode') !== 'false') {
            document.documentElement.classList.add('dark');
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg: #ffffff;
            --surface: #f9fafb;
            --text: #1a1a1a;
            --accent: #FF2D20;
            --secondary: #55606f;
            --border: #e5e7eb;
            --tag-bg: #f3f4f6;
            --tag-text: #4b5563;
        }
        html.dark {
            --bg: #0a0a0a;
            --surface: #141414;
            --text: #e5e7eb;
            --secondary: #a1a8b3;
            --border: #232a35;
            --tag-bg: #1b222c;
            --tag-text: #b6bec9;
        }

        html { scroll-behavior: smooth; -webkit-text-size-adjust: 100%; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
        }
        a { color: var(--accent); }
        :focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 3px;
            border-radius: 3px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 112px 24px 96px;
        }

        /* ---------- Header ---------- */
        .masthead { margin-bottom: 72px; }
        h1 {
            font-size: clamp(2.25rem, 8vw, 4rem);
            font-weight: 700;
            line-height: 1.05;
            letter-spacing: -0.035em;
            margin-bottom: 12px;
        }
        .subtitle {
            font-size: clamp(1.05rem, 3.5vw, 1.375rem);
            color: var(--secondary);
            font-weight: 300;
            letter-spacing: -0.01em;
        }

        /* ---------- Sections ---------- */
        .section {
            padding-top: 64px;
            margin-top: 64px;
            border-top: 1px solid var(--border);
        }
        h2 {
            font-size: clamp(1.5rem, 5vw, 2rem);
            font-weight: 600;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 36px;
            padding-bottom: 10px;
            position: relative;
            display: inline-block;
        }
        h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--accent);
        }

        /* Prose keeps a readable measure instead of spanning the full 900px. */
        .prose { max-width: 68ch; }
        .prose p + p { margin-top: 1em; }

        /* ---------- About ---------- */
        .about-lead {
            font-size: 1.0625rem;
            color: var(--secondary);
            line-height: 1.75;
        }
        .contact-list {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 10px 24px;
            margin-top: 28px;
            color: var(--secondary);
            font-size: 0.9375rem;
        }
        .contact-list li { display: flex; align-items: center; gap: 8px; }
        .contact-list a { color: inherit; text-decoration: none; }
        .contact-list a:hover { color: var(--accent); }
        .profile-links {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
        .profile-links a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border: 1px solid var(--border);
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: border-color 0.2s, background 0.2s;
        }
        .profile-links a:hover {
            border-color: var(--accent);
            background: var(--surface);
        }

        /* ---------- Skills ---------- */
        /* Label beside its tags: no grid columns, so one long group
           can't leave a column-sized hole next to a short one. */
        .skill-group {
            display: grid;
            grid-template-columns: 170px minmax(0, 1fr);
            gap: 24px;
            padding: 22px 0;
            border-top: 1px dashed var(--border);
        }
        .skill-group:first-child { border-top: none; padding-top: 0; }
        .skill-group h3 {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            line-height: 1.5;
            padding-top: 6px;
        }
        .skill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .skill-item {
            font-size: 0.875rem;
            color: var(--text);
            padding: 6px 12px;
            background: var(--tag-bg);
            border: 1px solid transparent;
            border-radius: 6px;
            transition: border-color 0.2s, color 0.2s;
        }
        .skill-item:hover { border-color: var(--accent); }

        /* ---------- Projects & experience ---------- */
        .entry {
            padding: 32px 0;
            border-top: 1px solid var(--border);
        }
        .entry:first-of-type { border-top: none; padding-top: 0; }
        .entry-head {
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
            justify-content: space-between;
            gap: 4px 16px;
            margin-bottom: 4px;
        }
        .entry-title {
            font-size: 1.25rem;
            font-weight: 600;
            letter-spacing: -0.015em;
            line-height: 1.3;
        }
        .entry-meta {
            color: var(--secondary);
            font-size: 0.8125rem;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }
        .entry-company {
            color: var(--accent);
            font-weight: 500;
            font-size: 0.9375rem;
            margin-bottom: 14px;
        }
        .entry-body {
            position: relative;
            margin-top: 14px;
            color: var(--secondary);
            line-height: 1.75;
            font-size: 0.96875rem;
        }
        .entry-body > p:first-child { color: var(--text); }

        /* Long case-study descriptions collapse until asked for. */
        .entry-body.is-collapsed {
            max-height: 12.5em;
            overflow: hidden;
        }
        .entry-body.is-collapsed:after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 6em;
            background: linear-gradient(to bottom, transparent, var(--bg));
            pointer-events: none;
        }
        .read-more {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 12px;
            padding: 0;
            background: none;
            border: none;
            color: var(--accent);
            font: inherit;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
        }
        .read-more:hover { text-decoration: underline; }
        .read-more .chevron { transition: transform 0.2s; }
        .read-more[aria-expanded="true"] .chevron { transform: rotate(180deg); }

        .tag-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 18px;
        }
        .tag {
            font-size: 0.75rem;
            line-height: 1.6;
            padding: 4px 10px;
            background: var(--tag-bg);
            border-radius: 4px;
            color: var(--tag-text);
        }
        .entry-link {
            display: inline-block;
            margin-top: 18px;
            font-size: 0.9375rem;
            font-weight: 500;
            text-decoration: none;
        }
        .entry-link:hover { text-decoration: underline; }

        /* ---------- Fixed controls ---------- */
        .top-controls {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-pill, .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 44px;
            border: none;
            background: var(--accent);
            color: #fff;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-pill { padding: 0 20px; border-radius: 22px; }
        .icon-btn { width: 44px; border-radius: 50%; font-size: 1.1rem; }
        .btn-pill:hover, .icon-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 45, 32, 0.35);
            color: #fff;
        }

        @media (max-width: 768px) {
            .container { padding: 92px 20px 80px; }
            .masthead { margin-bottom: 52px; }
            .section { padding-top: 48px; margin-top: 48px; }
            h2 { margin-bottom: 24px; }
            .skill-group {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .skill-group h3 { padding-top: 0; }
            .entry { padding: 26px 0; }
            /* Date sits under its title rather than drifting to the far edge. */
            .entry-head { display: block; }
            .entry-meta { display: block; margin-top: 4px; white-space: normal; }
        }
        @media (max-width: 600px) {
            .top-controls { top: 16px; right: 16px; gap: 8px; }
            .btn-pill, .icon-btn { height: 40px; }
            .btn-pill { padding: 0 14px; font-size: 0.8125rem; }
            .icon-btn { width: 40px; }
            .btn-pill .btn-label-long { display: none; }
        }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            * { transition: none !important; }
        }
        @media print {
            .top-controls { display: none; }
            .entry-body.is-collapsed { max-height: none; }
            .entry-body.is-collapsed:after, .read-more { display: none; }
        }
    </style>
</head>
<body>
    <div class="top-controls">
        <a href="{{ route('downloadPDF') }}" class="btn-pill">↓ <span class="btn-label"><span class="btn-label-long">Download </span>CV</span></a>
        <button class="icon-btn" onclick="toggleDark()" aria-label="Toggle dark mode" title="Toggle dark mode">◐</button>
    </div>
    @include('partials.markdown-button')

    <div class="container">
        <header class="masthead">
            <h1>{{ $user->fullName }}</h1>
            <p class="subtitle">{{ $user->title }}</p>
        </header>

        <section class="section" style="border-top: none; padding-top: 0; margin-top: 0;">
            <h2>About</h2>
            <div class="prose">
                <p class="about-lead">{{ $user->profile }}</p>
            </div>
            <ul class="contact-list">
                @if($user->address)<li>📍 {{ $user->address }}</li>@endif
                @if($user->email)<li>📧 <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></li>@endif
                @if($user->phone)<li>📱 <a href="tel:{{ $user->phone }}">{{ $user->phone }}</a></li>@endif
            </ul>
            <div class="profile-links">
                @if($user->github)<a href="{{ $user->github }}" target="_blank" rel="noopener noreferrer">GitHub ↗</a>@endif
                @if($user->linked_in)<a href="{{ $user->linked_in }}" target="_blank" rel="noopener noreferrer">LinkedIn ↗</a>@endif
                @if($user->phone)<a href="https://wa.me/20{{ $user->phone }}" target="_blank" rel="noopener noreferrer">WhatsApp ↗</a>@endif
            </div>
        </section>

        <section class="section">
            <h2>Skills</h2>
            <div class="skills">
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
        </section>

        <section class="section">
            <h2>Projects</h2>
            @foreach($projects as $project)
                <article class="entry">
                    <div class="entry-head">
                        <h3 class="entry-title">{{ $project->name }}</h3>
                        <span class="entry-meta">{{ $project->endDate ? $project->endDate->format('M Y') : 'Ongoing' }}</span>
                    </div>
                    @php $body = trim((string) ($project->description ?: $project->caption)); @endphp
                    @if($body)
                        <div class="entry-body prose" data-collapsible>
                            @foreach(preg_split('/\R\s*\R/', $body) as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    @endif
                    @if($project->techmologyStack)
                        <div class="tag-row">
                            @foreach(array_filter(array_map('trim', explode(',', $project->techmologyStack))) as $tech)
                                <span class="tag">{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif
                    @if($project->link)
                        <a class="entry-link" href="{{ $project->link }}" target="_blank" rel="noopener noreferrer">View Project →</a>
                    @endif
                </article>
            @endforeach
        </section>

        <section class="section">
            <h2>Experience</h2>
            @foreach($works as $work)
                <article class="entry">
                    <div class="entry-head">
                        <h3 class="entry-title">{{ $work->title }}</h3>
                        <span class="entry-meta">{{ \Carbon\Carbon::parse($work->startDate)->format('M Y') }} — {{ $work->endDate ? \Carbon\Carbon::parse($work->endDate)->format('M Y') : 'Present' }}</span>
                    </div>
                    <div class="entry-company">{{ $work->companyName }}</div>
                    @php $caption = trim((string) $work->caption); @endphp
                    @if($caption)
                        <div class="entry-body prose" data-collapsible>
                            @foreach(preg_split('/\R\s*\R/', $caption) as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    @endif
                    @if($work->environment)
                        <div class="tag-row">
                            @foreach(array_filter(array_map('trim', explode(',', $work->environment))) as $env)
                                <span class="tag">{{ $env }}</span>
                            @endforeach
                        </div>
                    @endif
                </article>
            @endforeach
        </section>
    </div>

    <script>
        function toggleDark() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', isDark);
        }

        // Collapse any entry taller than the fold and give it a toggle.
        // Short entries are left untouched, so no stray "Read more" appears.
        document.querySelectorAll('[data-collapsible]').forEach(function (body) {
            const limit = parseFloat(getComputedStyle(body).fontSize) * 12.5;
            if (body.scrollHeight <= limit + 24) return;

            body.classList.add('is-collapsed');

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'read-more';
            btn.setAttribute('aria-expanded', 'false');
            btn.innerHTML = '<span class="read-more-label">Read more</span><span class="chevron" aria-hidden="true">⌄</span>';
            btn.addEventListener('click', function () {
                const expanded = body.classList.toggle('is-collapsed') === false;
                btn.setAttribute('aria-expanded', String(expanded));
                btn.querySelector('.read-more-label').textContent = expanded ? 'Show less' : 'Read more';
                if (!expanded) {
                    body.parentElement.scrollIntoView({ block: 'nearest' });
                }
            });
            body.insertAdjacentElement('afterend', btn);
        });
    </script>
</body>
</html>
