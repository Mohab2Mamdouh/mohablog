<?php

namespace Database\Seeders\RunningSeeder;

use App\Models\SiteDetail;
use Illuminate\Database\Seeder;

return new class extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteDetail::create([
            'favicon' => 'favicon.png',
            'colorCode' => '#F16269'
        ]);

    }
};
