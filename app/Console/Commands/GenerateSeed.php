<?php

namespace App\Console\Commands;

use App\Models\Seeder;
use Illuminate\Console\Command;

class GenerateSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate seed files for database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting seeding process...');

        $seederPath = database_path('seeders/RunningSeeder');

        // Get all PHP files from the seeders directory
        $allSeederFiles = array_diff(scandir($seederPath), ['.', '..']);

        // Filter only .php files and extract class names with timestamps
        $allSeederClasses = collect($allSeederFiles)
            ->filter(fn($file) => pathinfo($file, PATHINFO_EXTENSION) === 'php')
            ->map(function($file) {
                $filename = pathinfo($file, PATHINFO_FILENAME);

                // Extract timestamp if it exists (format: XXXTENTACION^ClassName or YYYY-MM-DD^ClassName)
                if (str_contains($filename, '^')) {
                    list($timestamp, $className) = explode('^', $filename, 2);

                    // Convert date format (YYYY-MM-DD) to timestamp for sorting
                    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $timestamp)) {
                        $timestamp = strtotime($timestamp);
                    }

                    return [
                        'filename' => $filename,
                        'timestamp' => is_numeric($timestamp) ? (int)$timestamp : 0,
                        'class' => $className
                    ];
                }

                // No timestamp prefix, use 0 for sorting
                return [
                    'filename' => $filename,
                    'timestamp' => 0,
                    'class' => $filename
                ];
            })
            ->sortBy('timestamp') // Sort by timestamp ascending
            ->values()
            ->toArray();

        if (empty($allSeederClasses)) {
            $this->warn('No seeder files found in ' . $seederPath);
            return;
        }
        $appliedSeeders = Seeder::all()->pluck('seeder')->toArray();

        // Find unapplied seeders (maintaining order)
        $unAppliedSeeders = collect($allSeederClasses)
            ->filter(fn($seeder) => !in_array($seeder['filename'], $appliedSeeders))
            ->values()
            ->toArray();

        if (count($unAppliedSeeders) > 0) {
            $this->info("  Found " . count($unAppliedSeeders) . " new seeder(s)");

            foreach ($unAppliedSeeders as $seeder) {
                $seederFilename = $seeder['filename'];
                $seederClass = $seeder['class'];
                $timestamp = $seeder['timestamp'];

                // Check if already exists (safety check)
                if (!Seeder::where('seeder', $seederFilename)->exists()) {
                    try {
                        $dateFormatted = $timestamp > 0 ? date('Y-m-d H:i:s', $timestamp) : 'No timestamp';
                        $this->info("  Running {$seederClass} ({$dateFormatted})...");

                        $seederPath = database_path('seeders/RunningSeeder/' . $seederFilename . '.php');

                        $seederInstance = include $seederPath;
                        $seederInstance->run();

                        $this->info("  ✓ {$seederClass} has been run");
                        Seeder::create(['seeder' => $seederFilename]);
                    } catch (\Exception $e) {
                        $this->error("  ✗ Failed to run {$seederClass}: " . $e->getMessage());
                    }
                }
            }
        } else {
            $this->info("  No new seeders to run");
        }
        $this->info('✓ seeding process completed!');
    }
}
