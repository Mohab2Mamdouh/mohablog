<?php

namespace Database\Seeders\RunningSeeder;

use App\Enums\SkillType;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    private const PROJECT = 'Community Management';

    public function run(): void
    {
        $this->makeRoom();
        $this->upsertProject();
        $this->addSkills();
    }

    private function makeRoom(): void
    {
        if (Project::where('name', self::PROJECT)->exists()) {
            return;
        }

        Project::where('order', '>=', 2)->increment('order');
    }

    private function upsertProject(): void
    {
        Project::updateOrCreate(
            ['name' => self::PROJECT],
            [
                'url'             => 'https://bitbucket.org/m7_esmaar/cm-backend',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'Community-management platform for a real-estate developer — one Laravel 12 backend serving a staff dashboard and two mobile APIs. Status: Ongoing.',
                'order'           => 2,
                'show_at_cv'      => true,
                'endDate'         => null,
                'techmologyStack' => 'Laravel 12, PHP 8.3, MySQL 8, Redis, Docker, Nginx, Supervisor, REST APIs, JWT, Laratrust RBAC, Blade, Spatie Media Library, Spatie Translatable, Firebase (FCM), PHPStan, Laravel Pint',
                'description'     => 'A community-management platform for a real-estate developer company. A developer owns compounds; each compound has units, amenities, residents and staff. The core loop: a resident raises a request, a gate pass or an amenity booking, and staff validate it and carry it through to resolution.

Three surfaces from one codebase: a Blade staff dashboard on the session guard, a resident mobile API on a JWT guard, and a gate-employee mobile API on its own — three audiences with two separate permission catalogues over a single MySQL database.

Domain: resident self-registration with a residency document and an approval queue; many-to-many resident-to-unit links across compounds with family invitations and per-unit Primary/Member tiers; compounds and units with bilingual fields and a Maps pin; maintenance requests with a role-gated status state machine, attachments and an append-only timeline; visitor QR gate passes that residents generate and guards scan, with the guard\'s compound assigned by an admin and derived server-side; bookable amenities with weekday hours, maintenance blackouts and shared or exclusive slot capacity; and a resident inbox fed by targeted bilingual announcements.

Architecture: one strict layering — thin Controller, FormRequest, Service, Repository, Model/Enum, Resource — with no query outside a repository, and services, requests and resources split into Web and Mobile concretes bound from an X-Platform header. Every status is an enum and every status change a state machine enforced in code. Underneath sits a reusable in-project foundation carrying the repository base and its query-return enum, a BaseModel with shared traits, schema and query macros, a uniform response envelope, a cached settings store with encrypted secrets, and generators that scaffold a whole feature slice plus versioned seeders with batched rollback.

Platform: filters as named scopes advertised per model and discoverable by clients, so nothing unadvertised is executable; an app-wide audit trail across all three guards written off a queued listener with a nightly prune; polymorphic columns stored as short aliases so a model can be renamed without orphaning rows; in-app notifications plus topic-based Firebase push with the Google OAuth assertion signed in-house and credentials held as write-only settings; E.164 phones; UTC storage with one display timezone.

Security was a four-phase hardening programme: a production boot guard, a least-privilege database user, secure cookies, trusted hosts and locked-down CORS, a non-root container, rate limiting across the API with a tighter tier on every auth route, OTPs that burn after five wrong guesses, and moving residency documents and request attachments onto a private disk behind a fail-closed guard that answers 404 rather than 403 so file ids cannot be probed.

Operations: Docker Compose (app, nginx, MySQL, Redis, queue worker, scheduler), one setup script and a production script that refuses a local-looking environment, six per-concern daily log channels each carrying the request id so one request stitches across them, and PHPStan and Pint kept clean on every change.',
            ]
        );
    }

    private function addSkills(): void
    {
        $skills = [
            ['Multi-Guard Authentication', SkillType::Backend, false],
            ['State Machine Design',       SkillType::Backend, false],
            ['API Versioning',             SkillType::Backend, false],
            ['OTP Authentication',         SkillType::Backend, false],
            ['Spatie Media Library',       SkillType::Backend, false],
            ['Google Maps API',            SkillType::Backend, false],
            ['QR Code Access Control',     SkillType::Backend, false],
            ['Security Hardening',         SkillType::Backend, true],
            ['PHPStan / Larastan',         SkillType::OtherSkills, false],
            ['Laravel Pint',               SkillType::OtherSkills, false],
            ['Mailpit',                    SkillType::OtherSkills, false],
        ];

        foreach ($skills as [$name, $type, $main]) {
            Skill::firstOrCreate(
                ['languageName' => $name],
                ['type' => $type->value, 'main' => $main]
            );
        }
    }
};
