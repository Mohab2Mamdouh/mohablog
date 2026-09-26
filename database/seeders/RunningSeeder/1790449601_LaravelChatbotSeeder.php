<?php

namespace Database\Seeders\RunningSeeder;

use App\Enums\SkillType;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    private const PROJECT = 'Laravel Chatbot';

    public function run(): void
    {
        if (! Project::where('name', self::PROJECT)->exists()) {
            Project::where('order', '>=', 6)->increment('order');
        }

        Project::updateOrCreate(
            ['name' => self::PROJECT],
            [
                'url'             => 'https://github.com/Mohab2Mamdouh/laravel-chatbot',
                'appURL'          => null,
                'link'            => null,
                'caption'         => 'My own Composer package — a hybrid chatbot that answers from the database first and pays for an LLM only when it has to.',
                'order'           => 6,
                'show_at_cv'      => true,
                'endDate'         => '2026-05-11',
                'techmologyStack' => 'PHP 8.1+, Laravel 10+, Composer Package, Laravel Scout, Elasticsearch, Groq LLM API, REST API, MIT',
                'description'     => 'A plug-and-play chatbot package for Laravel — `mohab/laravel-chatbot`, MIT — built around one idea: an LLM call costs money and latency, so answer from your own data first and fall back to the model only when nothing matched.

A message runs through an intent detector, and a data query is resolved in two free tiers before the paid one. Registered report closures answer factual questions straight from the database ("total users", "revenue this month"). Anything else goes to Laravel Scout, so the app\'s own searchable models — implementing a `ChatSummarizable` contract that returns a one-line summary of each hit — are searched through Elasticsearch and their results composed into the reply. Only when both come back empty, or the message was conversation rather than a data query, is Groq\'s API called. Every response says which tier produced it, so the cost profile of a deployment is visible rather than guessed at.

It is entirely config-driven and ships nothing application-specific: an install command publishes the config, where a host application registers its searchable models, its report closures and the keywords that mark a data query, and tunes the model, token budget, how much conversation history is forwarded, the system prompt and the route prefix and middleware. The endpoint is a single rate-limited POST that takes the full message history, so multi-turn conversation works with a client that simply keeps its own transcript. The provider is auto-discovered, so installing it is one composer require and one command.',
            ]
        );

        $skills = [
            ['AI / LLM Integration', SkillType::Backend, true],
            ['Elasticsearch',        SkillType::Database, false],
        ];

        foreach ($skills as [$name, $type, $main]) {
            Skill::firstOrCreate(['languageName' => $name], ['type' => $type->value, 'main' => $main]);
        }
    }
};
