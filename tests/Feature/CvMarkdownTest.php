<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Skill;
use App\Models\SpeakingLanguage;
use App\Models\User;
use App\Models\WorkExp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CvMarkdownTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::create([
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

        Skill::create(['languageName' => 'PHP', 'main' => true, 'type' => 'Backend']);
        WorkExp::create([
            'companyName' => 'Dotshub',
            'title'       => 'Backend Engineer',
            'startDate'   => '2022-01-01',
            'endDate'     => null,
            'current'     => true,
            'caption'     => 'Built APIs.',
            'environment' => 'Laravel, MySQL',
        ]);
        Project::create([
            'name'             => 'Profit CRM',
            'caption'          => 'Multi-tenant CRM platform.',
            'description'      => 'A multi-tenant CRM.',
            'techmologyStack'  => 'Laravel, RabbitMQ',
            'link'             => 'https://example.test/crm',
            'order'            => 1,
            'show_at_cv'       => true,
        ]);
        SpeakingLanguage::create(['languageName' => 'Arabic', 'level' => 'Native']);
    }

    /**
     * Every route that renders a CV template.
     */
    public static function cvRoutes(): array
    {
        return [
            'portfolio'    => ['/'],
            'original'     => ['/template/original'],
            'terminal'     => ['/template/terminal'],
            'code-first'   => ['/template/code-first'],
            'architecture' => ['/template/architecture'],
            'minimalist'   => ['/template/minimalist'],
        ];
    }

    #[DataProvider('cvRoutes')]
    public function test_a_browser_gets_the_html_page(string $route): void
    {
        $response = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 Chrome/120 Safari/537.36',
            'Accept'     => 'text/html,application/xhtml+xml',
        ])->get($route);

        $response->assertOk();
        $response->assertSee('<!DOCTYPE html>', false);
        $response->assertHeader('Vary', 'User-Agent, Accept');
    }

    #[DataProvider('cvRoutes')]
    public function test_an_ai_agent_gets_markdown_on_every_template_route(string $route): void
    {
        $response = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ClaudeBot/1.0',
        ])->get($route);

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');
        $response->assertSee('# Mohab Mamdouh', false);
        $response->assertDontSee('<!DOCTYPE html>', false);
    }

    #[DataProvider('cvRoutes')]
    public function test_every_template_links_to_the_markdown_version(string $route): void
    {
        $response = $this->withHeader('User-Agent', 'Mozilla/5.0 Chrome/120')->get($route);

        $response->assertOk();
        $response->assertSee(route('cv.markdown.preview'), false);
        $response->assertSee('type="text/markdown"', false);
    }

    public function test_markdown_contains_every_cv_section(): void
    {
        $markdown = $this->get('/cv.md')->assertOk()->getContent();

        foreach (['# Mohab Mamdouh', '## Contact', '## Summary', '## Skills',
                  '## Experience', '## Projects', '## Languages'] as $heading) {
            $this->assertStringContainsString($heading, $markdown);
        }

        $this->assertStringContainsString('**Backend**: PHP', $markdown);
        $this->assertStringContainsString('Backend Engineer — Dotshub', $markdown);
        $this->assertStringContainsString('Jan 2022 – Present', $markdown);
        $this->assertStringContainsString('**Stack:** Laravel, RabbitMQ', $markdown);
        $this->assertStringContainsString('Arabic — Native', $markdown);
    }

    public function test_format_query_parameter_opts_in_to_markdown(): void
    {
        $this->get('/?format=md')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');
    }

    public function test_accept_markdown_header_opts_in(): void
    {
        $this->withHeader('Accept', 'text/markdown')
            ->get('/')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');
    }

    public function test_llms_txt_serves_the_same_document(): void
    {
        $this->get('/llms.txt')
            ->assertOk()
            ->assertSee('# Mohab Mamdouh', false);
    }

    public function test_preview_page_shows_the_markdown_source(): void
    {
        $response = $this->get('/cv/preview');

        $response->assertOk();
        $response->assertSee('What an AI agent sees');
        // The Markdown is rendered inside <pre>, so Blade escapes it on the way out.
        $response->assertSee('# Mohab Mamdouh');
        $response->assertSee('## Experience');
        $response->assertSee(route('cv.markdown'), false);
    }

    public function test_raw_flag_serves_plain_text_so_browsers_render_it_inline(): void
    {
        $this->get('/cv.md?raw=1')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function test_detection_can_be_disabled_by_config(): void
    {
        config(['ai_agents.enabled' => false]);

        $this->withHeader('User-Agent', 'ClaudeBot/1.0')
            ->get('/')
            ->assertOk()
            ->assertSee('<!DOCTYPE html>', false);
    }
}
