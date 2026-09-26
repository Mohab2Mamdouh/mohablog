<?php

namespace Database\Seeders\RunningSeeder;

use App\Enums\SkillType;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    private const PROJECT = 'Tracker';

    public function run(): void
    {
        if (! Project::where('name', self::PROJECT)->exists()) {
            Project::where('order', '>=', 7)->increment('order');
        }

        Project::updateOrCreate(
            ['name' => self::PROJECT],
            [
                'url'             => 'https://github.com/Mohab2Mamdouh/tracker',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'Time-tracking and invoicing tool with two interchangeable backends — a single-file PHP API and a Go rewrite — over one SQLite file. Status: Ongoing.',
                'order'           => 7,
                'show_at_cv'      => true,
                'endDate'         => null,
                'techmologyStack' => 'Go, PHP 8, SQLite, JavaScript, HTML, CSS, REST API, Docker',
                'description'     => 'A time-tracking, earnings and invoicing tool I built for my own contracting work, designed around a hard deployment constraint: it had to run on cheap shared hosting with no database server, no build step and no install. It is three files — one HTML page, one PHP API and a SQLite database the API creates and migrates itself on first request — uploaded to a subdomain and working.

It was then rewritten in **Go**: a single binary that speaks the identical API, reads the identical SQLite file and serves the frontend embedded inside itself, so the whole application is one executable plus a database file. Both backends are kept working against the same schema and each migrates an existing database in place on start, which means moving from shared hosting to a VPS is copying one file across — no export, no import, no downtime by design.

What it does: projects each carrying their own hourly rate and currency, falling back to a default, so clients paying different amounts still total correctly; a live timer that survives a page reload; hour entry that understands 1.5, 1:30, 1h30 and 90m, with optional rounding; entry editing and undo on delete; date-range filters with quick ranges that persist across reloads and drive the log, the earnings panel and the export together. Money: a payments ledger with "still owed" computed all-time per project rather than per period — a transfer arriving today may settle work from three months ago — printable invoices generated from whatever is currently filtered, a monthly income goal with a pace projection, a blended effective hourly rate, and a twelve-month stacked earnings chart. Plus streaks, an activity heatmap, keyboard shortcuts, CSV export of the filtered set with a totals row, and full JSON backup and restore.

Security is deliberate for something holding rate cards and client names on shared hosting: the password is verified server-side on every single request rather than in the browser, an `.htaccess` blocks anyone downloading the SQLite file directly, and the hide-money mode is a real lock — hiding is instant, but revealing the figures again re-asks for the password and a wrong answer does not sign you out, so someone at your screen cannot simply click it back.',
            ]
        );

        Skill::firstOrCreate(['languageName' => 'Go'], ['type' => SkillType::Backend->value, 'main' => false]);
    }
};
