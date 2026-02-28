<?php

namespace Database\Seeders\RunningSeeder;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

return new class extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'fullName'        => 'Mohab Mamdouh',
            'username'        => 'mohablog',
            'title'           => 'Backend Developer PHP / Laravel',
            'email'           => 'mohabmamdouh0706@gmail.com',
            'address'         => 'El Slam, Cairo, Egypt',
            'profileImage'    => 'Mohab.jpg',
            'password'        => Hash::make('M01090483647'),
            'expYear'         => '2',
            'currentPosition' => 'Backend Developer PHP/Laravel',
            'profile'         => 'I am a Backend Developer specializing in PHP and Laravel with experience in building scalable web applications and microservices-based systems. I have worked on maintaining and improving CRM platforms, fixing legacy issues, and developing new system versions with better architecture and performance.

I have hands-on experience with RESTful APIs, message queues using RabbitMQ, database optimization, and Docker-based development environments. I enjoy solving complex technical problems, improving existing systems, and building reliable backend services that support modern web applications.

Currently, I focus on developing modular and scalable systems while continuously learning new technologies to improve performance, maintainability, and overall software quality.
',
            'phone'           => '01090483647',
            'github'          => 'https://github.com/Mohab2Mamdouh',
            'linked_in'       => 'https://linkedin.com/in/mohab-mamdouh-15851b350',
            'my_site'         => 'https://author.albarakainsfund.com/',
            'behance'         => 'https://www.behance.net/mohabmamdouh22',
        ]);
    }
};
