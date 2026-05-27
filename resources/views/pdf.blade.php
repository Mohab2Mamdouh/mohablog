<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $user->fullName }} - CV</title>
    <style>
        @page { margin: 0; }
        @page :first { margin: 0; }
        @page :left { margin-top: 30px; }
        @page :right { margin-top: 30px; }
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
        .header-right { vertical-align: bottom; text-align: right; width: 250px; }
        .name {
            font-size: 28pt;
            font-weight: bold;
            line-height: 1.1;
            margin-bottom: 6px;
            color: #ffffff;
        }
        /* font-size reduced + nowrap via white-space (mPDF 8 supports it on block elements) */
        .title-line { font-size: 10pt; color: #94a3b8; margin-bottom: 2px; }
        .title-line strong { color: #60a5fa; }
        .contact-table { border-collapse: collapse; }
        .contact-table td {
            font-size: 8.5pt;
            color: #cbd5e1;
            line-height: 1.8;
            padding: 0;
            vertical-align: top;
        }
        .contact-label { color: #ffffff; font-weight: bold; padding-right: 8px; }

        /* ── CONTENT ── */
        .content { padding: 10px 60px 30px; }

        /* ── SECTIONS ── */
        .section { margin-top: 18px; page-break-inside: avoid; }
        .section-breakable { margin-top: 18px; }
        .section-title {
            font-size: 11.5pt;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding-bottom: 5px;
            border-bottom: 2px solid #3b82f6;
            margin-bottom: 10px;
            page-break-after: avoid;
        }

        /* ── ABOUT ── */
        .about-text { font-size: 11pt; color: #4b5563; line-height: 1.6; }

        /* ── EXPERIENCE ── */
        .work-item {
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            page-break-inside: avoid;
        }
        .work-item:last-child { border-bottom: none; }
        .work-table { width: 100%; }
        .work-left { width: 130px; vertical-align: top; padding-right: 12px; padding-top: 1px; }
        .work-right { vertical-align: top; }
        .work-date { font-size: 9.5pt; color: #9ca3af; line-height: 1.5; }
        .work-company { font-size: 10pt; font-weight: bold; color: #3b82f6; margin-top: 2px; }
        .work-role { font-size: 11.5pt; font-weight: bold; color: #1e293b; margin-bottom: 2px; }
        .work-desc { font-size: 10pt; color: #6b7280; line-height: 1.5; margin-bottom: 3px; }
        .work-env {
            font-size: 9pt;
            color: #9ca3af;
            background: #f1f5f9;
            padding: 1px 6px;
        }

        /* ── SKILLS ── */
        .skill-group { margin-bottom: 10px; }
        .skill-type {
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #9ca3af;
            margin-bottom: 3px;
        }
        .skill-list { font-size: 10pt; color: #374151; line-height: 1.6; }
        .skill-main { font-weight: bold; color: #1d4ed8; }

         /* ── LANGUAGES ── */
         .lang-table { border-collapse: collapse; }
         .lang-table td { padding: 2px 20px 2px 0; vertical-align: top; }
        .lang-name { font-size: 11pt; font-weight: bold; color: #1e293b; }
        .lang-level { font-size: 9pt; color: #9ca3af; }

        /* ── PROJECTS ── */
        .proj-card {
            border-left: 3px solid #3b82f6;
            padding: 8px 12px;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        .proj-name { font-size: 11pt; font-weight: bold; color: #1e293b; margin-bottom: 2px; }
        .proj-ongoing { font-size: 8pt; color: #22c55e; font-weight: bold; }
        .proj-caption { font-size: 9.5pt; color: #6b7280; line-height: 1.35; margin-bottom: 3px; }
        .proj-tech { font-size: 8.5pt; color: #9ca3af; }
        .proj-url { font-size: 8.5pt; color: #3b82f6; }

        /* ── FOOTER ── */
        .footer-area {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #1e293b;
        }
        .footer-byline { text-align: right; font-size: 9pt; color: #9ca3af; line-height: 1.8; }
        .footer-byline strong { color: #1e293b; font-size: 10pt; }
    </style>
</head>
<body>

<!-- ═══════════════════════════════ HEADER ═══════════════════════════════ -->
<div class="header">
    <div class="name">{{ $user->fullName }}</div>
    <div style="color:#94a3b8;font-size:10pt;margin-bottom:14px;">
        {{ $user->title }} &middot; <strong style="color:#60a5fa;">+{{ $user->expYear }} Years Experience</strong>
    </div>
    <table class="contact-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="contact-label">Email:</td><td style="padding-right:24px;">{{ $user->email }}</td>
            <td class="contact-label">Phone:</td><td style="padding-right:24px;">{{ $user->phone }}</td>
            <td class="contact-label">Location:</td><td>{{ $user->address }}</td>
        </tr>
        <tr>
            <td class="contact-label">GitHub: </td><td style="padding-right:24px;">{{ $user->github }}</td>
            <td class="contact-label">LinkedIn: </td><td colspan="3">{{ $user->linked_in }}</td>
        </tr>
    </table>
</div>

<!-- ═══════════════════════════ PAGE 1 CONTENT ═══════════════════════════ -->
<div class="content">

    <!-- ABOUT -->
    <div class="section">
        <div class="section-title">About</div>
        <p class="about-text">{{ $user->profile }}</p>
    </div>

    <!-- EXPERIENCE -->
    <div class="section-breakable">
        <div class="section-title">Experience</div>
        @foreach ($works as $w)
            <div class="work-item">
                <table class="work-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="work-left">
                            <div class="work-date">
                                {{ date('M Y', strtotime($w->startDate)) }} &ndash;<br>
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
                                <div class="work-env">{{ $w->environment }}</div>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    </div>

</div><!-- end page 1 content -->

<!-- ═══════════════════════════ PAGE 2 ═══════════════════════════════════ -->
<pagebreak />
<div class="content">

    @php
        $allSkills = [];
        foreach(\App\Enums\SkillType::values() as $type) {
            $varName = str_replace(' ', '_', $type);
            if(isset($$varName) && count($$varName) > 0) {
                $allSkills[] = ['type' => $type, 'items' => $$varName];
            }
        }
    @endphp

    <!-- SKILLS -->
    <div class="section">
        <div class="section-title">Skills</div>
        <table style="width:100%;border-collapse:collapse;" cellpadding="0" cellspacing="0">
            @foreach($allSkills as $sg)
                <tr>
                    <td style="width:110px;vertical-align:top;padding:4px 10px 4px 0;">
                        <div class="skill-type">{{ $sg['type'] }}</div>
                    </td>
                    <td style="vertical-align:top;padding:4px 0;">
                        <div class="skill-list">
                            @foreach($sg['items'] as $skill)
                                <span class="{{ $skill->main ? 'skill-main' : '' }}">{{ $skill->languageName }}</span>@if(!$loop->last), @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <!-- PROJECTS -->
    <div style="margin-top:18px;">
        <div class="section-title">Projects</div>
        @foreach($projects as $p)
            <div class="proj-card">
                <div class="proj-name">
                    {{ $p->name }}
                    @if(!$p->endDate)
                        <span class="proj-ongoing">&bull; ongoing</span>
                    @endif
                </div>
                @if($p->description ?: $p->caption)
                    <div class="proj-caption">{{ $p->description ?: $p->caption }}</div>
                @endif
                <div class="proj-tech">{{ $p->techmologyStack }}</div>
                @if($p->appURL)
                    <div class="proj-url">{{ $p->appURL }}</div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- LANGUAGES -->
    <div class="section">
        <div class="section-title">Languages</div>
        <table style="border-collapse:collapse;" cellpadding="0" cellspacing="0">
            <tr>
                @foreach ($sLanguages as $sl)
                    @php
                        $levelLabel = match($sl->level) {
                            'Level 1' => 'Elementary',
                            'Level 2' => 'Low Intermediate',
                            'Level 3' => 'High Intermediate',
                            'Level 4' => 'Advanced',
                            'Level 5' => 'Native',
                            default   => $sl->level,
                        };
                    @endphp
                    <td style="padding-right:30px;vertical-align:top;">
                        <div class="lang-name">{{ $sl->languageName }}</div>
                        <div class="lang-level">{{ $levelLabel }}</div>
                    </td>
                @endforeach
            </tr>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="footer-area">
        <div class="footer-byline">
            <strong>{{ $user->fullName }}</strong><br>
            Professional CV &middot; {{ date('F Y') }}
        </div>
    </div>

</div><!-- end page 2 content -->

</body>
</html>
