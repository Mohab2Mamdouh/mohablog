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
            [
                'name'            => 'Gym',
                'url'             => 'http://shurlort.herokuapp.com/sq',
                'appURL'          => 'http://shurlort.herokuapp.com/sq',
                'link'            => null,
                'caption'         => 'It is a blog about gym, the admin could post offers and manage coashes.',
                'description'     => 'A gym management blog allowing the admin to post offers and manage coaches. Features include user-facing blog posts and an admin panel for content and coach management.',
                'techmologyStack' => 'PHP, Bootstrap, HTML, CSS, Jquery, AJAX',
                'endDate'         => '2021-03-10',
            ],
            [
                'name'            => 'Pharmacy',
                'url'             => 'http://shurlort.herokuapp.com/sg',
                'appURL'          => 'http://shurlort.herokuapp.com/sg',
                'link'            => null,
                'caption'         => 'Created to make the admin able to manage Orders from the patient and keep tracking his medicines.',
                'description'     => 'A pharmacy management system enabling admins to manage patient orders and track medicines. Includes order history, medicine inventory, and patient tracking features.',
                'techmologyStack' => 'PHP, Bootstrap, HTML, CSS, Jquery, AJAX',
                'endDate'         => '2021-06-24',
            ],
            [
                'name'            => 'Amireta',
                'url'             => 'http://shurlort.herokuapp.com/t0',
                'appURL'          => 'http://shurlort.herokuapp.com/t0',
                'link'            => null,
                'caption'         => "It is a blog about women and it has it's Mobile application",
                'description'     => "A women-focused blog platform with an accompanying mobile application. Built on WordPress with a responsive design and mobile-friendly UI.",
                'techmologyStack' => 'Wordpress, PHP, Bootstrap, HTML, CSS',
                'endDate'         => '2021-08-30',
            ],
            [
                'name'            => 'Freezing',
                'url'             => 'http://shurlort.herokuapp.com/s6',
                'appURL'          => 'http://shurlort.herokuapp.com/s6',
                'link'            => null,
                'caption'         => 'Admin Dashboard. Allow to add requests to the admin and the admin assign it to the employers.',
                'description'     => 'An admin dashboard for request management. Allows users to submit requests which are then assigned to employees by the admin. Features request tracking and assignment workflows.',
                'techmologyStack' => 'Laravel, Bootstrap, HTML, CSS',
                'endDate'         => '2022-06-15',
            ],
            [
                'name'            => 'ShURLort',
                'url'             => 'http://shurlort.herokuapp.com/uy',
                'appURL'          => 'http://shurlort.herokuapp.com/uo',
                'link'            => 'http://shurlort.herokuapp.com/uo',
                'caption'         => 'Laravel Project to Short URL',
                'description'     => 'A URL shortener built with Laravel. Allows users to create shortened URLs with tracking capabilities and a clean Tailwind CSS interface.',
                'techmologyStack' => 'Laravel, PHP, Tailwind css',
                'endDate'         => '2022-09-03',
            ],
            [
                'name'            => 'MohaBlog',
                'url'             => 'http://mohablog.herokuapp.com/user/portfolio',
                'appURL'          => 'http://mohablog.herokuapp.com/user/portfolio',
                'link'            => 'http://mohablog.herokuapp.com/user/portfolio',
                'caption'         => 'Portfolio Site To present skills and projects and experience',
                'description'     => 'A personal portfolio website to showcase skills, projects, and work experience. Features dynamic content management through an admin dashboard, PDF export, and multiple template options.',
                'techmologyStack' => 'Laravel, PHP, Bootstrap, HTML, CSS',
                'endDate'         => null,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
};
