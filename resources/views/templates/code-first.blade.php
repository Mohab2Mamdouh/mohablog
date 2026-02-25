<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code-First - {{ $user->fullName }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Fira Code', monospace;
            background: #1e1e1e;
            color: #d4d4d4;
            line-height: 1.8;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
        .line-numbers {
            position: absolute;
            left: 0;
            top: 0;
            padding: 20px 10px;
            color: #858585;
            user-select: none;
            text-align: right;
            width: 50px;
        }
        .code-section {
            background: #252526;
            border-left: 3px solid #FF2D20;
            margin: 20px 0;
            padding: 20px 20px 20px 70px;
            position: relative;
            border-radius: 4px;
        }
        h1 {
            font-size: 2.5rem;
            color: #4ec9b0;
            margin: 20px 0;
        }
        h1::before { content: 'php '; color: #569cd6; }
        h2 {
            color: #dcdcaa;
            font-size: 1.5rem;
            margin: 30px 0 15px;
        }
        h2::before { content: '// '; color: #6a9955; }
        .php-tag { color: #569cd6; }
        .class-name { color: #4ec9b0; }
        .function-name { color: #dcdcaa; }
        .str { color: #ce9178; }
        .kw { color: #c586c0; }
        .comment { color: #6a9955; }
        .variable { color: #9cdcfe; }
        .skill-badge {
            display: inline-block;
            background: #FF2D20;
            color: #fff;
            padding: 6px 14px;
            margin: 5px;
            border-radius: 4px;
            font-size: 0.85rem;
        }
        .project-block {
            background: #252526;
            border-left: 3px solid #4ec9b0;
            padding: 20px;
            margin: 15px 0;
            position: relative;
        }
        a { color: #4fc1ff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .nav-links {
            background: #2d2d30;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .nav-links a { margin-right: 20px; color: #4fc1ff; }
        pre { margin: 0; white-space: pre-wrap; word-break: break-word; }
    </style>
</head>
<body>
<div class="container">

    {{-- Header --}}
    <div class="code-section">
        <div class="line-numbers">1<br>2<br>3<br>4<br>5</div>
        <pre><span class="php-tag">&lt;?php</span>

<span class="kw">namespace</span> Portfolio;

<span class="kw">class</span> <span class="class-name">{{ str_replace(' ', '', $user->fullName) }}</span> <span class="kw">extends</span> <span class="class-name">BackendDeveloper</span>
{</pre>
        <h1>{{ $user->fullName }}</h1>
        <p><span class="kw">public</span> <span class="variable">$title</span> = <span class="str">"{{ $user->title }}"</span>;</p>
    </div>

    {{-- Nav --}}
    <div class="nav-links">
        <a href="{{ route('template.terminal') }}">Terminal</a>
        <a href="{{ route('template.code-first') }}">Code-First</a>
        <a href="{{ route('template.architecture') }}">Architecture</a>
        <a href="{{ route('template.minimalist') }}">Minimalist</a>
        <a href="{{ route('portfolio') }}" style="color: #FF2D20;">&#8592; Back to Original</a>
    </div>

    {{-- About --}}
    <h2>About Method</h2>
    <div class="code-section">
        <div class="line-numbers">12<br>13<br>14<br>15<br>16</div>
        <pre><span class="kw">public function</span> <span class="function-name">about</span>() <span class="php-tag">:</span> <span class="class-name">string</span>
{
    <span class="kw">return</span> <span class="str">"{{ $user->profile }}"</span>;
}</pre>
    </div>

    {{-- Skills --}}
    <h2>Skills Array</h2>
    <div class="code-section">
        <div class="line-numbers">20<br>21<br>22<br>23</div>
        <pre><span class="kw">protected</span> <span class="variable">$skills</span> = [</pre>
        @foreach(['Backend', 'Database', 'Fontend', 'Prior_Knowledge', 'Little_Knowledge', 'Other_Skills'] as $type)
            @php $varName = $type; @endphp
            @if(isset($$varName) && count($$varName) > 0)
                <div style="margin: 15px 0;">
                    <span class="comment">// {{ str_replace('_', ' ', $type) }}</span><br>
                    @foreach($$varName as $skill)
                        <span class="skill-badge">{{ $skill->name }}</span>
                    @endforeach
                </div>
            @endif
        @endforeach
        <pre>];</pre>
    </div>

    {{-- Projects --}}
    <h2>Projects Collection</h2>
    @foreach($projects as $index => $project)
        <div class="project-block">
                <pre><span class="kw">new</span> <span class="class-name">Project</span>([
    <span class="str">'name'</span>        =&gt; <span class="str">"{{ $project->name }}"</span>,
    <span class="str">'description'</span> =&gt; <span class="str">"{{ Str::limit($project->description, 100) }}"</span>,
    <span class="str">'date'</span>        =&gt; <span class="str">"{{ $project->endDate }}"</span>,
    @if($project->link)<span class="str">'link'</span> =&gt; <span class="str">"<a href="{{ $project->link }}" target="_blank">{{ $project->link }}</a>"</span>,
                    @endif
]);</pre>
        </div>
    @endforeach

    {{-- Work Experience --}}
    <h2>Work Experience</h2>
    <div class="code-section">
        @foreach($works as $work)
            <pre style="margin: 15px 0; padding: 10px; background: #1e1e1e;"><span class="variable">$experience</span>[] = [
    <span class="str">'title'</span>   =&gt; <span class="str">"{{ $work->title }}"</span>,
    <span class="str">'company'</span> =&gt; <span class="str">"{{ $work->company }}"</span>,
    <span class="str">'period'</span>  =&gt; <span class="str">"{{ $work->startDate }} - {{ $work->endDate ?? 'Present' }}"</span>,
];</pre>
        @endforeach
    </div>

</div>
</body>
</html>
