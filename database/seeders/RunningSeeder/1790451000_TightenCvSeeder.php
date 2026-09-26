<?php

namespace Database\Seeders\RunningSeeder;

use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    public function run(): void
    {
        $this->tightenProjects();
        $this->pruneSkills();
        $this->setMainSkills();
    }

    private function tightenProjects(): void
    {
        $projects = [
            'Profit CRM (Microservices)' => [
                'caption'     => 'Multi-tenant CRM fleet: seven Laravel microservices, event-driven over RabbitMQ, with a central control plane for SaaS and on-prem clients. Status: Ongoing.',
                'description' => 'Profit CRM V6 — a multi-tenant sales CRM rebuilt from a Laravel monolith into seven independent Laravel 12 / PHP 8.5 services behind an API gateway, sharing one Composer package for everything that crosses a service boundary. Backend work only.

Database-per-tenant multi-tenancy, JWT with separate tenant and central guards, Laratrust RBAC down to per-record permissions, and a strict repository layer. Services talk over 30+ RabbitMQ queues — activity logs, notifications, imports, exports, bulk actions, lead-ads ingestion, SMS and e-mail campaigns — and I consolidated 27 consumer processes into 12, cutting worker memory from ~1.7 GB to ~770 MB.

Built on top: a questionnaire engine where every record\'s fields are admin-defined (27 question types, conditional questions, validation generated at runtime); streaming XLSX/CSV/PDF exports at constant memory — 200k rows in 36 MB; a spreadsheet import pipeline; per-tenant backup and restore; Firebase push; a Pennant-shaped licensing layer; and a central control plane that provisions tenants and installs the stack on a client\'s own server over SSH. Next: a read-only MCP server exposing the reporting surface to AI clients.',
            ],

            'Community Management' => [
                'description' => 'A community-management platform for a real-estate developer: compounds, units, amenities, residents and staff, where a resident raises a request, a gate pass or an amenity booking and staff carry it through to resolution.

One Laravel 12 deployment serves three surfaces — a Blade staff dashboard on the session guard, a resident mobile API and a gate-employee mobile API each on its own JWT guard — with two separate permission catalogues over a single database.

Built: resident registration with document approval, many-to-many resident-to-unit links with per-unit permission tiers, maintenance requests on a role-gated state machine, QR visitor passes scanned at the gate, bookable amenities with blackouts and slot capacity, and a bilingual announcement inbox with Firebase push written without the SDK.

Underneath sits a reusable in-project foundation — repository base, macros, response envelope, encrypted settings store, slice generators — plus a four-phase security hardening pass covering rate limiting, OTP lockout and private media behind a fail-closed access guard.',
            ],

            'DeployMate' => [
                'description' => 'A self-hosted deployment tool — the part of Envoyer or Forge a small team actually needs, running on their own box. It connects a Git provider to a target server, generates the deploy script, SSHes in to run it and streams the output back live. MIT, 173 commits.

Five modules: Git integrations over OAuth for GitHub, GitLab and Bitbucket behind one provider interface resolved by a factory; SSH targets reached through a client speaking both spatie/ssh and phpseclib; projects holding branch, strategy, Docker config and per-stage hook commands; and the execution engine.

The deploy script is generated fresh every run and never stored, branching on VPS versus shared hosting, and output streams to the browser over Server-Sent Events rather than a WebSocket server. The runner is written so it cannot throw, so a crashed deploy never leaves a record stuck at \'running\'. Push webhooks are HMAC-verified per provider. The base classes come from my own published Composer package.',
            ],

            'Laravel Blueprint' => [
                'description' => 'My own published Composer package — the application foundation three of my other projects run on: DeployMate takes it as a dependency, while Anageet and Community Management vendor it in.

It ships a repository contract and Eloquent base giving every entity a full query surface selected through a return-type enum, a BaseModel with eleven opt-in traits, a uniform response envelope, cache, log, mail and push helpers, a complete settings module, and schema and query macros — so none of that is rewritten per project.

Scaffolding is the point of it: one command generates a versioned service, repository pair and controller from stubs the package owns, and a tracked-seeder system gives data the same timestamped, run-once discipline migrations give schema. Published under MIT, installable by path or private VCS repository.',
            ],

            'Laravel Chatbot' => [
                'description' => 'My own Composer package, built around one idea: an LLM call costs money and latency, so answer from your own data first.

A message runs through intent detection and resolves in two free tiers before the paid one — registered report closures answer factual questions straight from the database, anything else goes to Laravel Scout so the host application\'s searchable models are queried through Elasticsearch, and only when both come back empty is Groq called. Every response declares which tier produced it, so a deployment\'s cost profile is visible rather than guessed at.

It is entirely config-driven and ships nothing application-specific: the host registers its own models, report closures and intent keywords, and tunes the model, token budget and history depth. One rate-limited endpoint, multi-turn by passing the transcript. MIT.',
            ],

            'Tracker' => [
                'description' => 'A time-tracking, earnings and invoicing tool for my own contracting work, built around a hard constraint: it had to run on cheap shared hosting with no database server and no build step. It is one HTML page, one PHP API and a SQLite file the API creates and migrates itself on first request.

It was then rewritten in Go — a single binary speaking the identical API against the identical database with the frontend embedded inside it, so moving from shared hosting to a VPS is copying one file across. Both backends are kept working against the same schema.

Projects carry their own hourly rates, a live timer survives a page reload, a payments ledger tracks what is still owed all-time per project, and invoices print from whatever is currently filtered. The password is verified server-side on every request, and hiding money on screen re-asks for it before revealing.',
            ],

            'Anageet' => [
                'description' => 'A multi-tenant attendance and workforce-management platform: a REST API for the Flutter app plus a Blade dashboard, where each customer company is a tenant with its own isolated database identified by domain. A company self-registers and a queued pipeline provisions it end to end.

Built: geofenced clock in and out with lateness and overtime derived against each employee\'s work schedule, excuses and temporary exits with approval workflows, vacations with a balance engine over separate ordinary and casual buckets, and field missions with live-location requests.

Employment is modelled as Type-2 history — one current row per employee, and a new one closes the last — so promotions, transfers and re-hires form a continuous timeline, and the reporting line is a recursive manager tree guarded against cycles. Reports export to Excel and PDF; notifications go in-app, over Reverb and as Firebase push.',
            ],
        ];

        foreach ($projects as $name => $attributes) {
            Project::where('name', $name)->update($attributes);
        }
    }

    private function pruneSkills(): void
    {
        Skill::whereIn('languageName', [
            // over-granular — covered by a broader skill already listed
            'Custom Artisan Commands', 'Service-to-Service Auth', 'Tenant Provisioning',
            'Backup & Restore', 'Spreadsheet Import Pipeline', 'Centralized Logging',
            'Rate Limiting', 'Queue Workers', 'Task Scheduling', 'API Versioning',
            'OTP Authentication', 'Multi-Guard Authentication', 'HMAC Signature Verification',
            'API Gateway', 'PhpSpreadsheet', 'Modular Architecture', 'API Development',
            // libraries thin enough to be implied by what they serve
            'Spatie Activity Log', 'OpenSpout', 'mPDF', 'libphonenumber', 'Laravel Excel',
            'Laravel Reverb', 'Laravel Socialite', 'Spatie Media Library', 'Laravel Breeze',
            'Guzzle HTTP',
            // single integrations, not skills
            'Meta Conversions API', 'Dropbox API', 'Bitbucket API', 'GitLab API', 'GitHub API',
            'SMTP / Mail Transport', 'JSON-RPC', 'Google Maps API', 'QR Code Access Control',
            'Telegram API', 'Geolocation & Geofencing',
            // tooling trivia
            'Docker Compose', 'Supervisor', 'Bitbucket', 'Laravel Pint',
            'Mailpit', 'phpMyAdmin', 'NPM',
            // frontend I do not claim
            'C3.js', 'Shadcn UI', 'Alpine.js', 'Inertia.js',
        ])->delete();
    }

    private function setMainSkills(): void
    {
        $main = [
            'PHP', 'Laravel', 'REST APIs', 'MySQL', 'Docker', 'Git',
            'Microservices', 'RabbitMQ', 'Multi-Tenancy',
            'Event-Driven Architecture', 'Clean Architecture', 'AI / LLM Integration',
        ];

        Skill::query()->update(['main' => false]);
        Skill::whereIn('languageName', $main)->update(['main' => true]);
    }
};
