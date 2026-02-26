<?php

namespace Database\Seeders\RunningSeeder;

use App\Enums\SkillType;
use App\Models\Skill;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skill::truncate();

        $skills = [
            ['languageName' => 'PHP',        'type' => SkillType::Backend->value,          'main' => true],
            ['languageName' => 'Laravel',     'type' => SkillType::Backend->value,          'main' => true],
            ['languageName' => 'REST APIs',   'type' => SkillType::Backend->value,          'main' => false],
            ['languageName' => 'JavaScript',  'type' => SkillType::Frontend->value,         'main' => false],
            ['languageName' => 'HTML',        'type' => SkillType::Frontend->value,         'main' => false],
            ['languageName' => 'CSS',         'type' => SkillType::Frontend->value,         'main' => false],
            ['languageName' => 'Bootstrap',   'type' => SkillType::Frontend->value,         'main' => false],
            ['languageName' => 'Tailwind',    'type' => SkillType::Frontend->value,         'main' => false],
            ['languageName' => 'MySQL',       'type' => SkillType::Database->value,         'main' => false],
            ['languageName' => 'Git',         'type' => SkillType::OtherSkills->value,      'main' => false],
            ['languageName' => 'Docker',      'type' => SkillType::OtherSkills->value,      'main' => false],
            ['languageName' => 'WordPress',   'type' => SkillType::PriorKnowledge->value,   'main' => false],
            ['languageName' => 'AJAX',        'type' => SkillType::LittleKnowledge->value,  'main' => false],
            ['languageName' => 'jQuery',      'type' => SkillType::LittleKnowledge->value,  'main' => false],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
};
