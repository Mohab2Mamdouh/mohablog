<?php

namespace Database\Seeders\RunningSeeder;

use App\Models\Project;
use Illuminate\Database\Seeder;

/**
 * Backfills the short, CV-length `summary` for every project.
 *
 * `description` stays the full case study the website shows; this is what the
 * downloaded PDF prints. Each summary is condensed from that project's own
 * description, and an existing summary is never overwritten.
 */
return new class extends Seeder
{
    public function run(): void
    {
        foreach ($this->summaries() as $name => $summary) {
            Project::where('name', $name)
                ->where(function ($query) {
                    $query->whereNull('summary')->orWhere('summary', '');
                })
                ->update(['summary' => $summary]);
        }
    }

    /**
     * @return array<string, string>
     */
    private function summaries(): array
    {
        return [
            'Profit CRM (Microservices)' => 'Multi-tenant sales CRM rebuilt from a Laravel monolith into seven independent Laravel 12 services behind an API gateway, event-driven over 30+ RabbitMQ queues. Database-per-tenant isolation, JWT with separate tenant and central guards, and a central control plane that provisions tenants and licences for both SaaS and on-prem clients.',

            'Community Management' => 'Community-management platform for a real-estate developer. One Laravel 12 backend serves three surfaces — a Blade staff dashboard and two JWT mobile APIs for residents and gate staff — covering maintenance requests on a role-gated state machine, QR visitor passes, amenity bookings and bilingual announcements.',

            'Amtalek' => 'Real-estate ERP. Optimised API performance from 5+ seconds down to under one second, then rebuilt the dashboard and APIs on Clean Architecture with a Service – Interface – Repository – Actions pattern, covering property listings, advanced search and full admin controls.',

            'DeployMate' => 'Self-hosted deployment tool — the part of Envoyer or Forge a small team actually needs. Connects GitHub, GitLab or Bitbucket over OAuth to a target server over SSH, generates the deploy script fresh each run and streams execution back to the browser over Server-Sent Events. Open source under MIT.',

            'Laravel Blueprint' => 'My own published Composer package — the application foundation three of my other projects run on. Ships a repository contract, a BaseModel with cache, log, mail and push helpers, a uniform response envelope, and generators that scaffold a versioned service, repository and controller in one command.',

            'Laravel Chatbot' => 'My own published Composer package: a hybrid chatbot built on the idea that an LLM call costs money and latency, so answer from your own data first. A message resolves through intent detection and two free tiers — database facts, then Elasticsearch over the host app\'s models — and reaches the paid LLM only when both come back empty.',

            'Tracker' => 'Time-tracking and invoicing tool for my own contracting work, built under a hard constraint: run on cheap shared hosting with no database server and no build step. One HTML page, one PHP API and a self-migrating SQLite file, later rewritten in Go as a single binary against the identical schema.',

            'Anageet' => 'Multi-tenant attendance and workforce-management platform — a REST API for a Flutter app plus a Blade admin dashboard, with a separate database per company.',

            'Bnaia Multi Vendor' => 'Multi-vendor e-commerce system supporting multiple sellers, product management and order processing over a shared storefront, with a dedicated dashboard per vendor for store, inventory and orders.',

            'e-ramo Multivendor (Bnaia)' => 'Multi-vendor e-commerce system supporting multiple sellers, product management and order processing over a shared storefront, with a dedicated dashboard per vendor for store, inventory and orders.',

            'Couponzil' => 'Extended a Laravel backend with new features and RESTful APIs for a Flutter mobile app, and implemented Firebase Cloud Messaging for real-time push notifications.',

            'E-ramo Portfolio' => 'RESTful APIs powering the frontend of E-ramo\'s company profile platform, plus admin dashboard layout and backend work delivered with the frontend team.',

            'Skillifyr' => 'Dashboard rework for better UX and responsiveness, API endpoints for Flutter app integration, and Firebase Cloud Messaging for real-time push notifications.',

            'Project Management' => 'Backend for personal and team project tracking: project creation, task assignment, progress tracking and team collaboration behind a React frontend.',

            'Albaraka Insfund' => 'Informational website for a bank-affiliated insurance fund, showcasing fund details, services and board messaging, with a fully customisable admin dashboard for dynamic content.',

            'Tire' => 'Service marketplace connecting car owners with nearby mechanics: owners post repair requests and mechanics respond with offers, with location-based matching and request management.',

            'mohablog' => 'Personal portfolio for skills, projects and work experience, with dynamic content management through an admin dashboard, PDF export of the CV and multiple template options.',

            'GYM' => 'Gym management blog where admins publish offers and manage coaches, with user-facing posts and an admin panel for content and coach management.',

            'My Pharmacy' => 'Pharmacy management system built in PHP, letting admins manage medicines, patient orders and inventory through a clean web interface.',

            'Freezing' => 'Admin dashboard for an air-conditioning company: users submit service requests which admins assign to employees, with request tracking and employee management.',

            'shURLort' => 'URL shortener built with Laravel, letting users create shortened URLs with tracking capabilities behind a clean interface.',
        ];
    }
};
