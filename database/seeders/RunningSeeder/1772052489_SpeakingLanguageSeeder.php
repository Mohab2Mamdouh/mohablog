<?php

namespace Database\Seeders\RunningSeeder;

use App\Models\SpeakingLanguage;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SpeakingLanguage::truncate();

        $languages = [
            ['languageName' => 'Arabic',  'level' => 'Native'],
            ['languageName' => 'English', 'level' => 'Professional'],
        ];

        foreach ($languages as $language) {
            SpeakingLanguage::create($language);
        }
    }
};
