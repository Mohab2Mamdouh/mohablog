<?php

namespace Database\Seeders\RunningSeeder;

use App\Models\Project;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    private const PROJECT = 'Laravel Blueprint';

    public function run(): void
    {
        if (! Project::where('name', self::PROJECT)->exists()) {
            Project::where('order', '>=', 5)->increment('order');
        }

        Project::updateOrCreate(
            ['name' => self::PROJECT],
            [
                'url'             => 'https://github.com/Mohab2Mamdouh/laravel-blueprint',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'My own published Composer package — the application foundation three of my other projects are built on.',
                'order'           => 5,
                'show_at_cv'      => true,
                'endDate'         => '2026-07-12',
                'techmologyStack' => 'PHP 8.3, Laravel 11/12, Composer Package, Artisan Generators, Repository Pattern, Spatie Translatable, MIT',
                'description'     => 'A Laravel foundation package of my own — `mohab/laravel-blueprint`, published under MIT and installed by path or private VCS repository — that carries the conventions I would otherwise re-implement in every project. DeployMate consumes it as a Composer dependency, and both Anageet and Community Management vendor it into their own `app/Blueprint` namespace.

What it ships. A single service provider that bootstraps the package\'s config, migrations, translations, commands, views and macros with nothing to wire by hand. A repository contract and an Eloquent base implementation giving every entity the full CRUD and query surface — get, first, paginate, cursor-paginate, pluck, count, exists, raw builder — selected through a `QueryReturnType` enum instead of a separate method per return shape. A `BaseModel` with eleven opt-in traits: creator attribution, enum helpers, human-readable dates in a configured timezone, translatable fallback, auto-slugs, UUIDs, status handling, JSON meta, filtering, user ownership and image uploads, plus a user-visibility global scope.

Around that: a `Responser` helper producing one response envelope across every project; cache, log, mail and Firebase push helpers; a pagination resource; a formatted-datetime cast; a locale middleware; and a complete settings module — migration, model, repository, service and form request — so application settings are never rebuilt from scratch again.

Scaffolding is the point of it. `module:add-repository` generates a versioned service, repository pair and controller in one command, from stubs the package owns, so every feature in every consuming project lands in the same shape. `make:seeder` and `generate:seed` add migration-style tracked seeders — timestamped files recorded in a ledger table so each runs exactly once — which is the mechanism the rest of my projects now use for data that has to ship with the code. Its own strings are bilingual under a namespaced translation loader, so a consuming app can override any of them without touching the package.',
            ]
        );
    }
};
