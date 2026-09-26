<?php

namespace Database\Seeders\RunningSeeder;

use App\Enums\SkillType;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    private const PROJECT = 'DeployMate';

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

        Project::where('order', '>=', 4)->increment('order');
    }

    private function upsertProject(): void
    {
        Project::updateOrCreate(
            ['name' => self::PROJECT],
            [
                'url'             => 'https://github.com/Mohab2Mamdouh/DeployMate',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'Self-hosted deployment tool — connects a Git provider to a server over SSH, generates the deploy script and streams the run back live.',
                'order'           => 4,
                'show_at_cv'      => true,
                'endDate'         => '2026-06-20',
                'techmologyStack' => 'Laravel 12, PHP 8.4, MySQL 8, Redis, Docker, Nginx, Blade, Laravel Modules, Laratrust, Laravel Socialite, phpseclib, spatie/ssh, Server-Sent Events, Webhooks, Tailwind, Vite',
                'description'     => 'A self-hosted deployment management tool — the part of Envoyer or Forge a small team actually needs, running on their own box. It connects to a Git provider, links a repository to a target server, generates the deploy script, SSHes in to run it, and streams the output back to the browser live. Open source under MIT; 173 commits over six months.

Five self-contained modules (nwidart/laravel-modules), each with its own routes, providers and written spec: **Authentication**, **Integration** (Git provider connections), **Server** (SSH targets), **Project** (what to deploy, where and how) and **Deployment** (the execution engine). Shared code in the root application is limited to users, roles and permissions.

Integrations: GitHub, GitLab and Bitbucket connect over OAuth through Laravel Socialite, behind one `GitProviderInterface` resolved by a factory — an abstract provider holds the shared flow and each concrete one its own API, so adding a fourth provider is a class and an enum case. Repositories, branches and workspaces are pulled from each provider\'s API through dedicated actions, normalised by transformers and cached in Redis, and a console command refreshes tokens before they expire.

Servers: a target is registered with its host, credentials and type, and every connection goes through one SSH client that speaks two libraries — spatie/ssh for key authentication and phpseclib for password authentication — both streaming stdout and stderr back through a callback rather than buffering. A connection test runs before a server is saved and again before every deploy, and the server\'s reachability is tracked as a status.

Projects: a project ties an integration and a repository to a server and a deploy path, and holds the whole deployment configuration — branch, PHP version, deployment strategy, Docker compose file and target services, the shared-hosting web root, and per-stage hook commands. Strategies are an enum: `basic` (pull in place), `docker` (compose build and up) and `atomic` (symlinked releases, declared and deliberately marked unavailable rather than half-built). Custom commands are injected at named lifecycle stages — after pull, after build, after up, after migrate, after cache, after deploy — with the stage list filtered to the ones the chosen strategy actually has.

The deploy script is **generated fresh on every run and never stored**, branching on the server type so a shared-hosting target gets its `public_html` symlink step and a VPS does not. It is uploaded to the server, made executable and run under a ten-minute timeout, with each output line pushed to the browser over Server-Sent Events — a `StreamedResponse`, not a WebSocket server — and appended to a log buffer at the same time. The runner is written so it can never throw: it returns a structured result, and status and project-snapshot updates run whether the deploy succeeded or failed, so a crashed deploy can never leave a record stuck at "running".

Webhooks: each project exposes an unauthenticated, rate-limited endpoint that Git providers POST to on push. The signature is HMAC-verified per provider — GitHub\'s `X-Hub-Signature-256`, GitLab\'s token header, Bitbucket\'s token — with the secret stored as an encrypted column and regenerable from the UI; a bad signature is 403, while a push to a branch the project does not deploy is a silent 200 rather than an error. A verified push triggers the same deploy path as the manual button. Deployment records are immutable history — status, trigger, full log, duration — and cascade with their project.

Architecture: a strict Controller → Service → Action → Repository → Model layering enforced across every module, where a controller calls only its own service, actions are single-responsibility units with one `handle()` method, and every query goes through a repository interface bound per module. Cross-module calls go service to service, never into another module\'s controllers. The base classes — model, repository, response envelope, enum helpers — come from **my own published Composer package**, `mohab/laravel-blueprint`, which also ships the generator that scaffolds a versioned service, repository pair and controller in one command, and its own translation namespace.

Everything is bilingual (Arabic/English) through spatie/laravel-translatable plus a set of translation-automation scripts that find untranslated keys, translate them and write them back, wired into a single `make translate`. Roles and permissions are Laratrust. The whole stack runs in Docker with host ports auto-allocated in a range and saved to a dotfile so several of these can run side by side, driven by a Makefile, and the repository ships an architecture, API, user and deployment guide alongside a per-module rules file that is the source of truth for that module\'s contracts.',
            ]
        );
    }

    private function addSkills(): void
    {
        $skills = [
            ['Laravel Socialite',            SkillType::Backend, false],
            ['HMAC Signature Verification',  SkillType::Backend, false],
            ['GitHub API',                   SkillType::Backend, false],
            ['GitLab API',                   SkillType::Backend, false],
            ['Deployment Automation',        SkillType::OtherSkills, true],
            ['CI/CD',                        SkillType::OtherSkills, false],
        ];

        foreach ($skills as [$name, $type, $main]) {
            Skill::firstOrCreate(
                ['languageName' => $name],
                ['type' => $type->value, 'main' => $main]
            );
        }
    }
};
