<?php

namespace Database\Seeders\RunningSeeder;

use App\Models\Project;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    public function run(): void
    {
        $descriptions = [
            'Community Management' => 'A community-management platform for a real-estate developer company. A developer owns compounds; each compound has units, amenities, residents and staff. The core loop: a resident raises a request, a gate pass or an amenity booking, and staff validate it and carry it through to resolution.

Three surfaces from one codebase: a Blade staff dashboard on the session guard, a resident mobile API on a JWT guard, and a gate-employee mobile API on its own — three audiences with two separate permission catalogues over a single MySQL database.

Domain: resident self-registration with a residency document and an approval queue; many-to-many resident-to-unit links across compounds with family invitations and per-unit Primary/Member tiers; compounds and units with bilingual fields and a Maps pin; maintenance requests with a role-gated status state machine, attachments and an append-only timeline; visitor QR gate passes that residents generate and guards scan, with the guard\'s compound assigned by an admin and derived server-side; bookable amenities with weekday hours, maintenance blackouts and shared or exclusive slot capacity; and a resident inbox fed by targeted bilingual announcements.

Architecture: one strict layering — thin Controller, FormRequest, Service, Repository, Model/Enum, Resource — with no query outside a repository, and services, requests and resources split into Web and Mobile concretes bound from an X-Platform header. Every status is an enum and every status change a state machine enforced in code. Underneath sits a reusable in-project foundation carrying the repository base and its query-return enum, a BaseModel with shared traits, schema and query macros, a uniform response envelope, a cached settings store with encrypted secrets, and generators that scaffold a whole feature slice plus versioned seeders with batched rollback.

Platform: filters as named scopes advertised per model and discoverable by clients, so nothing unadvertised is executable; an app-wide audit trail across all three guards written off a queued listener with a nightly prune; polymorphic columns stored as short aliases so a model can be renamed without orphaning rows; in-app notifications plus topic-based Firebase push with the Google OAuth assertion signed in-house and credentials held as write-only settings; E.164 phones; UTC storage with one display timezone.

Security was a four-phase hardening programme: a production boot guard, a least-privilege database user, secure cookies, trusted hosts and locked-down CORS, a non-root container, rate limiting across the API with a tighter tier on every auth route, OTPs that burn after five wrong guesses, and moving residency documents and request attachments onto a private disk behind a fail-closed guard that answers 404 rather than 403 so file ids cannot be probed.

Operations: Docker Compose (app, nginx, MySQL, Redis, queue worker, scheduler), one setup script and a production script that refuses a local-looking environment, six per-concern daily log channels each carrying the request id so one request stitches across them, and PHPStan and Pint kept clean on every change.',

            'DeployMate' => 'A self-hosted deployment management tool — the part of Envoyer or Forge a small team actually needs, running on their own box. It connects to a Git provider, links a repository to a target server, generates the deploy script, SSHes in to run it, and streams the output back to the browser live. Open source under MIT; 173 commits over six months.

Five self-contained modules, each with its own routes, providers and written spec: Authentication, Integration (Git connections), Server (SSH targets), Project (what to deploy, where and how) and Deployment (the execution engine).

Integrations: GitHub, GitLab and Bitbucket connect over OAuth through Socialite, behind one provider interface resolved by a factory — an abstract holds the shared flow and each concrete its own API, so a fourth provider is a class and an enum case. Repositories, branches and workspaces are pulled from each provider, normalised by transformers and cached in Redis, with a console command refreshing tokens before they expire. Servers go through one SSH client speaking two libraries — spatie/ssh for keys, phpseclib for passwords — both streaming output through a callback rather than buffering, with a connection test before every save and every deploy.

A project ties a repository to a server and a deploy path and holds the whole configuration: branch, PHP version, strategy, Docker compose file and services, shared-hosting web root, and per-stage hook commands. Strategies are an enum — basic, docker, and atomic declared but deliberately marked unavailable rather than half-built — and custom commands are injected at named lifecycle stages, with the stage list filtered to the ones the chosen strategy actually has.

The deploy script is generated fresh every run and never stored, branching on server type so a shared-hosting target gets its symlink step and a VPS does not. It is uploaded, made executable and run under a ten-minute timeout, each output line pushed to the browser over Server-Sent Events rather than a WebSocket server. The runner is written so it can never throw — it returns a structured result, and status and snapshot updates run whether the deploy passed or failed, so a crashed deploy cannot leave a record stuck at \'running\'. Each project also exposes an unauthenticated, rate-limited webhook whose signature is HMAC-verified per provider, with the secret stored encrypted and regenerable; a bad signature is 403, a push to a branch the project does not deploy a silent 200.

Architecture is a strict Controller to Service to Action to Repository layering across every module, with cross-module calls going service to service. The base classes — model, repository, response envelope, enum helpers — and the generator that scaffolds a versioned slice come from my own published Composer package. Everything is bilingual through a set of translation-automation scripts, and the stack runs in Docker with host ports auto-allocated so several instances coexist.',
        ];

        foreach ($descriptions as $name => $description) {
            Project::where('name', $name)->update(['description' => $description]);
        }
    }
};
