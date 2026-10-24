<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(): User
    {
        return User::create([
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
    }

    private function profile(array $overrides = []): array
    {
        return $overrides + [
            'FullName'  => 'Mohab M.',
            'Username'  => 'mohab',
            'Title'     => 'Backend Engineer',
            'Email'     => 'mohab@example.com',
            'Address'   => 'Cairo',
            'Phone'     => '0100',
            'ExpYear'   => '6',
            'profile'   => 'Profile',
            'linked_in' => 'https://linkedin.com/in/mohab',
            'behance'   => '-',
            'github'    => 'https://github.com/mohab',
            'my_site'   => 'https://example.com',
            'layout'    => 'pdf',
        ];
    }

    public function test_admin_area_and_maintenance_routes_require_login(): void
    {
        $this->makeUser();

        $this->get('/admin/home')->assertRedirect('/login');
        $this->get('/admin/projects/show')->assertRedirect('/login');
        foreach (['optimize-clear', 'route-clear', 'cache-clear'] as $cmd) {
            $this->get("/artisan/{$cmd}")->assertRedirect('/login');
        }
    }

    public function test_admin_deletes_need_a_delete_request(): void
    {
        $user = $this->makeUser();
        $skill = Skill::create(['languageName' => 'Go', 'type' => 'Backend', 'main' => 0]);

        // A plain link (GET) - what another site could trigger - no longer deletes.
        $this->actingAs($user)->get("/admin/skills/{$skill->id}/delete")->assertStatus(404);
        $this->assertDatabaseHas('skills', ['id' => $skill->id]);

        $this->actingAs($user)->delete("/admin/skills/{$skill->id}")->assertRedirect();
        $this->assertDatabaseMissing('skills', ['id' => $skill->id]);
    }

    public function test_login_is_limited_per_email_and_tokens_expire_and_can_all_be_revoked(): void
    {
        $user = $this->makeUser();

        for ($i = 0; $i < 10; $i++) {
            // Different IPs, same account: the per-IP throttle alone wouldn't stop this.
            $this->withServerVariables(['REMOTE_ADDR' => "10.0.0.{$i}"])
                ->postJson('/api/token', ['email' => 'MOHAB@example.com', 'password' => "wrong{$i}"])
                ->assertStatus(422);
        }
        $this->withServerVariables(['REMOTE_ADDR' => '10.0.1.1'])
            ->postJson('/api/token', ['email' => 'mohab@example.com', 'password' => 'secret'])
            ->assertStatus(429);

        $this->travel(61)->minutes();
        $token = $this->withServerVariables(['REMOTE_ADDR' => '10.0.1.2'])
            ->postJson('/api/token', ['email' => 'mohab@example.com', 'password' => 'secret'])
            ->assertOk()->json('token');
        $this->assertNotNull($user->tokens()->first()->expires_at);

        $user->createToken('other');
        $this->withToken($token)->deleteJson('/api/tokens')->assertOk()->assertJsonPath('revoked', 2);
        $this->assertSame(0, $user->tokens()->count());
    }

    public function test_unsafe_profile_values_are_rejected(): void
    {
        Sanctum::actingAs($this->makeUser());

        $this->putJson('/api/profile', $this->profile(['github' => 'javascript:alert(1)']))
            ->assertStatus(422)->assertJsonValidationErrors('github');
        $this->putJson('/api/profile', $this->profile(['my_site' => ' JavaScript:alert(1)']))
            ->assertStatus(422)->assertJsonValidationErrors('my_site');
        $this->putJson('/api/profile', $this->profile(['layout' => 'Admin.Dashboard.home']))
            ->assertStatus(422)->assertJsonValidationErrors('layout');
        $this->putJson('/api/profile', $this->profile(['Email' => 'not-an-email']))
            ->assertStatus(422)->assertJsonValidationErrors('Email');
        $this->putJson('/api/profile', $this->profile(['ExpYear' => ['x']]))
            ->assertStatus(422)->assertJsonValidationErrors('ExpYear');
        $this->putJson('/api/profile', $this->profile())->assertOk();
    }

    public function test_bad_ids_and_order_payloads_are_rejected_not_500(): void
    {
        Sanctum::actingAs($this->makeUser());
        $p = Project::create(['name' => 'Blog', 'caption' => 'CMS', 'tech_stack' => 'Laravel']);

        $this->getJson('/api/projects/abc')->assertNotFound();
        $this->getJson('/api/skills/1x')->assertNotFound();
        $this->postJson('/api/projects/order', ['order' => ['x' => $p->id]])->assertStatus(422);
        $this->postJson('/api/projects/order', ['order' => [$p->id, $p->id]])->assertStatus(422);
        $this->postJson('/api/projects', ['name' => 'X', 'caption' => 'Y', 'tech_stack' => 'Z', 'app_url' => 'javascript:alert(1)'])
            ->assertStatus(422)->assertJsonValidationErrors('app_url');
        $this->postJson('/api/skills', ['languageName' => 'Go', 'type' => 'Backend', 'main' => ['x']])
            ->assertStatus(422)->assertJsonValidationErrors('main');
    }
}
