<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Architecture - {{ $user->fullName }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0a0e27;
            color: #e0e6ed;
            line-height: 1.6;
        }
        .container { max-width: 1400px; margin: 0 auto; padding: 40px 20px; }
        .architecture-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .layer {
            background: linear-gradient(135deg, #1a1f3a 0%, #0f1729 100%);
            border: 2px solid #2d3561;
            border-radius: 8px;
            padding: 25px;
            position: relative;
            transition: all 0.3s;
        }
        .layer:hover {
            border-color: #FF2D20;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(255, 45, 32, 0.2);
        }
        .layer-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #FF2D20;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .layer-title:before {
            content: '';
            width: 8px;
            height: 8px;
            background: #FF2D20;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }
        h1 {
            font-size: 3rem;
            color: #fff;
            text-align: center;
            margin: 40px 0;
            position: relative;
        }
        h1:after {
            content: '';
            display: block;
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #FF2D20, transparent);
            margin: 20px auto;
        }
        .subtitle {
            text-align: center;
            color: #8892b0;
            font-size: 1.2rem;
            margin-bottom: 40px;
        }
        .connection-line {
            position: relative;
            height: 2px;
            background: linear-gradient(90deg, #2d3561, #FF2D20, #2d3561);
            margin: 30px 0;
        }
        .skill-node {
            display: inline-block;
            background: #1a1f3a;
            border: 2px solid #4a5568;
            padding: 8px 16px;
            margin: 5px;
            border-radius: 20px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .skill-node:hover {
            border-color: #FF2D20;
            background: #2d1f1a;
        }
        .project-card {
            background: #1a1f3a;
            border-left: 4px solid #FF2D20;
            padding: 20px;
            margin: 15px 0;
            border-radius: 4px;
            transition: all 0.3s;
        }
        .project-card:hover {
            background: #1f2540;
            transform: translateX(10px);
        }
        .flow-diagram {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 40px 0;
            flex-wrap: wrap;
            gap: 20px;
        }
        .flow-box {
            flex: 1;
            min-width: 200px;
            background: #1a1f3a;
            border: 2px solid #2d3561;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            position: relative;
        }
        .flow-box:not(:last-child):after {
            content: '→';
            position: absolute;
            right: -30px;
            top: 50%;
            transform: translateY(-50%);
            color: #FF2D20;
            font-size: 2rem;
        }
        a { color: #FF2D20; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .nav-links {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: #1a1f3a;
            border-radius: 8px;
        }
        .nav-links a {
            margin: 0 15px;
            color: #8892b0;
            transition: color 0.3s;
        }
        .nav-links a:hover { color: #FF2D20; }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $user->fullName }}</h1>
        <div class="subtitle">{{ $user->title }}</div>

        <div class="nav-links">
            <a href="{{ route('template.terminal') }}">Terminal</a>
            <a href="{{ route('template.code-first') }}">Code-First</a>
            <a href="{{ route('template.architecture') }}">Architecture</a>
            <a href="{{ route('template.minimalist') }}">Minimalist</a>
            <a href="{{ route('portfolio') }}">← Back to Original</a>
        </div>

        <div class="layer">
            <div class="layer-title">System Overview</div>
            <p>{{ $user->about }}</p>
        </div>

        <div class="connection-line"></div>

        <div class="flow-diagram">
            <div class="flow-box">
                <h3 style="color: #FF2D20;">Request</h3>
                <p style="color: #8892b0; font-size: 0.9rem;">Client Layer</p>
            </div>
            <div class="flow-box">
                <h3 style="color: #FF2D20;">Routes</h3>
                <p style="color: #8892b0; font-size: 0.9rem;">API Gateway</p>
            </div>
            <div class="flow-box">
                <h3 style="color: #FF2D20;">Controller</h3>
                <p style="color: #8892b0; font-size: 0.9rem;">Business Logic</p>
            </div>
            <div class="flow-box">
                <h3 style="color: #FF2D20;">Model</h3>
                <p style="color: #8892b0; font-size: 0.9rem;">Data Layer</p>
            </div>
            <div class="flow-box">
                <h3 style="color: #FF2D20;">Response</h3>
                <p style="color: #8892b0; font-size: 0.9rem;">JSON/View</p>
            </div>
        </div>

        <div class="connection-line"></div>

        <div class="architecture-grid">
            @foreach(['Backend', 'Database', 'Frontend'] as $type)
                @php $varName = str_replace(' ', '_', $type); @endphp
                @if(isset($$varName) && count($$varName) > 0)
                    <div class="layer">
                        <div class="layer-title">{{ $type }} Layer</div>
                        @foreach($$varName as $skill)
                            <span class="skill-node">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>

        <div class="connection-line"></div>

        <div class="layer">
            <div class="layer-title">Project Architecture</div>
            @foreach($projects as $project)
                <div class="project-card">
                    <h3 style="color: #fff; margin-bottom: 10px;">{{ $project->name }}</h3>
                    <p style="color: #8892b0; margin-bottom: 10px;">{{ $project->description }}</p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #6b7280; font-size: 0.9rem;">{{ $project->endDate }}</span>
                        @if($project->link)
                            <a href="{{ $project->link }}" target="_blank">View Project →</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="connection-line"></div>

        <div class="layer">
            <div class="layer-title">Experience Pipeline</div>
            @foreach($works as $work)
                <div style="margin: 20px 0; padding: 15px; background: #0f1729; border-radius: 6px;">
                    <h4 style="color: #fff;">{{ $work->title }}</h4>
                    <p style="color: #FF2D20; margin: 5px 0;">{{ $work->company }}</p>
                    <p style="color: #6b7280; font-size: 0.9rem;">{{ $work->startDate }} - {{ $work->endDate ?? 'Present' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
