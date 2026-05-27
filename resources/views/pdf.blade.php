<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $user->fullName }} - CV</title>
    <style>
        @page {
            margin: 0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Helvetica, Arial, sans-serif;
            color: #1f2937;
            font-size: 10pt;
            line-height: 1.6;
        }

        /* ── HEADER ── */
        .header {
            padding: 40px 60px 28px;
            background: #1e293b;
            color: #ffffff;
        }

        .header-table { width: 100%; }

        .header-left { vertical-align: bottom; }

        .header-right {
            vertical-align: bottom;
            text-align: right;
            width: 250px;
        }

        .name {
            font-size: 28pt;
            font-weight: bold;
            line-height: 1.1;
            margin-bottom: 6px;
            color: #ffffff;
        }

        .title-line {
            font-size: 11pt;
            color: #94a3b8;
            margin-bottom: 2px;
        }

        .title-line strong {
            color: #60a5fa;
        }

        .contact-item {
            font-size: 8.5pt;
            color: #cbd5e1;
            line-height: 1.8;
        }

        .contact-item strong {
            color: #ffffff;
        }

        .contact-table {
            border-collapse: collapse;
        }

        .contact-table td {
            font-size: 8.5pt;
            color: #cbd5e1;
            line-height: 1.8;
            padding: 0 0 0 0;
            vertical-align: top;
        }

        .contact-label {
            color: #ffffff;
            font-weight: bold;
            white-space: nowrap;
            padding-right: 8px;
            text-align: left;
        }

        .contact-value {
            text-align: left;
        }

        /* ── CONTENT WRAPPER ── */
        .content {
            padding: 10px 60px 50px;
        }

        /* ── SECTION ── */
        .section {
            margin-top: 22px;
            page-break-inside: auto;
        }

        .section-title {
            font-size: 11.5pt;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding-bottom: 6px;
            border-bottom: 2px solid #3b82f6;
            margin-bottom: 12px;
            page-break-after: avoid;
        }

        /* ── ABOUT ── */
        .about-text {
            font-size: 9.5pt;
            color: #4b5563;
            line-height: 1.65;
        }

        /* ── WORK ── */
        .work-item {
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            page-break-inside: avoid;
        }

        .work-item:last-child { border-bottom: none; }

        .work-table { width: 100%; }

        .work-left {
            width: 115px;
            vertical-align: top;
            padding-right: 12px;
            padding-top: 1px;
        }

        .work-right { vertical-align: top; }

        .work-date {
            font-size: 8pt;
            color: #9ca3af;
            line-height: 1.6;
        }

        .work-company {
            font-size: 8.5pt;
            font-weight: bold;
            color: #3b82f6;
            margin-top: 3px;
        }

        .work-role {
            font-size: 10.5pt;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 3px;
        }

        .work-desc {
            font-size: 9pt;
            color: #6b7280;
            line-height: 1.55;
            margin-bottom: 4px;
        }

        .work-env {
            font-size: 7.5pt;
            color: #9ca3af;
            background: #f1f5f9;
            padding: 2px 7px;
            border-radius: 2px;
            display: inline;
        }

        /* ── SKILLS ── */
        .skills-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .skills-table td {
            vertical-align: top;
            width: 33.33%;
            padding: 0 8px 10px 0;
        }

        .skill-type {
            font-size: 7.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #9ca3af;
            margin-bottom: 5px;
        }

        .skill-tag {
            font-size: 7.5pt;
            padding: 2px 6px;
            background: #f1f5f9;
            color: #374151;
            border-radius: 2px;
            display: inline-block;
            margin: 1px 0;
        }

        .skill-tag-main {
            background: #dbeafe;
            color: #1d4ed8;
            font-weight: bold;
        }

        /* ── PROJECTS ── */
        .projects-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .projects-table td {
            vertical-align: top;
            width: 50%;
            padding: 0 5px 10px 0;
        }

        .proj-card {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 10px 14px;
            margin-bottom: 8px;
            page-break-inside: avoid;
        }

        .proj-name {
            font-size: 9.5pt;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 3px;
        }

        .proj-ongoing {
            font-size: 6.5pt;
            color: #22c55e;
            font-weight: bold;
        }

        .proj-caption {
            font-size: 8pt;
            color: #6b7280;
            line-height: 1.4;
            margin-bottom: 4px;
        }

        .proj-tech {
            font-size: 7pt;
            color: #9ca3af;
        }

        .proj-url {
            font-size: 7pt;
            color: #3b82f6;
            display: block;
            margin-top: 2px;
        }

        /* ── LANGUAGES ── */
        .lang-table { border-collapse: collapse; }

        .lang-table td {
            padding: 3px 24px 3px 0;
            vertical-align: top;
        }

        .lang-name {
            font-size: 9.5pt;
            font-weight: bold;
            color: #1e293b;
        }

        .lang-level {
            font-size: 8pt;
            color: #9ca3af;
        }

        /* ── FOOTER ── */
        .footer-area {
            margin-top: 22px;
            padding-top: 12px;
            border-top: 2px solid #1e293b;
        }

        .footer-table { width: 100%; }

        .footer-left { vertical-align: top; }

        .footer-right {
            vertical-align: top;
            text-align: right;
            font-size: 8pt;
            color: #9ca3af;
            line-height: 1.6;
        }

        .footer-right strong {
            color: #1e293b;
            font-size: 9pt;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <table class="header-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="header-left">
                <div class="name">{{ $user->fullName }}</div>
                <div class="title-line">{{ $user->title }} · <strong>{{ $user->expYear }}+ Years Experience</strong></div>
            </td>
            <td class="header-right">
                <table class="contact-table" cellpadding="0" cellspacing="0">
                    <tr><td class="contact-label">Email:</td><td class="contact-value">{{ $user->email }}</td></tr>
                    <tr><td class="contact-label">Phone:</td><td class="contact-value">{{ $user->phone }}</td></tr>
                    <tr><td class="contact-label">Location:</td><td class="contact-value">{{ $user->address }}</td></tr>
                    <tr><td class="contact-label">GitHub:</td><td class="contact-value">{{ $user->github }}</td></tr>
                    <tr><td class="contact-label">LinkedIn:</td><td class="contact-value">{{ $user->linked_in }}</td></tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<!-- CONTENT -->
<div class="content">

    <!-- ABOUT -->
    <div class="section">
        <div class="section-title">About</div>
        <p class="about-text">{{ $user->profile }}</p>
    </div>

    <!-- EXPERIENCE -->
    <div class="section">
        <div class="section-title">Experience</div>
        @foreach ($works as $w)
            <div class="work-item">
                <table class="work-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="work-left">
                            <div class="work-date">
                                {{ date('M Y', strtotime($w->startDate)) }} –<br>
                                {{ $w->endDate ? date('M Y', strtotime($w->endDate)) : ($w->current ?? 'Present') }}
                            </div>
                            <div class="work-company">{{ $w->companyName }}</div>
                        </td>
                        <td class="work-right">
                            <div class="work-role">{{ $w->title }}</div>
                            @if($w->caption)
                                <div class="work-desc">{{ $w->caption }}</div>
                            @endif
                            @if($w->environment)
                                <span class="work-env">{{ $w->environment }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    </div>

    <!-- SKILLS -->
    <div class="section">
        <div class="section-title">Skills</div>
        @php
            $allSkills = [];
            foreach(\App\Enums\SkillType::values() as $type) {
                $varName = str_replace(' ', '_', $type);
                if(isset($$varName) && count($$varName) > 0) {
                    $allSkills[] = ['type' => $type, 'items' => $$varName];
                }
            }
            $skillRows = array_chunk($allSkills, 3);
        @endphp
        @foreach($skillRows as $row)
            <table class="skills-table" cellpadding="0" cellspacing="0">
                <tr>
                    @foreach($row as $sg)
                        <td>
                            <div class="skill-type">{{ $sg['type'] }}</div>
                            @foreach($sg['items'] as $skill)
                                <span class="skill-tag {{ $skill->main ? 'skill-tag-main' : '' }}">{{ $skill->languageName }}</span>
                            @endforeach
                        </td>
                    @endforeach
                    @for($i = count($row); $i < 3; $i++)
                        <td></td>
                    @endfor
                </tr>
            </table>
        @endforeach
    </div>

    <!-- PROJECTS -->
    <div class="section">
        <div class="section-title">Projects</div>
        @foreach($projects as $p)
            <div class="proj-card">
                <div class="proj-name">
                    {{ $p->name }}
                    @if(!$p->endDate)
                        <span class="proj-ongoing">● ongoing</span>
                    @endif
                </div>
                @if($p->description ?: $p->caption)
                    <div class="proj-caption">{{ $p->description ?: $p->caption }}</div>
                @endif
                <div class="proj-tech">{{ $p->techmologyStack }}</div>
                @if($p->appURL)
                    <span class="proj-url">{{ $p->appURL }}</span>
                @endif
            </div>
        @endforeach
    </div>

    <!-- LANGUAGES + FOOTER -->
    <div class="footer-area">
        <table class="footer-table" cellpadding="0" cellspacing="0">
            <tr>
                <td class="footer-left">
                    <div class="section-title" style="margin-top: 0;">Languages</div>
                    <table class="lang-table" cellpadding="0" cellspacing="0">
                        <tr>
                            @foreach ($sLanguages as $sl)
                                @php
                                    $levelLabel = match($sl->level) {
                                        'Level 1' => 'Elementary',
                                        'Level 2' => 'Low Intermediate',
                                        'Level 3' => 'High Intermediate',
                                        'Level 4' => 'Advanced',
                                        'Level 5' => 'Native',
                                        default => $sl->level,
                                    };
                                @endphp
                                <td>
                                    <div class="lang-name">{{ $sl->languageName }}</div>
                                    <div class="lang-level">{{ $levelLabel }}</div>
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </td>
                <td class="footer-right">
                    <strong>{{ $user->fullName }}</strong><br>
                    Professional CV · {{ date('F Y') }}
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>
