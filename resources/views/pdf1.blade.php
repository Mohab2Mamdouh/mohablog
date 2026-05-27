<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $user->fullName }} - CV</title>
    <style>
        @page { margin: 54pt 54pt 72pt 54pt; }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Helvetica, Arial, sans-serif;
            color: #1a1a2e;
            font-size: 9pt;
            line-height: 1.45;
            background: #ffffff;
        }

        /* ─── HEADER ─────────────────────────────────────────── */
        .name {
            font-size: 22pt;
            font-weight: bold;
            color: #1a1a2e;
            line-height: 1.2;
            margin-bottom: 4px;
        }
        .subtitle {
            font-size: 10pt;
            color: #1a56a0;
            margin-bottom: 6px;
            line-height: 1.4;
        }
        .contact {
            font-size: 8.5pt;
            color: #555555;
            line-height: 1.5;
            margin-bottom: 2px;
        }
        .contact a { color: #1a56a0; text-decoration: none; }

        /* ─── SECTIONS ───────────────────────────────────────── */
        .section { margin-top: 16px; }

        .section-title {
            font-size: 9pt;
            font-weight: bold;
            color: #1a56a0;
            text-transform: uppercase;
            letter-spacing: 1.5pt;
            margin-bottom: 3px;
        }
        .section-rule {
            border: none;
            border-bottom: 1.5pt solid #1a56a0;
            margin-bottom: 8px;
        }

        /* ─── ABOUT ──────────────────────────────────────────── */
        .about-text {
            font-size: 9pt;
            color: #555555;
            line-height: 1.45;
        }

        /* ─── EXPERIENCE ─────────────────────────────────────── */
        .work-item { margin-bottom: 10px; page-break-inside: avoid; }

        .work-title-line {
            font-size: 10pt;
            font-weight: bold;
            color: #1a1a2e;
            margin-bottom: 1px;
            line-height: 1.3;
        }
        .work-title-line .company { color: #1a56a0; font-weight: normal; }
        .work-title-line .sep     { color: #888888; }

        .work-meta {
            font-size: 8.5pt;
            color: #888888;
            font-style: italic;
            margin-bottom: 3px;
        }
        .work-desc {
            font-size: 9pt;
            color: #555555;
            line-height: 1.45;
            margin-bottom: 3px;
        }
        .work-stack {
            font-size: 8pt;
            color: #888888;
            font-style: italic;
            line-height: 1.3;
        }
        .work-stack b { font-style: normal; }

        /* ─── PROJECTS ───────────────────────────────────────── */
        .proj-card {
            border-left: 2.5pt solid #1a56a0;
            padding: 6px 10px;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        .proj-name {
            font-size: 10pt;
            font-weight: bold;
            color: #1a1a2e;
            margin-bottom: 2px;
        }
        .proj-status {
            font-size: 8pt;
            color: #888888;
            font-style: italic;
            font-weight: normal;
        }
        .proj-desc {
            font-size: 9pt;
            color: #555555;
            line-height: 1.4;
            margin-bottom: 3px;
        }
        .proj-stack {
            font-size: 8pt;
            color: #888888;
            font-style: italic;
        }
        .proj-stack b { font-style: normal; }
        .proj-url {
            font-size: 8pt;
            color: #1a56a0;
            margin-top: 2px;
        }

        /* ─── SKILLS ─────────────────────────────────────────── */
        .skills-table { width: 100%; border-collapse: collapse; }
        .skills-table td { vertical-align: top; padding: 3px 0; }
        .skill-label {
            font-size: 9pt;
            font-weight: bold;
            color: #1a1a2e;
            width: 110pt;
            padding-right: 8pt;
            white-space: nowrap;
        }
        .skill-value {
            font-size: 9pt;
            color: #555555;
            line-height: 1.45;
        }

        /* ─── LANGUAGES ──────────────────────────────────────── */
        .lang-table { border-collapse: collapse; }
        .lang-table td { padding-right: 28pt; vertical-align: top; padding-top: 3px; }
        .lang-name  { font-size: 10pt; font-weight: bold; color: #1a1a2e; }
        .lang-level { font-size: 8.5pt; color: #888888; }

        /* ─── FOOTER ─────────────────────────────────────────── */
        .footer-area {
            margin-top: 18px;
            padding-top: 8px;
            border-top: 2pt solid #1a1a2e;
        }
        .footer-byline {
            text-align: right;
            font-size: 8.5pt;
            color: #888888;
            line-height: 1.8;
        }
        .footer-byline strong { color: #1a1a2e; font-size: 9.5pt; }
        @page {
            margin: 54pt 54pt 30pt 54pt; /* top right bottom left — bottom makes room for footer */
            footer: html_cv-footer;       /* binds the footer to every page */
        }
    </style>
</head>
<body>

<!--mpdf
<htmlpagefooter name="cv-footer">
    <table style="width:100%; border-top: 2pt solid #1a1a2e; padding-top: 6px;">
        <tr>
            <td style="font-size:8.5pt; color:#888888; text-align:left;">
                Professional CV &middot; <?php echo $footerDate; ?>
    </td>
    <td style="font-size:9.5pt; color:#1a1a2e; font-weight:bold; text-align:right;">
<?php echo $user->fullName; ?>
    </td>
</tr>
</table>
</htmlpagefooter>
mpdf-->

{{-- ═══════════════════════ HEADER ══════════════════════════ --}}
<div class="name">{{ $user->fullName }}</div>
<div class="subtitle">{{ $user->title }} &nbsp;&middot;&nbsp; +{{ $user->expYear }} Years Experience</div>
<div class="contact">{{ $user->email }} &nbsp;&middot;&nbsp; {{ $user->phone }} &nbsp;&middot;&nbsp; {{ $user->address }}</div>
<div class="contact">
    <a href="https://{{ $user->github }}">{{ $user->github }}</a>
    &nbsp;&middot;&nbsp;
    <a href="https://{{ $user->linked_in }}">{{ $user->linked_in }}</a>
</div>

{{-- ═══════════════════════ ABOUT ════════════════════════════ --}}
<div class="section">
    <div class="section-title">About</div>
    <hr class="section-rule">
    <p class="about-text">{{ $user->profile }}</p>
</div>

{{-- ═══════════════════════ EXPERIENCE ═══════════════════════ --}}
<div class="section">
    <div class="section-title">Experience</div>
    <hr class="section-rule">

    @foreach ($works as $w)
        <div class="work-item">
            <div class="work-title-line">
                {{ $w->title }}
                <span class="sep">&nbsp;&middot;&nbsp;</span>
                <span class="company">{{ $w->companyName }}</span>
            </div>
            <div class="work-meta">
                {{ \Carbon\Carbon::parse($w->startDate)->format('M Y') }} &ndash;
                {{ $w->endDate ? \Carbon\Carbon::parse($w->endDate)->format('M Y') : 'Present' }}
            </div>
            @if ($w->caption)
                <div class="work-desc">{{ $w->caption }}</div>
            @endif
            @if ($w->environment)
                <div class="work-stack"><b>Stack:</b> {{ $w->environment }}</div>
            @endif
        </div>
    @endforeach
</div>

{{-- ═══════════════════════ SKILLS ═══════════════════════════ --}}
<div class="section">
    <div class="section-title">Skills</div>
    <hr class="section-rule">
    <table class="skills-table" cellpadding="0" cellspacing="0">
        @foreach (\App\Enums\SkillType::values() as $type)
            @php
                $varName = str_replace(' ', '_', $type);
                $items   = $$varName ?? collect();
            @endphp
            @if ($items->count())
                <tr>
                    <td class="skill-label">{{ $type }}</td>
                    <td class="skill-value">
                        @foreach ($items as $skill)
                            {{ $skill->languageName }}@if (!$loop->last), @endif
                        @endforeach
                    </td>
                </tr>
            @endif
        @endforeach
    </table>
</div>

{{-- ═══════════════════════ PROJECTS ═════════════════════════ --}}
<div class="section">
    <div class="section-title">Projects</div>
    <hr class="section-rule">

    @foreach ($projects as $p)
        <div class="proj-card">
            <div class="proj-name">
                {{ $p->name }}
                @if (! $p->endDate)
                    <span class="proj-status">&middot; ongoing</span>
                @endif
            </div>
            @if ($p->description ?: $p->caption)
                <div class="proj-desc">{{ $p->description ?: $p->caption }}</div>
            @endif
            @if ($p->techmologyStack)
                <div class="proj-stack"><b>Stack:</b> {{ $p->techmologyStack }}</div>
            @endif
            @if ($p->appURL)
                <div class="proj-url">{{ $p->appURL }}</div>
            @endif
        </div>
    @endforeach
</div>

{{-- ═══════════════════════ LANGUAGES ════════════════════════ --}}
<div class="section">
    <div class="section-title">Languages</div>
    <hr class="section-rule">
     <table class="lang-table" style="border-collapse: collapse;">
        <tr>
            @foreach ($sLanguages as $sl)
                @php
                    $levelLabel = match ($sl->level) {
                        'Level 1' => 'Elementary',
                        'Level 2' => 'Low Intermediate',
                        'Level 3' => 'High Intermediate',
                        'Level 4' => 'Advanced',
                        'Level 5' => 'Native',
                        default   => $sl->level,
                    };
                @endphp
                <td>
                    <div class="lang-name">{{ $sl->languageName }}</div>
                    <div class="lang-level">{{ $levelLabel }}</div>
                </td>
            @endforeach
        </tr>
    </table>
</div>

</body>
</html>
