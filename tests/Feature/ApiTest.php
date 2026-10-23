<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiTest extends TestCase
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

    public function test_token_is_issued_for_valid_credentials_only(): void
    {
        $this->makeUser();

        $this->postJson('/api/token', ['email' => 'mohab@example.com', 'password' => 'nope'])
            ->assertStatus(422);

        $token = $this->postJson('/api/token', ['email' => 'mohab@example.com', 'password' => 'secret'])
            ->assertOk()
            ->json('token');

        $this->withToken($token)->getJson('/api/profile')
            ->assertOk()
            ->assertJsonPath('username', 'mohab')
            ->assertJsonMissingPath('password');
    }

    public function test_routes_require_a_token(): void
    {
        $this->get('/api/projects')->assertStatus(401);
        $this->post('/api/projects', [])->assertStatus(401);
    }

    public function test_project_crud_order_and_cv_toggle(): void
    {
        Sanctum::actingAs($this->makeUser());

        $id = $this->postJson('/api/projects', [
            'name'       => 'Tracker',
            'caption'    => 'Time tracker',
            'tech_stack' => 'PHP, SQLite',
            'app_url'    => 'https://tracking.example.com',
        ])->assertCreated()->assertJsonPath('name', 'Tracker')->json('id');

        $this->postJson('/api/projects', ['name' => 'Bad'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['caption', 'tech_stack']);

        $this->putJson("/api/projects/$id", [
            'name'       => 'Tracker Pro',
            'caption'    => 'Time tracker',
            'tech_stack' => 'Go, SQLite',
            'show_at_cv' => true,
        ])->assertOk()->assertJsonPath('tech_stack', 'Go, SQLite')->assertJsonPath('show_at_cv', true);

        $this->patchJson("/api/projects/$id/toggle-cv")->assertOk()->assertJsonPath('show_at_cv', false);

        $other = Project::create(['name' => 'Blog', 'caption' => 'CMS', 'tech_stack' => 'Laravel'])->id;
        $this->postJson('/api/projects/order', ['order' => [$other, $id]])
            ->assertOk()
            ->assertJsonPath('0.id', $other)
            ->assertJsonPath('1.id', $id);

        $this->getJson("/api/projects/$id")->assertOk()->assertJsonPath('name', 'Tracker Pro');
        $this->deleteJson("/api/projects/$id")->assertOk()->assertJsonPath('deleted', true);
        $this->getJson("/api/projects/$id")->assertNotFound();
        $this->putJson('/api/projects/999999', ['name' => 'x', 'caption' => 'x', 'tech_stack' => 'x'])->assertNotFound();
    }

    public function test_skills_work_exps_and_languages_crud(): void
    {
        Sanctum::actingAs($this->makeUser());

        $skill = $this->postJson('/api/skills', ['languageName' => 'Go', 'type' => 'Backend', 'main' => 1])
            ->assertCreated()->json('id');
        $this->postJson('/api/skills', ['languageName' => 'Go', 'type' => 'Nope'])->assertStatus(422);
        $this->putJson("/api/skills/$skill", ['languageName' => 'Golang', 'type' => 'Backend'])
            ->assertOk()->assertJsonPath('languageName', 'Golang');
        $this->deleteJson("/api/skills/$skill")->assertOk();

        $work = $this->postJson('/api/work-exps', [
            'companyName' => 'Dotshub',
            'title'       => 'Backend Engineer',
            'caption'     => 'Built services',
            'environment' => 'Laravel',
            'startDate'   => '2024-01-01',
            'present'     => 'on',
        ])->assertCreated()->assertJsonPath('current', 'on')->assertJsonPath('endDate', null)->json('id');
        $this->putJson("/api/work-exps/$work", [
            'companyName' => 'Dotshub',
            'title'       => 'Senior Backend Engineer',
            'caption'     => 'Built services',
            'environment' => 'Laravel',
            'startDate'   => '2024-01-01',
            'endDate'     => '2026-01-01',
        ])->assertOk()->assertJsonPath('current', null)->assertJsonPath('title', 'Senior Backend Engineer');
        $this->getJson('/api/work-exps')->assertOk()->assertJsonCount(1);

        $lang = $this->postJson('/api/languages', ['languageName' => 'Arabic', 'level' => 'Native'])
            ->assertCreated()->json('id');
        $this->putJson("/api/languages/$lang", ['languageName' => 'Arabic', 'level' => 'Mother tongue'])
            ->assertOk()->assertJsonPath('level', 'Mother tongue');
        $this->deleteJson("/api/languages/$lang")->assertOk();
        $this->getJson('/api/languages')->assertOk()->assertJsonCount(0);
    }

    public function test_profile_update_and_export(): void
    {
        Sanctum::actingAs($this->makeUser());

        $this->putJson('/api/profile', [
            'FullName'  => 'Mohab M.',
            'Username'  => 'mohab',
            'Title'     => 'Senior Backend Engineer',
            'Email'     => 'mohab@example.com',
            'Address'   => 'Cairo',
            'Phone'     => '0100',
            'ExpYear'   => '6',
            'profile'   => 'New profile',
            'linked_in' => 'https://linkedin.com/in/mohab',
            'behance'   => '-',
            'github'    => 'https://github.com/Mohab2Mamdouh',
            'my_site'   => 'https://author.albarakainsfund.com',
            'layout'    => 'pdf',
        ])->assertOk()->assertJsonPath('title', 'Senior Backend Engineer');

        Project::create(['name' => 'Blog', 'caption' => 'CMS', 'tech_stack' => 'Laravel']);

        $this->getJson('/api/export')
            ->assertOk()
            ->assertJsonPath('profile.fullName', 'Mohab M.')
            ->assertJsonCount(1, 'projects')
            ->assertJsonStructure(['exported_at', 'skills', 'work_exps', 'languages', 'cv_pdf_url', 'cv_markdown_url']);
    }
}
