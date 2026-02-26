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
            'fullName'        => 'Mohab Mamdouh Abd El-Twab',
            'username'        => 'mohablog',
            'title'           => 'Backend Developer PHP / Laravel',
            'email'           => 'mohabmamdouh0706@gmail.com',
            'address'         => 'El Slam, Cairo, Egypt',
            'profileImage'    => 'Mohab.jpg',
            'password'        => Hash::make('M01090483647'),
            'expYear'         => '1',
            'currentPosition' => 'Backend Developer PHP/Laravel',
            'profile'         => 'Passionate and results-oriented backend developer with one year of experience specializing in PHP Laravel. Proven ability to solve challenges and contribute effectively to projects. Eager to continue learning and apply skills in dynamic, innovative environments.',
            'phone'           => '01090483647',
            'github'          => 'https://github.com/Mohab2Mamdouh',
            'linked_in'       => 'https://linkedin.com/in/mohab-mamdouh-15851b350',
            'my_site'         => 'https://mohablog.herokuapp.com/',
            'behance'         => 'https://www.behance.net/mohabmamdouh22',
        ]);
    }
};
