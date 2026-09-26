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

Three surfaces, one codebase: a Blade staff dashboard on the session guard, a resident mobile API on a JWT `residents` guard, and a gate-employee mobile API on its own JWT `api` guard — three audiences with two separate Laratrust permission catalogues (staff permissions and a resident catalogue keyed by guard, so the two can never collide), all over a single MySQL database.

Domain built: resident self-registration with a residency document and an admin approval queue; many-to-many resident-to-unit links across compounds, with family invitations and per-unit Primary/Member permission tiers held on the pivot; developers, compounds (country/city plus a Google Maps pin) and residential or commercial units with bilingual names and addresses; maintenance service requests with a role-gated status state machine, admin-managed categories, file attachments and an append-only timeline; visitor QR gate passes that residents generate and guards scan to record entry and exit, with the guard\'s operating compound assigned by an admin and derived server-side so a guard can only validate passes for their own gate; bookable amenities with per-weekday opening hours, maintenance blackouts and shared or exclusive slot capacity computed per slot; and a resident notification inbox fed by dashboard-authored announcements — targeted, bilingual and optionally illustrated.

Architecture: one strict layering for every feature — thin Controller, FormRequest, Service, Repository (interface bound to an Eloquent implementation), Model/Enum, Resource — with no query outside a repository. Services, requests and resources are split abstract-to-platform, with `Web` and `Mobile` concretes bound at boot to whichever declares the request\'s `X-Platform`. Every status, category and type is a PHP enum, and a status change is a state machine enforced in code rather than a free dropdown: a rejection requires a reason, a resolution captures a note, and both land in an append-only log. Routes are versioned in the URL so the two mobile clients can be evolved without breaking them.

In-project foundation (`App\\Blueprint`): a reusable base layer carrying the repository contract and its Eloquent base — a full CRUD and query surface driven by a `QueryReturnType` enum (get, first, paginate, cursor-paginate, pluck, count, exists, raw builder) — a BaseModel mixing in creator attribution, translatable fallback, soft deletes, human dates and a visibility scope; schema and query macros (`status()`, `audit()`, `fullAudit()`, `softDeletesWithUser()`, `phone()`, `price()`, `ordering()`, `byKeywords()`, `active()`, `search()`); a uniform `{status, message, data}` response envelope that framework exceptions are rendered into as well; a cached settings store whose secret values are write-only from outside; request-context logging taps; and custom Artisan generators — one command scaffolds an entire feature slice (model, repository pair, abstract plus platform service/request/resource, controllers and provider registrations), alongside a versioned seeder system with batched rollback modelled on migrations.

API conventions: a `{status, message, data}` envelope on every response including errors; list filters as per-field named scopes passed as `scopes[...]` and advertised per model, with a discovery endpoint so a client can ask what an entity accepts and anything unadvertised is rejected rather than executed; sibling unpaginated routes for pickers; `lang`-header localisation with translatable columns and fallback; UTC storage rendered in one configured display timezone; a health endpoint and a public settings catalogue outside the versioned surface. Both APIs ship as maintained Postman collections with local and production environments — the client-facing contract, kept in step with the FormRequest rules.

Security hardening (a four-phase remediation programme): a production boot guard that refuses to start with debug enabled; a least-privilege database user separated from root with no fallback defaults; dev-only services and the database port moved behind a local-only override file; secure session cookies, trusted hosts and forwarded-proxy handling, and a locked-down CORS policy; a container image that runs as a non-root user; rate limiting across the whole API (120/min per caller) with a tighter tier on every login, register and password-reset route (5/min per e-mail plus IP, 30/min per IP); password-reset OTPs that burn after five wrong guesses; fail-closed ownership checks; and a private-media overhaul that moved residency documents and request attachments off the public disk onto a disk with no public URL, reachable only through an authenticated route behind a fail-closed access guard that answers 404 rather than 403 so file ids cannot be probed, serving the stored mime with nosniff, a locked-down CSP and no-store.

Auditing and events: domain timelines are written synchronously by listeners into append-only tables, while the app-wide audit trail across all three guards and the console is queued — which makes the worker load-bearing, and a nightly prune keeps the table inside its retention window. Listener wiring is explicit with Laravel\'s auto-discovery switched off, because leaving both on registers every listener twice and silently doubles every row and every notification. Polymorphic columns store short aliases from a central morph map, so a model can be renamed or moved without orphaning its rows.

Notifications: an in-app inbox plus topic-based push behind a driver switch — a log driver that records what it would have sent, and Firebase Cloud Messaging HTTP v1 hand-rolled on Laravel\'s HTTP client with the Google OAuth assertion signed in-house rather than pulling the Firebase SDK. All three credentials are dashboard-editable settings with the private key write-only, so a client configures push without a file to deploy; a refused send is logged and swallowed, the inbox row already being written.

Dashboard: Blade with a component library (page heads, tables, filter bars, fields, pagination, empty states, status pills, translatable inputs) and one hand-written stylesheet — no utility framework and no build step, cache-busted from the file mtime, with the brand colours inlined from settings and every token derived from them. Arabic flips the whole interface through logical properties alone, with no direction overrides.

Operations: the whole stack is Docker Compose — app, nginx, MySQL, Redis, a queue worker, a scheduler, plus dev-only phpMyAdmin and Mailpit — bootstrapped by one setup script, with a separate production script that refuses to run against a local-looking environment and a Makefile wrapping every day-to-day task. Six per-concern daily log channels (application, notifications, requests, security, queue, debug), each with its own level and retention, every line carrying the request id, user and IP so one request stitches together across them. PHPStan/Larastan is kept at zero errors and Laravel Pint clean on every change; automated coverage is deliberately thin — unit tests over the secret-settings store and the push sender, with the HTTP surfaces exercised through the Postman collections.',
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
