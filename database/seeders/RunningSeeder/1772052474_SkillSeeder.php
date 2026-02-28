<?php

namespace Database\Seeders\RunningSeeder;

use App\Enums\SkillType;
use App\Models\Skill;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    public function run(): void
    {
        $skills = [
            // ── Backend ──────────────────────────────────────────────────────
            ['languageName' => 'PHP',                       'type' => SkillType::Backend->value,         'main' => true],
            ['languageName' => 'Laravel',                   'type' => SkillType::Backend->value,         'main' => true],
            ['languageName' => 'REST APIs',                 'type' => SkillType::Backend->value,         'main' => true],
            ['languageName' => 'API Development',           'type' => SkillType::Backend->value,         'main' => false],
            ['languageName' => 'Laravel Queues',            'type' => SkillType::Backend->value,         'main' => false],
            ['languageName' => 'Modular Architecture',      'type' => SkillType::Backend->value,         'main' => false],
            ['languageName' => 'Livewire',                  'type' => SkillType::Backend->value,         'main' => false],
            ['languageName' => 'Laravel Sanctum',           'type' => SkillType::Backend->value,         'main' => false],
            ['languageName' => 'Laravel Scout',             'type' => SkillType::Backend->value,         'main' => false],
            ['languageName' => 'Laravel Events',            'type' => SkillType::Backend->value,         'main' => false],
            ['languageName' => 'Websockets',                'type' => SkillType::Backend->value,         'main' => false],
            // NEW — found across repos
            ['languageName' => 'Micro-services',            'type' => SkillType::Backend->value,         'main' => false], // micro-service, Notification-Bus-Micro-service
            ['languageName' => 'Laravel Breeze',            'type' => SkillType::Backend->value,         'main' => false], // CRM composer.json
            ['languageName' => 'Spatie Permissions',        'type' => SkillType::Backend->value,         'main' => false], // CRM: spatie/laravel-permission
            ['languageName' => 'Spatie Translatable',       'type' => SkillType::Backend->value,         'main' => false], // HR-Module, Albaraka-insfund
            ['languageName' => 'Laravel Modules (nwidart)', 'type' => SkillType::Backend->value,         'main' => false], // CRM, HR-Module, Albaraka-insfund, Base-Structure
            ['languageName' => 'Laratrust',                 'type' => SkillType::Backend->value,         'main' => false], // Albaraka-insfund: santigarcor/laratrust
            ['languageName' => 'Guzzle HTTP',               'type' => SkillType::Backend->value,         'main' => false], // mohablog: guzzlehttp/guzzle
            ['languageName' => 'PDF Generation',            'type' => SkillType::Backend->value,         'main' => false], // mohablog: barryvdh/laravel-dompdf
            ['languageName' => 'PHPUnit',                   'type' => SkillType::Backend->value,         'main' => false], // All Laravel repos
            ['languageName' => 'Telegram API',              'type' => SkillType::Backend->value,         'main' => false], // TrackProduct

            // ── Frontend ─────────────────────────────────────────────────────
            ['languageName' => 'JavaScript',                'type' => SkillType::Frontend->value,        'main' => false],
            ['languageName' => 'HTML',                      'type' => SkillType::Frontend->value,        'main' => false],
            ['languageName' => 'CSS',                       'type' => SkillType::Frontend->value,        'main' => false],
            ['languageName' => 'Bootstrap',                 'type' => SkillType::Frontend->value,        'main' => false],
            ['languageName' => 'Tailwind CSS',              'type' => SkillType::Frontend->value,        'main' => false],
            ['languageName' => 'Blade',                     'type' => SkillType::Frontend->value,        'main' => false],
            ['languageName' => 'Chart.js',                  'type' => SkillType::Frontend->value,        'main' => false],
            ['languageName' => 'C3.js',                     'type' => SkillType::Frontend->value,        'main' => false],
            ['languageName' => 'Vite',                      'type' => SkillType::Frontend->value,        'main' => false],
            ['languageName' => 'Shadcn UI',                 'type' => SkillType::Frontend->value,        'main' => false],
            ['languageName' => 'Alpine.js',                 'type' => SkillType::Frontend->value,        'main' => false],
            ['languageName' => 'Inertia.js',                'type' => SkillType::Frontend->value,        'main' => false], // CRM composer.json

            // ── Database ─────────────────────────────────────────────────────
            ['languageName' => 'MySQL',                     'type' => SkillType::Database->value,        'main' => true],
            ['languageName' => 'phpMyAdmin',                'type' => SkillType::Database->value,        'main' => false],
            ['languageName' => 'Redis',                     'type' => SkillType::Database->value,        'main' => false],
            ['languageName' => 'SQLite',                    'type' => SkillType::Database->value,        'main' => false],

            // ── Dev Tools ────────────────────────────────────────────────────
            ['languageName' => 'Git',                       'type' => SkillType::OtherSkills->value,     'main' => true],
            ['languageName' => 'GitHub',                    'type' => SkillType::OtherSkills->value,     'main' => false],
            ['languageName' => 'Docker',                    'type' => SkillType::OtherSkills->value,     'main' => true],
            ['languageName' => 'Postman',                   'type' => SkillType::OtherSkills->value,     'main' => false],
            ['languageName' => 'Composer',                  'type' => SkillType::OtherSkills->value,     'main' => false],
            ['languageName' => 'NPM',                       'type' => SkillType::OtherSkills->value,     'main' => false],
            ['languageName' => 'Nginx',                     'type' => SkillType::OtherSkills->value,     'main' => false],
            // NEW — found across repos

            // ── Prior Knowledge ──────────────────────────────────────────────
            ['languageName' => 'WordPress',                 'type' => SkillType::PriorKnowledge->value,  'main' => false],
            ['languageName' => 'RabbitMQ',                  'type' => SkillType::PriorKnowledge->value,  'main' => false],
            ['languageName' => 'Kafka',                     'type' => SkillType::PriorKnowledge->value,  'main' => false],


            // ── Little Knowledge ─────────────────────────────────────────────
            ['languageName' => 'AJAX',                      'type' => SkillType::LittleKnowledge->value, 'main' => false],
            ['languageName' => 'jQuery',                    'type' => SkillType::LittleKnowledge->value, 'main' => false],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(
                ['languageName' => $skill['languageName']],
                ['type' => $skill['type'], 'main' => $skill['main']]
            );
        }
    }
};
