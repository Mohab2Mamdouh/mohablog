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

Five self-contained modules, each with its own routes, providers and written spec: Authentication, Integration (Git connections), Server (SSH targets), Project (what to deploy, where and how) and Deployment (the execution engine).

Integrations: GitHub, GitLab and Bitbucket connect over OAuth through Socialite, behind one provider interface resolved by a factory — an abstract holds the shared flow and each concrete its own API, so a fourth provider is a class and an enum case. Repositories, branches and workspaces are pulled from each provider, normalised by transformers and cached in Redis, with a console command refreshing tokens before they expire. Servers go through one SSH client speaking two libraries — spatie/ssh for keys, phpseclib for passwords — both streaming output through a callback rather than buffering, with a connection test before every save and every deploy.

A project ties a repository to a server and a deploy path and holds the whole configuration: branch, PHP version, strategy, Docker compose file and services, shared-hosting web root, and per-stage hook commands. Strategies are an enum — basic, docker, and atomic declared but deliberately marked unavailable rather than half-built — and custom commands are injected at named lifecycle stages, with the stage list filtered to the ones the chosen strategy actually has.

The deploy script is generated fresh every run and never stored, branching on server type so a shared-hosting target gets its symlink step and a VPS does not. It is uploaded, made executable and run under a ten-minute timeout, each output line pushed to the browser over Server-Sent Events rather than a WebSocket server. The runner is written so it can never throw — it returns a structured result, and status and snapshot updates run whether the deploy passed or failed, so a crashed deploy cannot leave a record stuck at \'running\'. Each project also exposes an unauthenticated, rate-limited webhook whose signature is HMAC-verified per provider, with the secret stored encrypted and regenerable; a bad signature is 403, a push to a branch the project does not deploy a silent 200.

Architecture is a strict Controller to Service to Action to Repository layering across every module, with cross-module calls going service to service. The base classes — model, repository, response envelope, enum helpers — and the generator that scaffolds a versioned slice come from my own published Composer package. Everything is bilingual through a set of translation-automation scripts, and the stack runs in Docker with host ports auto-allocated so several instances coexist.',
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
