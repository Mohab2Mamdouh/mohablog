<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProjectSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_migration_copies_legacy_data_into_new_columns(): void
    {
        $migration = require database_path('migrations/2026_10_18_120000_normalize_projects_columns.php');
        $migration->down();

        // A row exactly as production has it today: legacy columns only.
        $id = DB::table('projects')->insertGetId([
            'name'            => 'Amtalek',
            'url'             => '-',
            'appURL'          => null,
            'link'            => 'https://www.amtalek.com/en',
            'caption'         => 'Real estate portal',
            'techmologyStack' => 'Laravel 12, MySQL',
            'endDate'         => '2025-10-30',
        ]);

        $migration->up();

        $row = DB::table('projects')->find($id);
        $this->assertNull($row->github_url);
        $this->assertSame('https://www.amtalek.com/en', $row->app_url);
        $this->assertSame('Laravel 12, MySQL', $row->tech_stack);
        $this->assertSame('2025-10-30', substr($row->end_date, 0, 10));

        // Legacy columns are left untouched.
        $this->assertSame('-', $row->url);
        $this->assertSame('https://www.amtalek.com/en', $row->link);
        $this->assertSame('Laravel 12, MySQL', $row->techmologyStack);
    }

    public function test_legacy_attribute_names_still_read_and_write(): void
    {
        $project = Project::create([
            'name'            => 'Couponzil',
            'caption'         => 'Coupons app',
            'url'             => '-',
            'appURL'          => null,
            'link'            => 'https://play.google.com/store/apps/details?id=com.couponzil',
            'techmologyStack' => 'Laravel 12, PHP, FCM',
            'endDate'         => '2025-06-15',
        ])->fresh();

        $this->assertNull($project->github_url);
        $this->assertSame('https://play.google.com/store/apps/details?id=com.couponzil', $project->app_url);
        $this->assertSame('Laravel 12, PHP, FCM', $project->tech_stack);
        $this->assertSame('2025-06-15', $project->end_date->format('Y-m-d'));

        $this->assertSame($project->app_url, $project->appURL);
        $this->assertSame($project->app_url, $project->link);
        $this->assertSame($project->tech_stack, $project->techmologyStack);
        $this->assertTrue($project->endDate->equalTo($project->end_date));
        $this->assertSame(['Laravel 12', 'PHP', 'FCM'], $project->techList->all());
    }

    public function test_admin_form_saves_the_new_fields(): void
    {
        $user = $this->admin();

        $this->actingAs($user)->post(route('projects.store'), [
            'name'        => 'DeployMate',
            'caption'     => 'Self-hosted deploys',
            'tech_stack'  => 'Laravel 12, Docker',
            'github_url'  => 'https://github.com/Mohab2Mamdouh/DeployMate',
            'app_url'     => '',
            'start_date'  => '2026-01-01',
            'end_date'    => '2026-06-20',
            'show_at_cv'  => '1',
            'is_featured' => '1',
        ])->assertRedirect(route('projects.show'));

        $project = Project::where('name', 'DeployMate')->firstOrFail();
        $this->assertSame('Laravel 12, Docker', $project->tech_stack);
        $this->assertSame('https://github.com/Mohab2Mamdouh/DeployMate', $project->github_url);
        $this->assertTrue($project->is_featured);
        $this->assertSame('2026-01-01', $project->start_date->format('Y-m-d'));

        $this->actingAs($user)->get(route('projects.show'))
            ->assertOk()
            ->assertSee('DeployMate')
            ->assertSee('Featured');
    }

    public function test_end_date_cannot_precede_start_date(): void
    {
        $this->actingAs($this->admin())->post(route('projects.store'), [
            'name'       => 'Broken',
            'caption'    => 'x',
            'tech_stack' => 'PHP',
            'start_date' => '2026-05-01',
            'end_date'   => '2026-01-01',
        ])->assertSessionHasErrors('end_date');
    }

    private function admin(): User
    {
        return User::create([
            'fullName'        => 'Mohab Mamdouh',
            'username'        => 'mohab',
            'title'           => 'Backend Engineer',
            'email'           => 'mohab@example.test',
            'address'         => 'Cairo, Egypt',
            'phone'           => '01000000000',
            'profile'         => 'Backend engineer focused on Laravel.',
            'profileImage'    => 'me.png',
            'password'        => 'secret',
            'expYear'         => '6',
            'currentPosition' => 'Senior Backend Engineer',
            'github'          => 'https://github.com/mohab',
            'linked_in'       => 'https://linkedin.com/in/mohab',
            'my_site'         => 'https://example.test',
            'behance'         => '',
            'layout'          => 'pdf',
        ]);
    }
}
