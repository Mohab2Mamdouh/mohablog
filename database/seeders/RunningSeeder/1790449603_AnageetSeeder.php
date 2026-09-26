<?php

namespace Database\Seeders\RunningSeeder;

use App\Enums\SkillType;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    private const PROJECT = 'Anageet';

    public function run(): void
    {
        if (! Project::where('name', self::PROJECT)->exists()) {
            Project::where('order', '>=', 8)->increment('order');
        }

        Project::updateOrCreate(
            ['name' => self::PROJECT],
            [
                'url'             => 'https://github.com/Mohab2Mamdouh/anaget_backend',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'Multi-tenant attendance and workforce-management platform — REST API for a Flutter app plus a Blade dashboard, database per company.',
                'order'           => 8,
                'show_at_cv'      => false,
                'endDate'         => '2026-08-30',
                'techmologyStack' => 'Laravel 12, PHP 8.3, MySQL, Redis, Docker, stancl/tenancy, JWT, Laratrust, Laravel Reverb, Laravel Excel, DomPDF, S3/MinIO, Spatie Activitylog, Blade',
                'description'     => 'A multi-tenant attendance and workforce-management platform: a REST API for the Flutter mobile app plus a Blade admin dashboard, where every customer company is a tenant with its own isolated database, identified by domain (stancl/tenancy). A company self-registers through a public sign-up flow and a queued pipeline provisions it — creating the database, migrating it, seeding roles, permissions and default settings, and creating the owner admin — with an approval status gating access until it is activated.

Attendance and time off: geofenced clock in and out with lateness and overtime derived against the employee\'s work schedule and a monthly brief; excuses and temporary exits with their own types and an approval workflow; vacations with a balance engine holding separate ordinary and casual buckets under both yearly and monthly limits; and field missions recording actual start and end with live-location requests.

Organisation: companies, departments, administrations, shifts, teams, jobs, titles, contract types, work schedules, weekends and official holidays, all bilingual tenant lookups. Employment is modelled as **Type-2 history** — exactly one current row per employee, and creating a new one closes the previous with an effective-to date and a change reason, so promotions, transfers, salary changes and re-hires form one continuous timeline instead of overwriting each other. The reporting line is a self-referencing manager column read through recursive relationships, guarded against self-assignment and cycles.

Platform: JWT for mobile and session auth for the dashboard, with Laratrust roles and permissions grouped for the UI; notifications delivered in-app, as Firebase push and over Laravel Reverb for live dashboard updates; reports across attendance, vacations, missions, lateness, overtime and employees, exported to Excel and PDF; per-tenant branding where the company\'s primary colour overrides the palette and the logo and favicon render through the shell, with media on the public disk locally or S3/MinIO with a per-tenant prefix; an activity log; and the same in-project Blueprint foundation — repository and service layering, base model, macros and response envelope — that my other projects share. The whole stack runs in Docker Compose: app, nginx, MySQL, Redis, a queue worker, a scheduler, the Reverb server, node, Mailpit and phpMyAdmin.',
            ]
        );

        $skills = [
            ['Laravel Reverb',           SkillType::Backend, false],
            ['Laravel Excel',            SkillType::Backend, false],
            ['Geolocation & Geofencing', SkillType::Backend, false],
        ];

        foreach ($skills as [$name, $type, $main]) {
            Skill::firstOrCreate(['languageName' => $name], ['type' => $type->value, 'main' => $main]);
        }
    }
};
