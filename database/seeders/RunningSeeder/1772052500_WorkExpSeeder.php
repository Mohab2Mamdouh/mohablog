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
                'companyName' => 'E-ramo for Digital Solutions',
                'title'       => 'Backend PHP/Laravel Developer',
                'startDate'   => '2024-01-01',
                'endDate'     => null,
                'current'     => 'present',
                'caption'     => 'Built and maintained Laravel/PHP web applications using MVC architecture and RESTful APIs. Developed secure and scalable API endpoints for Android/iOS apps. Implemented Laravel Queues, admin panels, and data visualizations.',
                'environment' => 'Laravel, PHP, JavaScript, Blade, Bootstrap, MySQL, REST APIs, Git, AJAX, Chart.js, C3.js, Laravel Queues',
            ],
            [
                'companyName' => 'Dot Apps (Freelance)',
                'title'       => 'Backend Developer PHP/Laravel',
                'startDate'   => '2023-01-01',
                'endDate'     => '2023-06-30',
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
        ];

        foreach ($workExps as $exp) {
            WorkExp::create($exp);
        }
    }
};
