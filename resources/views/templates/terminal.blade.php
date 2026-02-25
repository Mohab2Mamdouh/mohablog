<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminal Style - {{ $user->fullName }}</title>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'JetBrains Mono', monospace;
            background: #0d1117;
            color: #58a6ff;
            line-height: 1.6;
        }
        .terminal-header {
            background: #161b22;
            padding: 10px 20px;
            border-bottom: 1px solid #30363d;
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .terminal-btn { width: 12px; height: 12px; border-radius: 50%; }
        .btn-red { background: #ff5f56; }
        .btn-yellow { background: #ffbd2e; }
        .btn-green { background: #27c93f; }
        .container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
        .prompt { color: #7ee787; }
        .command { color: #79c0ff; }
        h1 { font-size: 2.5rem; margin: 40px 0 20px; color: #c9d1d9; }
        h2 {
            font-size: 1.5rem;
            color: #8b949e;
            margin: 40px 0 20px;
        }
        h2:before { content: '$ '; color: #7ee787; }
        .section { margin: 30px 0; }
        .code-block {
            background: #161b22;
            border: 1px solid #30363d;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .line-number { color: #6e7681; margin-right: 20px; user-select: none; }
        .skill-tag {
            display: inline-block;
            background: #1f6feb;
            color: #fff;
            padding: 5px 12px;
            border-radius: 20px;
            margin: 5px;
            font-size: 0.85rem;
        }
        .project-card {
            background: #161b22;
            border: 1px solid #30363d;
            border-radius: 6px;
            padding: 20px;
            margin: 15px 0;
            transition: border-color 0.3s;
        }
        .project-card:hover { border-color: #58a6ff; }
        .typing::after {
            content: '▊';
            animation: blink 1s infinite;
        }
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }
        a { color: #58a6ff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .nav-links { margin: 20px 0; }
        .nav-links a {
            margin-right: 20px;
            color: #7ee787;
        }
    </style>
</head>
<body>
    <div class="terminal-header">
        <span class="terminal-btn btn-red"></span>
        <span class="terminal-btn btn-yellow"></span>
        <span class="terminal-btn btn-green"></span>
        <span style="margin-left: 10px; color: #8b949e;">portfolio@laravel:~</span>
    </div>

    <div class="container">
        <div class="code-block">
            <div><span class="prompt">mohab@backend:~$</span> <span class="command">whoami</span></div>
            <h1>{{ $user->fullName }}</h1>
            <p style="color: #8b949e;">{{ $user->title }}</p>
        </div>

        <div class="nav-links">
            <a href="{{ route('template.terminal') }}">Terminal</a>
            <a href="{{ route('template.code-first') }}">Code-First</a>
            <a href="{{ route('template.architecture') }}">Architecture</a>
            <a href="{{ route('template.minimalist') }}">Minimalist</a>
            <a href="{{ route('portfolio') }}" style="color: #ff7b72;">← Back to Original</a>
        </div>

        <div class="section">
            <h2>cat about.txt</h2>
            <div class="code-block">
                <p>{{ $user->about }}</p>
            </div>
        </div>

        <div class="section">
            <h2>ls -la skills/</h2>
            <div class="code-block">
                @foreach(['Backend', 'Database', 'Fontend'] as $type)
                    @php $varName = str_replace(' ', '_', $type); @endphp
                    @if(isset($$varName) && count($$varName) > 0)
                        <div style="margin: 20px 0;">
                            <div style="color: #7ee787;">drwxr-xr-x {{ $type }}/</div>
                            @foreach($$varName as $skill)
                                <span class="skill-tag">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="section">
            <h2>git log --projects</h2>
            @foreach($projects as $project)
                <div class="project-card">
                    <div style="color: #f0883e;">commit {{ md5($project->id) }}</div>
                    <div style="color: #8b949e; margin: 5px 0;">Date: {{ $project->endDate }}</div>
                    <h3 style="color: #c9d1d9; margin: 10px 0;">{{ $project->name }}</h3>
                    <p style="color: #8b949e;">{{ $project->description }}</p>
                    @if($project->link)
                        <a href="{{ $project->link }}" target="_blank" style="margin-top: 10px; display: inline-block;">→ View Project</a>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="section">
            <h2>history | grep experience</h2>
            <div class="code-block">
                @foreach($works as $work)
                    <div style="margin: 15px 0; padding: 15px; border-left: 3px solid #1f6feb;">
                        <div style="color: #c9d1d9; font-weight: 600;">{{ $work->title }}</div>
                        <div style="color: #7ee787;">{{ $work->company }}</div>
                        <div style="color: #6e7681; font-size: 0.9rem;">{{ $work->startDate }} - {{ $work->endDate ?? 'Present' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
