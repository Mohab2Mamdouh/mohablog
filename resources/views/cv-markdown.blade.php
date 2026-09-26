<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markdown CV - {{ $user->fullName }}</title>
    <meta name="robots" content="noindex">
    @include('partials.machine-readable-meta')
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg: #0d1117;
            --panel: #161b22;
            --border: #30363d;
            --text: #e6edf3;
            --muted: #8b949e;
            --accent: #ff2d20;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            padding: 40px 20px 80px;
        }

        .wrap { max-width: 900px; margin: 0 auto; }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 14px;
        }
        .eyebrow::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #3fb950;
        }

        h1 { font-size: 1.6rem; font-weight: 700; letter-spacing: -0.02em; }

        .lede {
            color: var(--muted);
            margin-top: 12px;
            max-width: 62ch;
            font-size: 0.95rem;
        }
        .lede code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 0.85em;
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 1px 5px;
            color: var(--text);
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 26px 0 18px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            height: 38px;
            padding: 0 16px;
            border: 1px solid var(--border);
            border-radius: 19px;
            background: var(--panel);
            color: var(--text);
            font-size: 0.85rem;
            font-weight: 600;
            font-family: inherit;
            text-decoration: none;
            cursor: pointer;
            transition: border-color 0.2s, color 0.2s, transform 0.2s;
        }
        .btn:hover { border-color: var(--accent); transform: translateY(-1px); }
        .btn--primary { background: var(--accent); border-color: var(--accent); color: #fff; }
        .btn--primary:hover { color: #fff; }

        .meta {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 0.75rem;
            color: var(--muted);
            margin-bottom: 10px;
        }

        .source {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
        }
        .source__bar {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-bottom: 1px solid var(--border);
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 0.76rem;
            color: var(--muted);
        }
        .dot { width: 11px; height: 11px; border-radius: 50%; display: inline-block; }
        .dot--r { background: #ff5f57; }
        .dot--y { background: #febc2e; }
        .dot--g { background: #28c840; }
        .source__name { margin-left: 8px; color: var(--text); }

        pre {
            margin: 0;
            padding: 22px;
            overflow-x: auto;
            font-family: ui-monospace, SFMono-Regular, 'SF Mono', Menlo, Consolas, monospace;
            font-size: 0.82rem;
            line-height: 1.75;
            color: var(--text);
            white-space: pre;
            tab-size: 2;
        }

        .toast {
            position: fixed;
            left: 50%;
            bottom: 28px;
            transform: translate(-50%, 20px);
            background: #3fb950;
            color: #06250f;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 9px 18px;
            border-radius: 20px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s, transform 0.25s;
        }
        .toast.is-visible { opacity: 1; transform: translate(-50%, 0); }

        @media (max-width: 600px) {
            body { padding: 26px 14px 60px; }
            h1 { font-size: 1.3rem; }
            pre { font-size: 0.74rem; padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="eyebrow">Machine-readable CV</div>
        <h1>What an AI agent sees</h1>

        <p class="lede">
            This is the exact document served when an AI crawler requests the portfolio &mdash;
            no styling, no scripts, just structured Markdown. Any visitor can ask for it too, with
            <code>?format=md</code> or an <code>Accept: text/markdown</code> header.
        </p>

        <div class="actions">
            <a class="btn btn--primary" href="{{ route('cv.markdown') }}?raw=1" target="_blank" rel="noopener">View raw</a>
            <button class="btn" type="button" onclick="copyMarkdown(this)">Copy Markdown</button>
            <a class="btn" href="{{ route('cv.markdown') }}" download="{{ Str::slug($user->fullName) }}-cv.md">Download .md</a>
            <a class="btn" href="{{ route('downloadPDF') }}">Download PDF</a>
            <a class="btn" href="{{ route('portfolio') }}">&larr; Back to CV</a>
        </div>

        <div class="meta">{{ number_format($lines) }} lines &middot; {{ number_format($bytes) }} bytes</div>

        <div class="source">
            <div class="source__bar">
                <span class="dot dot--r"></span>
                <span class="dot dot--y"></span>
                <span class="dot dot--g"></span>
                <span class="source__name">cv.md</span>
            </div>
            <pre id="markdown-source">{{ $markdown }}</pre>
        </div>
    </div>

    <div class="toast" id="toast">Copied to clipboard</div>

    <script>
        function copyMarkdown(button) {
            const text = document.getElementById('markdown-source').textContent;

            const done = () => {
                const toast = document.getElementById('toast');
                toast.classList.add('is-visible');
                setTimeout(() => toast.classList.remove('is-visible'), 1800);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(done);
                return;
            }

            // Fallback for plain-HTTP origins, where the Clipboard API is unavailable.
            const area = document.createElement('textarea');
            area.value = text;
            area.style.position = 'fixed';
            area.style.opacity = '0';
            document.body.appendChild(area);
            area.select();
            document.execCommand('copy');
            document.body.removeChild(area);
            done();
        }
    </script>
</body>
</html>
