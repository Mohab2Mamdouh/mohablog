<?php

namespace Database\Seeders\RunningSeeder;

use App\Models\WorkExp;
use Illuminate\Database\Seeder;

/**
 * The Dotshub caption was edited from the dashboard and still says V6 is
 * "6 independent microservices"; the fleet is nine now. Only that phrase is
 * replaced so the rest of the dashboard-written caption is kept as is.
 */
return new class extends Seeder
{
    public function run(): void
    {
        WorkExp::where('companyName', 'Dotshub (Profit CRM)')->get()->each(function (WorkExp $workExp) {
            $workExp->update([
                'caption' => preg_replace('/\b(?:6|six) independent microservices\b/i', '9 independent microservices', $workExp->caption),
            ]);
        });
    }
};
