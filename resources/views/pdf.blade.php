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
            font-family: Arial, sans-serif;
            color: #2d3748;
            font-size: 10pt;
            line-height: 1.5;
        }

        .header {
            background: #6366f1;
            color: white;
            padding: 30px 50px;
            margin-bottom: 20px;
        }

        .name {
            font-size: 28pt;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .title {
            font-size: 13pt;
            margin-bottom: 15px;
        }

        .contact-info {
            font-size: 9pt;
            line-height: 1.8;
        }

        .content {
            padding: 0 50px 40px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 13pt;
            font-weight: bold;
            color: #6366f1;
            margin-bottom: 15px;
            padding-bottom: 6px;
            border-bottom: 2px solid #6366f1;
            text-transform: uppercase;
        }

        .about-text {
            text-align: justify;
            color: #4a5568;
            font-size: 9.5pt;
            line-height: 1.6;
        }

        .item {
            margin-bottom: 18px;
            padding-left: 15px;
            border-left: 2px solid #e2e8f0;
            page-break-inside: avoid;
        }

        .item-title {
            font-size: 11pt;
            font-weight: bold;
            color: #1a202c;
        }

        .item-subtitle {
            font-size: 10pt;
            color: #6366f1;
            font-weight: bold;
        }

        .item-date {
            font-size: 9pt;
            color: #718096;
            font-style: italic;
        }

        .item-description {
            margin-top: 6px;
            color: #4a5568;
            font-size: 9.5pt;
        }

        .item-tech {
            margin-top: 6px;
            font-size: 9pt;
            color: #718096;
        }

        .skills-grid {
            display: block;
            width: 100%;
        }

        .skill-col {
            width: 48%;
            float: left;
            margin-right: 4%;
            display: inline-block;
        }

        .skill-col:nth-child(even) {
            margin-right: 0;
        }

        .skill-col:after {
            content: "";
            display: table;
            clear: both;
        }

        .skill-block {
            margin-bottom: 15px;
        }

        .skill-title {
            font-size: 10pt;
            font-weight: bold;
            color: #1a202c;
            margin-bottom: 8px;
        }

        .skill-list {
            list-style: none;
            padding: 0;
        }

        .skill-list li {
            padding: 3px 0;
            color: #4a5568;
            font-size: 9pt;
        }

        .lang-item {
            padding: 6px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .lang-name {
            font-weight: bold;
            color: #1a202c;
        }

        .lang-level {
            color: #4a5568;
            font-size: 9pt;
        }

        .page-break {
            page-break-before: always;
            padding-top: 20px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #f7fafc;
            padding: 12px 50px;
            font-size: 8pt;
            color: #718096;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="name">{{ $user->fullName }}</div>
        <div class="title">{{ $user->title }}</div>
        <div class="contact-info">
            <div><strong>Email:</strong> {{ $user->email }} | <strong>Phone:</strong> {{ $user->phone }}</div>
            <div><strong>Location:</strong> {{ $user->address }} | <strong>Experience:</strong> {{ $user->expYear }}+ Years</div>
            <div><strong>LinkedIn:</strong> {{ $user->linked_in }}</div>
            <div><strong>GitHub:</strong> {{ $user->github }}</div>
        </div>
    </div>

    <div class="content">
        <div class="section">
            <div class="section-title">About Me</div>
            <div class="about-text">{{ $user->profile }}</div>
        </div>

        <div class="section">
            <div class="section-title">Work Experience</div>
            @foreach ($works as $w)
                <div class="item">
                    <div class="item-title">{{ $w->title }}</div>
                    <div class="item-subtitle">{{ $w->companyName }}</div>
                    <div class="item-date">{{ date('M Y', strtotime($w->startDate)) }} - {{ $w->endDate ? date('M Y', strtotime($w->endDate)) : $w->current }}</div>
                    <div class="item-description">{{ $w->caption }}</div>
                    <div class="item-tech"><strong>Environment:</strong> {{ $w->environment }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="content page-break">
        <div class="section">
            <div class="section-title">Technical Skills</div>
            @php
                $types = ['Backend', 'Frontend', 'Database', 'Prior Knowledge', 'Little Knowledge', 'Other Skills'];
                $allSkills = [];
                foreach($types as $type) {
                    $typeSkills = $skills->where('type.value', $type);
                    if($typeSkills->count() > 0) {
                        $allSkills[] = ['type' => $type, 'items' => $typeSkills->all()];
                    }
                }
                $half = ceil(count($allSkills) / 2);
            @endphp
            <div class="skills-grid">
                <div class="skill-col">
                    @for($i = 0; $i < $half; $i++)
                        @if(isset($allSkills[$i]))
                        <div class="skill-block">
                            <div class="skill-title">{{ $allSkills[$i]['type'] }}</div>
                            <ul class="skill-list">
                                @foreach($allSkills[$i]['items'] as $skill)
                                    <li>• {{ $skill->languageName }}@if($skill->main) (Primary)@endif</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    @endfor
                </div>
                <div class="skill-col">
                    @for($i = $half; $i < count($allSkills); $i++)
                        <div class="skill-block">
                            <div class="skill-title">{{ $allSkills[$i]['type'] }}</div>
                            <ul class="skill-list">
                                @foreach($allSkills[$i]['items'] as $skill)
                                    <li>• {{ $skill->languageName }}@if($skill->main) (Primary)@endif</li>
                                @endforeach
                            </ul>
                        </div>
                    @endfor
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>

        <div class="section" style="clear: both;">
            <div class="section-title">Notable Projects</div>
            @foreach ($projects as $p)
                <div style="padding-top: 20px;">
                    <div class="item" style="padding-top: 0;">
                        <div class="item-title">{{ $p->name }}</div>
                        <div class="item-description">{{ $p->caption }}</div>
                        <div class="item-tech"><strong>Tech Stack:</strong> {{ $p->techmologyStack }}</div>
                        @if($p->appURL)<div class="item-tech"><strong>URL:</strong> {{ $p->appURL }}</div>@endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="section">
            <div class="section-title">Languages</div>
            @foreach ($sLanguages as $sl)
                <div class="lang-item">
                    <span class="lang-name">{{ $sl->languageName }}:</span>
                    <span class="lang-level">
                        @php
                            $level = match($sl->level) {
                                'Level 1' => 'Elementary',
                                'Level 2' => 'Low Intermediate',
                                'Level 3' => 'High Intermediate',
                                'Level 4' => 'Advanced',
                                'Level 5' => 'Native',
                                default => 'No Knowledge'
                            };
                        @endphp
                        {{ $level }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="footer">
        Generated on {{ date('F d, Y') }} | {{ $user->fullName }} - Professional CV
    </div>
</body>
</html>
