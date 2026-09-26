<?php

namespace Database\Seeders\RunningSeeder;

use App\Models\Project;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    public function run(): void
    {
        Project::where('name', 'Profit CRM (Microservices)')
            ->update(['description' => 'Profit CRM V6 — a multi-tenant sales CRM rebuilt from a Laravel monolith (v4/v5) into a fleet of seven independent Laravel 12 / PHP 8.5 services: an API gateway, a Central administration service, and the Sales, Marketing, Inventory, Questionnaires and Files domain services, all sharing one Composer path package for the code that crosses service boundaries. Backend work only — the SPA is another team\'s.

Architecture: database-per-tenant multi-tenancy (stancl/tenancy) with domain resolution and per-tenant provisioning; JWT authentication (tymon/jwt-auth) with separate tenant and central guards; Laratrust RBAC extended with per-type and per-record permissions; a platform-aware layer that resolves WEB and MOBILE implementations of every Service, Request and Resource from an X-Platform header; and a strict Repository pattern so no service touches a model directly. Runs on Docker Compose behind Nginx and a production reverse proxy, with Supervisor-managed workers, Redis and php-fpm pools tuned to fit a 2-core box.

Shared contracts package: one Composer path package that every service installs and volume-mounts — the single home for anything that crosses a service boundary. It ships the typed HTTP service clients, the RabbitMQ publisher and consumer base classes, the import and export engines, the notification and audit-trail publishers, the shared middleware (rate limiting, localisation, request context, service-to-service auth, activity logging), a liveness endpoint registered into all seven services at once, phone-number and signed-file-URL helpers, the shared Arabic/English translation catalogue, and a set of custom Artisan generators — platform services, requests, resources, repositories, RabbitMQ consumers, and a versioned seeder system with batch rollback modelled on migrations. Adding a capability there reaches the whole fleet; it is what keeps seven services from growing seven copies of the same logic.

Central control plane (admin API): the tenant lifecycle end to end — create, block/unblock, soft-delete, restore, permanently drop, quota and licence expiry — over a dedicated `admin` JWT guard with its own RBAC, its own audit trail and a Server-Sent Events stream that reports each provisioning step live. Tenant creation runs a job pipeline (create database, migrate, seed, create the admin user) and records status, step and error per tenant.

On-prem client management: the same dashboard installs and operates Profit CRM on a client\'s own server over SSH (phpseclib) — host-key pinning, a generated managed key that replaces the typed credential, a per-box Bitbucket deploy key, a preflight of OS/Docker/Git/disk/RAM, a scripted install, a verify pass and a durable run log per machine. On top of it: fleet-wide deploys dispatched as queued runs, remote power up/down, per-tenant licence and module sync, and a phpMyAdmin console opened on the client\'s database through an SSH tunnel behind a one-time token.

Licensing: a Pennant-shaped feature catalogue in the central schema — modules (whole services) and features (capabilities), a per-tenant grant list with a transitive dependency closure, a shared Redis-cached read path across all seven services, fail-closed `feature:` middleware on each service\'s route group, and a permission-blocking projection so the UI hides what was never sold.

Asynchronous messaging: 30+ RabbitMQ queues (php-amqplib) driving activity logs, notifications, imports, exports, bulk actions, lead-ads ingestion, SMS/email campaigns and scheduled sweeps. Consumers were consolidated from 27 supervisor processes into 12 aggregate consumers, cutting worker memory from ~1.7 GB to ~770 MB.

Dynamic forms engine: every lead, request, inventory item, provider and state report is described by an admin-built questionnaire rather than fixed columns — 27 question types (text, select, multi-select, date, date range, map, phone, e-mail, price, counter, rich text, images, video, documents, 3D and 360 media), conditional questions nested under an option, per-question validation rules generated at runtime, uniqueness rules that drive lead duplicate detection, card/main field selection, media answers stored as files, and a cross-service answer filter and search used by every listing, export and bulk action.

Data in and out: a streaming export engine (XLSX via openspout, CSV, PDF via mPDF) covering 23 entities and 11 report matrices at constant memory — 200k rows in 36 MB where the previous pipeline exhausted 512 MB at 30k rows; a spreadsheet import engine (PhpSpreadsheet) with fuzzy header matching, batched cross-service validation, Excel date/coordinate/range cell normalisation, media fetched by share link, global-error detection and annotated reject files; and per-tenant database backups (scheduled or on demand, local disk or the tenant\'s own Dropbox, retention pruning) with a synchronous restore that re-imports the dump, migrates and re-seeds it to the current codebase, then flushes the tenant cache across every service behind a per-tenant lock.

Also built: push notifications on Firebase Cloud Messaging HTTP v1 with durable per-user rows, device-token and topic addressing and per-type TTLs; a cross-service audit trail on spatie/laravel-activitylog published over RabbitMQ and resolved to human-readable record names; Facebook Lead Ads integration (OAuth, webhooks, Graph API) with Conversions API quality feedback; and bulk SMS/e-mail campaigns across five SMS gateways and per-tenant SMTP.

Observability and logging: nine dedicated log channels (rabbitmq, import, export, restore, notification, deployment, slow queries, debug, daily) plus an edge-minted correlation id that nginx, PHP and every RabbitMQ envelope carry, so one id greps a request across every hop of the fleet. An opt-in Prometheus + Grafana + Loki + Alertmanager + Alloy stack adds 13 scrape targets, 27 alert rules, four provisioned dashboards and Discord alerting, with per-endpoint latency and active-user analytics derived from the nginx JSON access logs and k6 load tests for capacity work.

Next: a read-only Model Context Protocol (MCP) server as its own service, exposing the reporting surface over JSON-RPC to Claude and ChatGPT with per-user revocable tokens, so the same permissions and tenant isolation apply to an AI client as to the API.']);
    }
};
