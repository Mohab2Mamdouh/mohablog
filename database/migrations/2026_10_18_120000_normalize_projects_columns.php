<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Expand step of an expand/contract rename: add snake_case columns, copy the
     * production data into them and fold the duplicate `link` into `app_url`.
     *
     * The legacy columns (techmologyStack, url, appURL, link, endDate) are left
     * in place — untouched — so nothing is lost and old code keeps reading. They
     * are only relaxed to nullable because new writes go to the new columns.
     * Drop them in a later migration once production is confirmed healthy.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('github_url', 2048)->nullable()->after('name');
            $table->string('app_url', 2048)->nullable()->after('github_url');
            $table->text('tech_stack')->nullable()->after('description');
            $table->date('start_date')->nullable()->after('tech_stack');
            $table->date('end_date')->nullable()->after('start_date');
            $table->boolean('is_featured')->default(false)->after('show_at_cv');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->text('techmologyStack')->nullable()->change();
        });

        DB::table('projects')->orderBy('id')->each(function ($project) {
            DB::table('projects')->where('id', $project->id)->update([
                'github_url' => $this->cleanUrl($project->url),
                'app_url'    => $this->cleanUrl($project->appURL) ?? $this->cleanUrl($project->link),
                'tech_stack' => $project->techmologyStack,
                'end_date'   => $project->endDate,
            ]);
        });
    }

    /**
     * Copy anything written to the new columns back into the legacy ones before
     * dropping, so a rollback does not lose edits made after this migration.
     */
    public function down(): void
    {
        DB::table('projects')->orderBy('id')->each(function ($project) {
            DB::table('projects')->where('id', $project->id)->update([
                'url'             => $project->github_url ?? $project->url,
                'appURL'          => $project->app_url,
                'techmologyStack' => $project->tech_stack ?? $project->techmologyStack ?? '',
                'endDate'         => $project->end_date,
            ]);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['github_url', 'app_url', 'tech_stack', 'start_date', 'end_date', 'is_featured']);
        });
    }

    /** `url` defaulted to "_" and the seeders used "-" for "no repo". */
    private function cleanUrl(?string $value): ?string
    {
        $value = trim((string) $value);

        return in_array($value, ['', '_', '-'], true) ? null : $value;
    }
};
