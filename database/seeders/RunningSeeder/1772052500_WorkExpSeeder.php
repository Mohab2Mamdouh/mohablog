<?php

namespace Database\Seeders\RunningSeeder;

use App\Models\WorkExp;
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
        WorkExp::truncate();

        $workExps = [
            [
                'companyName' => 'Dotshub (Profit CRM)',
                'title'       => 'Backend PHP/Laravel Developer',
                'startDate'   => '2025-11-01',
                'endDate'     => null,
                'current'     => 'present',
                'caption'     => 'Resolved critical issues in Profit CRM v4 & v5 and collaborated on developing v6, improving scalability through microservices architecture and RabbitMQ-based messaging.',
                'environment' => 'Laravel, PHP, RabbitMQ, REST APIs, MySQL, Docker, Microservices Architecture, Git',
            ],
            [
                'companyName' => 'E-ramo for Digital Solutions',
                'title'       => 'Backend PHP/Laravel Developer',
                'startDate'   => '2025-02-15',
                'endDate'     => '2025-10-30',
                'current'     => null,
                'caption'     => 'Built and maintained Laravel/PHP web applications using MVC architecture and RESTful APIs. Developed secure and scalable API endpoints for Android/iOS apps. Implemented Laravel Queues, admin panels, and data visualizations.',
                'environment' => 'Laravel, PHP, JavaScript, Blade, Bootstrap, MySQL, REST APIs, Git, AJAX, Chart.js, C3.js, Laravel Queues',
            ],
            [
                'companyName' => 'Freelance',
                'title'       => 'Backend Developer PHP/Laravel',
                'startDate'   => '2023-01-01',
                'endDate'     => '2024-03-30',
                'current'     => null,
                'caption'     => 'Worked on a Laravel-based project contributing to backend features and functionality enhancements. Performed bug fixes, feature updates, and code optimization for various client projects.',
                'environment' => 'Laravel, PHP, MySQL',
            ],
            [
                'companyName' => 'Caian Technology',
                'title'       => 'Backend Developer WordPress',
                'startDate'   => '2021-06-01',
                'endDate'     => '2021-09-30',
                'current'     => null,
                'caption'     => 'Developed and maintained websites using WordPress and PHP. Collaborated on the launch of the Amirta site with a responsive mobile-friendly UI.',
                'environment' => 'WordPress, PHP, Bootstrap, HTML, CSS',
            ],
            [
                'companyName' => 'Icouna',
                'title'       => 'PHP Developer',
                'startDate'   => '2020-09-01',
                'endDate'     => '2020-11-30',
                'current'     => null,
                'caption'     => 'Developed and maintained websites using WordPress and PHP. Collaborated on the launch of the Amirta site with a responsive mobile-friendly UI.',
                'environment' => 'WordPress, PHP, Bootstrap, HTML, CSS',
            ],
        ];

        foreach ($workExps as $exp) {
            WorkExp::create($exp);
        }
    }
};
