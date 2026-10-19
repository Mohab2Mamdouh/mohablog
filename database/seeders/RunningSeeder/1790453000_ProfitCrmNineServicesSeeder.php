<?php

namespace Database\Seeders\RunningSeeder;

use App\Enums\SkillType;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

/**
 * Brings Profit CRM up to date with the V6 work since the last update: the
 * fleet grew from seven to nine services (the MCP AI connector shipped and
 * a standalone Integrations service took Facebook lead ads plus WhatsApp),
 * and central gained v5 migration, impersonation and the web terminal.
 */
return new class extends Seeder
{
    public function run(): void
    {
        $this->updateProject();
        $this->addSkills();
    }

    private function updateProject(): void
    {
        Project::where('name', 'Profit CRM (Microservices)')->first()?->update([
            'caption'    => 'Multi-tenant CRM fleet: 9 Laravel microservices, event-driven over RabbitMQ, with a central control plane for SaaS and on-prem clients, a WhatsApp integration and an MCP AI connector. Status: Ongoing.',
            'tech_stack' => 'Laravel 12, PHP 8.5, Microservices, RabbitMQ, MySQL, Redis, Docker, Nginx, Supervisor, REST APIs, JWT, OAuth 2.1, Multi-Tenancy, Laratrust RBAC, Laravel Reverb, WebSockets, WhatsApp Cloud API, Model Context Protocol (MCP), MinIO/S3, FCM, SSH Automation, Let\'s Encrypt, Prometheus, Grafana, Loki, k6',
            'summary'    => 'Multi-tenant sales CRM rebuilt from a Laravel monolith into nine independent Laravel 12 services behind an API gateway, event-driven over 30+ RabbitMQ queues. Database-per-tenant isolation, a central control plane that provisions, migrates and licenses tenants for SaaS and on-prem clients, two-way WhatsApp chat over the Cloud API with live Reverb updates, and a read-only MCP server that lets Claude and ChatGPT query a user\'s own reports.',
            'description' => $this->description(),
        ]);
    }

    private function description(): string
    {
        return 'Profit CRM V6 — a multi-tenant sales CRM rebuilt from a Laravel monolith (v4/v5) into a fleet of nine independent Laravel 12 / PHP 8.5 services: an API gateway, a Central administration service, the Sales, Marketing, Inventory, Questionnaires and Files domain services, an Integrations service for Facebook lead ads and WhatsApp, and an MCP service that connects AI assistants — all sharing one Composer path package for the code that crosses service boundaries. Backend work only — the SPA is another team\'s.

Architecture: database-per-tenant multi-tenancy (stancl/tenancy) with domain resolution and per-tenant provisioning; JWT authentication (tymon/jwt-auth) with separate tenant and central guards; Laratrust RBAC extended with per-type and per-record permissions; a platform-aware layer that resolves WEB and MOBILE implementations of every Service, Request and Resource from an X-Platform header; and a strict Repository pattern so no service touches a model directly. Runs on Docker Compose behind Nginx and a production reverse proxy, with one overlay per licensed module, Supervisor-managed workers, Redis and php-fpm pools tuned to fit a 2-core box.

Shared contracts package: one Composer path package that every service installs and volume-mounts — the single home for anything that crosses a service boundary. It ships the typed HTTP service clients, the RabbitMQ publisher and consumer base classes, the import and export engines, the notification and audit-trail publishers, the shared middleware (rate limiting, localisation, request context, service-to-service auth, activity logging), a liveness endpoint registered into all nine services at once, phone-number and signed-file-URL helpers, the shared Arabic/English translation catalogue, and a set of custom Artisan generators — platform services, requests, resources, repositories, RabbitMQ consumers, and a versioned seeder system with batch rollback modelled on migrations. Adding a capability there reaches the whole fleet; it is what keeps nine services from growing nine copies of the same logic, and what let the two newest services ship without touching the other seven.

Central control plane (admin API): the tenant lifecycle end to end — create, block/unblock, soft-delete, restore, permanently drop, quota and licence expiry enforced as a block condition — over a dedicated `admin` JWT guard with its own admin and role management, its own audit trail and a Server-Sent Events stream that reports each provisioning step live. Tenant creation runs a job pipeline (create database, migrate, seed, create the admin user) and records status, step and error per tenant. Support staff can impersonate any user of any tenant: a reason-stamped, time-boxed session handed off through a one-time redeemable link code, whose id rides in the token so every log line in every service names the session — and for on-prem clients the token is minted on the client\'s own box over SSH, since only that box holds its signing secret.

v5 → V6 migration: a resumable, checkpointed pipeline (inspect, extract over SFTP, stage, transform, files, finalize) that moves a v5 tenant — on our host or a client\'s own server — into V6 as one more provisioning stage. The transform is 23 ordered, re-runnable steps that preserve v5 ids for users, leads, requests and logs, remap everything V6 seeds (states, questions, roles, permissions), convert Cairo wall-clock times to UTC with DST handled, and refuse up front any permission or log action the map does not know rather than failing an hour in; it ends with a reconciliation report, history verification and a permission diff.

On-prem client management: the same dashboard installs and operates Profit CRM on a client\'s own server over SSH (phpseclib) — host-key pinning, a generated managed key that replaces the typed credential, a per-box Bitbucket deploy key, a preflight of OS/Docker/Git/disk/RAM, a scripted install with Let\'s Encrypt certificate issuance and renewal, a verify pass and a durable run log per machine. Interrupted installs are recovered automatically, and installs can be cancelled, retried or fully uninstalled (restoring a v5 the install froze). On top of it: fleet-wide deploys dispatched as queued runs, remote power up/down, per-tenant licence and module sync, a phpMyAdmin console opened on the client\'s database through an SSH tunnel behind a one-time token, and a browser web terminal (WebSSH2) that issues a short-lived, restricted ed25519 key per session so an admin can open a shell or tail any run\'s log live without the managed key ever leaving central.

Licensing: a Pennant-shaped feature catalogue in the central schema — modules (whole services) and features (capabilities), a per-tenant grant list with a transitive dependency closure, a shared Redis-cached read path across all nine services, fail-closed `feature:` middleware on each service\'s route group, and a permission-blocking projection so the UI hides what was never sold.

AI connector (MCP): a read-only Model Context Protocol server, shipped as its own licensed service, that lets a user ask Claude, ChatGPT and other MCP clients about their own CRM. Streamable HTTP JSON-RPC exposing 40+ read-only tools — every sales and marketing report, lead and request search, request timelines, calendar, tasks, inventory matching, team trees, WhatsApp inboxes and exports — each calling the real V6 endpoint as the signed-in user, so validation, permissions, row-level scopes and field masking apply unchanged and nothing is reimplemented. The gateway acts as an OAuth 2.1 authorization server (RFC 8414/9728 discovery, PKCE, dynamic client metadata) for Claude.ai and ChatGPT, with hashed, expiring, revocable personal tokens for CLI clients, per-token rate limits and byte budgets, and an audit row per tool call.

WhatsApp integration: each salesman connects their own WhatsApp Business number through Meta\'s Embedded Signup in Coexistence mode, and every lead they own gets a two-way thread kept in sync with what they send from the CRM and from their phone. Meta webhooks are signature-checked, written to a central inbox and routed per phone number to the right tenant (SaaS or on-prem) over RabbitMQ; messages are de-duplicated by wamid, matched to leads by phone number across services, and media is downloaded on its own consumer so a large document never stalls chat. Sending covers text, media, location, replies and reactions inside the 24-hour window with retry and error translation; managers see their team\'s threads, a thread can be shared with salesmen on the same deal, and every message, read receipt and typing indicator reaches the browser live over Laravel Reverb WebSockets.

Asynchronous messaging: 30+ RabbitMQ queues (php-amqplib) driving activity logs, notifications, imports, exports, bulk actions, lead-ads ingestion, WhatsApp inbound, status and send, SMS/email campaigns and scheduled sweeps. Consumers were consolidated from 27 supervisor processes into 12 aggregate consumers, cutting worker memory from ~1.7 GB to ~770 MB.

Dynamic forms engine: every lead, request, inventory item, provider and state report is described by an admin-built questionnaire rather than fixed columns — 27 question types (text, select, multi-select, date, date range, map, phone, e-mail, price, counter, rich text, images, video, documents, 3D and 360 media), conditional questions nested under an option, per-question validation rules generated at runtime, uniqueness rules that drive lead duplicate detection, card/main field selection, media answers stored as files, and a cross-service answer filter and search used by every listing, export and bulk action.

Sales features: Lead ID tracking that grants chosen users the full history and info of the leads arriving through a tracked Lead ID without widening their role; lead-level history across every request with assignee masking; duplicate handling that folds empty requests away; and reports (salesmen performance, conversions, monthly trends) tuned with MySQL index hints.

Data in and out: a streaming export engine (XLSX via openspout, CSV, PDF via mPDF) covering 23 entities and 11 report matrices at constant memory — 200k rows in 36 MB where the previous pipeline exhausted 512 MB at 30k rows; a spreadsheet import engine (PhpSpreadsheet) for leads and providers with fuzzy header matching, batched cross-service validation, Excel date/coordinate/range cell normalisation, media fetched by share link, global-error detection and annotated reject files; and per-tenant database backups (scheduled or on demand, local disk or the tenant\'s own Dropbox, retention pruning) with a synchronous restore that re-imports the dump, migrates and re-seeds it to the current codebase, then flushes the tenant cache across every service behind a per-tenant lock.

Also built: push notifications on Firebase Cloud Messaging HTTP v1 with durable per-user rows, device-token and topic addressing and per-type TTLs; a cross-service audit trail on spatie/laravel-activitylog published over RabbitMQ and resolved to human-readable record names, now covering file removals; user blocking enforced by middleware across the fleet; Facebook Lead Ads integration (OAuth, webhooks, Graph API) with Conversions API quality feedback, moved into the Integrations service; and bulk SMS/e-mail campaigns across five SMS gateways and per-tenant SMTP.

Observability and logging: dedicated log channels (rabbitmq, import, export, restore, notification, deployment, integrations, mcp, slow queries, debug, daily) plus an edge-minted correlation id that nginx, PHP and every RabbitMQ envelope carry, so one id greps a request across every hop of the fleet. An opt-in Prometheus + Grafana + Loki + Alertmanager + Alloy stack scrapes and probes every service, alerts on MCP tool failures among its rules, ships provisioned dashboards and Discord alerting, with per-endpoint latency and active-user analytics derived from the nginx JSON access logs and k6 load tests for capacity work.';
    }

    private function addSkills(): void
    {
        $skills = [
            ['WhatsApp Cloud API',              SkillType::Backend, true],
            ['Laravel Reverb',                  SkillType::Backend, false],
            ['WebSockets',                      SkillType::Backend, false],
            ['OAuth 2.1 Authorization Server',  SkillType::Backend, false],
            ['AI Integration (MCP)',            SkillType::Backend, true],
            ['Data Migration (ETL)',            SkillType::Backend, false],
            ['Let\'s Encrypt / TLS',            SkillType::OtherSkills, false],
        ];

        foreach ($skills as [$name, $type, $main]) {
            Skill::firstOrCreate(
                ['languageName' => $name],
                ['type' => $type->value, 'main' => $main]
            );
        }
    }
};
