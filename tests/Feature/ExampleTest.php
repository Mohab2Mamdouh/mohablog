<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The portfolio home page renders the owner's profile.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        User::create([
            'fullName'        => 'Mohab Mamdouh',
            'username'        => 'mohab',
            'title'           => 'Backend Engineer',
            'email'           => 'mohab@example.com',
            'address'         => 'Cairo',
            'phone'           => '0100',
            'profile'         => 'Profile text',
            'profileImage'    => 'me.png',
            'password'        => Hash::make('secret'),
            'expYear'         => '5',
            'currentPosition' => 'Dotshub',
            'github'          => 'https://github.com/mohab',
            'linked_in'       => 'https://linkedin.com/in/mohab',
            'my_site'         => 'https://example.com',
            'behance'         => '-',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200)->assertSee('Mohab Mamdouh');
    }
}
