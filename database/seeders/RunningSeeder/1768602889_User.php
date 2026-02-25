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

        User::create(
            [
                'fullName' => 'Mohab Mamdouh Abd El-Twab',
                'username' => 'mohablog',
                'title' => "Backend Developer PHP / Laravel",
                'email' => "mohabmamdouh22@gmail.com",
                'address' => "Cairo, El-Slam",
                'profileImage' => "Mohab.jpg",
                'password' => Hash::make('M01090483647'),
                'expYear' => '4',
                'currentPosition' => "Backend Developer PHP/Laravel",
                'profile' => 'Mohab is a backend developer PHP/Laravel, He has 1 year of experience in backend development websites, Develop functions with a good knowledge of Web Applications Development.',
                'phone' => '01156047032',
                'github' => 'https://github.com/Mohab2Mamdouh',
                'linked_in' => 'https://linkedin.com/in/mohab-mamdouh-9307a57b/',
                'my_site' => 'https://mohablog.herokuapp.com/',
                'behance' => 'https://www.behance.net/mohabmamdouh22'
            ]
        );
    }
};
