<?php

namespace Database\Seeders\RunningSeeder;

use App\Models\Project;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::truncate();

        $projects = [

            // ── Real Estate / Amtalek (ERP) ─────────────────────────────────
            [
                'name'            => 'Profit CRM (Microservices)',
                'url'             => 'https://bitbucket.org/m7_esmaar/workspace/repositories/',
                'appURL'          => null,
                'link'            => null, // Deployment link
                'caption'         => 'Dashboard & mobile application. Status: Ongoing.',
                'order'           => 1,
                'description'     => 'Developed and maintained a Microservices-based CRM system derived from Profit CRM versions v4 and v5, and collaborated with a teammate to build version v6 with improved architecture and scalability. The system was refactored from a monolithic structure into modular microservices to enhance maintainability, performance, and independent service deployment.

Implemented asynchronous communication between services using RabbitMQ as a message broker, enabling reliable message queues and event-driven processing across different CRM components. This approach improved system responsiveness and decoupled service interactions.

Key contributions included building and maintaining RESTful APIs using PHP and Laravel, optimizing database operations, debugging and enhancing legacy modules, and ensuring seamless communication between microservices. The project supports core CRM functionalities such as customer management, sales tracking, and reporting while following clean architecture principles and modular design practices.',
                'techmologyStack' => 'Laravel 12, PHP, RabbitMQ, REST APIs, MySQL, Docker, Microservices Architecture, Git',
                'endDate'         =>  null,
            ],
            [
                'name'            => 'Amtalek',
                'url'             => 'https://github.com/Mohab2Mamdouh/Amtalek',
                'appURL'          => null,
                'link'            => 'https://www.amtalek.com/en', // Deployment link
                'caption'         => 'Real estate ERP — website, dashboard & mobile application. Status: Ongoing.',
                'order'           => 2,
                'description'     => 'Phase 1 – API Performance Optimization: Enhanced API performance for faster frontend responsiveness. Optimized backend queries, controllers, and response times. Collaborated with the frontend team to ensure efficient data delivery. Phase 2 – Dashboard & API Rebuild (Clean Architecture): Rebuilt the dashboard and APIs using Clean Architecture with a Service – Interface – Repository – Actions pattern. Improved separation of concerns, maintainability, and long-term scalability. Features property listings, advanced search, user management, and full admin controls for a complete property marketplace.',
                'techmologyStack' => 'Laravel 12, PHP, MySQL, Bootstrap, HTML, CSS, REST APIs, Clean Architecture',
                'endDate'         => '2025-10-30',
            ],

            // ── Mobile Applications ──────────────────────────────────────────

            [
                'name'            => 'Skillifyr',
                'url'             => '-',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'Mobile application backend with real-time push notifications.',
                'order'           => 3,
                'description'     => 'Built and improved dashboard layouts for better UX and responsiveness. Developed API endpoints for Flutter app integration enabling smooth data communication. Configured Firebase Cloud Messaging (FCM) for real-time push notifications. Applied Laravel 12 best practices for compatibility and performance.',
                'techmologyStack' => 'Laravel 12, PHP, MySQL, Firebase (FCM), REST APIs',
                'endDate'         => '2025-07-20',
            ],
            [
                'name'            => 'Couponzil',
                'url'             => '-',
                'appURL'          => 'https://play.google.com/store/apps/details?id=com.couponzil',
                'link'            => 'https://play.google.com/store/apps/details?id=com.couponzil',
                'caption'         => 'Mobile coupon & deals app with real-time notifications.',
                'order'           => 4,
                'description'     => 'Extended the Laravel backend with new features and developed RESTful APIs for Flutter mobile app integration. Implemented Firebase Cloud Messaging (FCM) for real-time push notifications. Worked closely with the mobile team to align backend functionality with frontend requirements.',
                'techmologyStack' => 'Laravel 12, PHP, MySQL, Firebase (FCM), REST APIs',
                'endDate'         => '2025-06-15',
            ],

            // ── Company Portfolio ────────────────────────────────────────────

            [
                'name'            => 'E-ramo Portfolio',
                'url'             => '-',
                'appURL'          => 'https://e-ramo.net/en',
                'link'            => 'https://e-ramo.net/en',
                'caption'         => 'Company profile platform with admin dashboard and RESTful APIs.',
                'order'           => 5,
                'description'     => 'Developed RESTful APIs powering the frontend of E-ramo\'s company profile platform. Enhanced the admin dashboard layout and backend functionality. Ensured seamless data integration and performance through close collaboration with the frontend team.',
                'techmologyStack' => 'Laravel, PHP, MySQL, REST APIs',
                'endDate'         => '2025-5-15',
            ],

            // ── E-Commerce / Multi-vendor ────────────────────────────────────

            [
                'name'            => 'e-ramo Multivendor (Bnaia)',
                'url'             => '-',
                'appURL'          => 'https://bnaia.com/',
                'link'            => 'https://bnaia.com/',
                'caption'         => 'Multi-vendor e-commerce platform with vendor dashboards.',
                'order'           => 6,
                'description'     => 'A multi-vendor e-commerce system supporting multiple sellers, product management, order processing, and a shared storefront. Each vendor has a dedicated dashboard for managing their store, inventory, and orders.',
                'techmologyStack' => 'Laravel 12, PHP, Blade, Bootstrap, HTML, CSS',
                'endDate'         => '2025-10-09',
            ],

            // ── Project Management ───────────────────────────────────────────

            [
                'name'            => 'Project Management',
                'url'             => 'https://github.com/Mohab2Mamdouh/project-management',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'Backend system for personal and team project tracking.',
                'order'           => 7,
                'description'     => 'A project and task management backend supporting both personal and team workflows. Handles project creation, task assignment, progress tracking, and team collaboration with a React-powered frontend.',
                'techmologyStack' => 'Laravel 12, PHP, MySQL, React, JavaScript, HTML, CSS',
                'endDate'         => '2025-10-05',
            ],

            // ── Banking / Finance ────────────────────────────────────────────

            [
                'name'            => 'Albaraka Insfund',
                'url'             => 'https://github.com/Mohab2Mamdouh/Albaraka-insfund',
                'appURL'          => 'https://albarakainsfund.com/',
                'link'            => 'https://albarakainsfund.com/',
                'caption'         => 'Official bank-affiliated fund website with CMS dashboard.',
                'order'           => 8,
                'description'     => 'An official informational website for a bank-affiliated insurance fund. Showcases fund details, services, and board messaging. Includes a fully customizable admin dashboard for dynamic content management.',
                'techmologyStack' => 'laravel 12, MySQL, JavaScript, HTML, CSS',
                'endDate'         => '2026-02-26',
            ],
            [
                'name'            => 'Tire',
                'url'             => 'https://github.com/Mohab2Mamdouh/Tire',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'Platform connecting car owners with nearby mechanics.',
                'order'           => 9,
                'description'     => 'A service marketplace connecting car owners with nearby mechanics. Owners post repair requests and mechanics respond with offers. Features location-based matching, request management, and a responsive interface.',
                'techmologyStack' => 'Laravel, PHP, Bootstrap, HTML, CSS',
                'endDate'         => '2023-10-03',
            ],
            [
                'name'            => 'mohablog',
                'url'             => 'https://github.com/Mohab2Mamdouh/mohablog',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'Personal portfolio showcasing skills, projects, and experience.',
                'order'           => 10,
                'description'     => 'A personal portfolio website to showcase skills, projects, and work experience. Features dynamic content management through an admin dashboard, PDF export, and multiple template options.',
                'techmologyStack' => 'Laravel 12, MySQL, Bootstrap, HTML, CSS',
                'endDate'         => null,
            ],
            [
                'name'            => 'GYM',
                'url'             => 'https://github.com/Mohab2Mamdouh/CRM',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'Gym blog with offer posting and coach management.',
                'order'           => 11,
                'description'     => 'A gym management blog where admins can publish offers and manage coaches. Features user-facing blog posts, promotional content, and an admin panel for content and coach management.',
                'techmologyStack' => 'laravel, PHP, Bootstrap, HTML, CSS',
                'endDate'         => '2022-07-29',
            ],
            [
                'name'            => 'My Pharmacy',
                'url'             => 'https://github.com/Mohab2Mamdouh/My_Pharamacy',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'Pharmacy management system for medicines and inventory.',
                'order'           => 12,
                'description'     => 'A pharmacy management system built in PHP. Enables admins to manage medicines, patient orders, and track inventory through a clean web interface.',
                'techmologyStack' => 'laravel, PHP, CSS, HTML',
                'endDate'         => '2020-06-13',
            ],
            [
                'name'            => 'Freezing',
                'url'             => 'https://github.com/Mohab2Mamdouh/Freezing',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'Admin dashboard for AC service requests and employee assignment.',
                'order'           => 13,
                'description'     => 'An admin dashboard for Al Handasya air conditioning company. Users submit service requests which admins assign to employees. Features request tracking, employee management, and a responsive dashboard.',
                'techmologyStack' => 'Laravel, Bootstrap, HTML, CSS',
                'endDate'         => '2022-09-28',
            ],
            [
                'name'            => 'shURLort',
                'url'             => 'https://github.com/Mohab2Mamdouh/shURLort',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'URL shortener with tracking capabilities.',
                'order'           => 14,
                'description'     => 'A URL shortener built with Laravel. Allows users to create shortened URLs with tracking capabilities and a clean interface.',
                'techmologyStack' => 'Laravel, PHP, Tailwind CSS',
                'endDate'         => '2023-04-12',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
};
