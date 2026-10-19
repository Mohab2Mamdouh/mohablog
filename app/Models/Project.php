<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'github_url',
        'app_url',
        'caption',
        'summary',
        'description',
        'tech_stack',
        'start_date',
        'end_date',
        'order',
        'show_at_cv',
        'is_featured',

        // Legacy names, kept so existing seeders still write through the
        // aliases below into the new columns.
        'url',
        'link',
        'appURL',
        'techmologyStack',
        'endDate',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'show_at_cv'  => 'boolean',
        'is_featured' => 'boolean',
    ];


    #[Scope]
    public function showAtCV(Builder $query, bool $value = true): void
    {
        $query->where('show_at_cv', $value);
    }

    public function formattedEndDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->end_date?->format('M Y'),
        );
    }

    /**
     * The comma-separated stack as a clean list of technologies.
     */
    public function techList(): Attribute
    {
        return Attribute::make(
            get: fn () => collect(explode(',', (string) $this->tech_stack))
                ->map(fn ($tech) => trim($tech))
                ->filter()
                ->unique()
                ->values(),
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Legacy column aliases
    |--------------------------------------------------------------------------
    | The portfolio templates, PDFs and already-applied seeders still use the
    | old column names. These map them onto the new columns so the old names
    | keep working (read and write) even after the legacy columns are dropped.
    |
    | Done as a key map rather than accessor methods on purpose: Eloquent
    | resolves `end_date` to an `endDate()` method and `app_url` to `appUrl()`
    | (PHP method names are case-insensitive), which would recurse.
    */

    private const LEGACY_COLUMNS = [
        'techmologyStack' => 'tech_stack',
        'endDate'         => 'end_date',
        'url'             => 'github_url',
        'appURL'          => 'app_url',
        'link'            => 'app_url', // was a duplicate of appURL
    ];

    public function getAttribute($key)
    {
        return parent::getAttribute(self::LEGACY_COLUMNS[$key] ?? $key);
    }

    public function setAttribute($key, $value)
    {
        if (! isset(self::LEGACY_COLUMNS[$key])) {
            return parent::setAttribute($key, $value);
        }

        // "_" / "-" were the old "no repository" placeholders.
        if (in_array($value, ['', '_', '-'], true)) {
            $value = null;
        }

        // appURL and link share one column; an empty one must not wipe the other.
        if ($value === null && self::LEGACY_COLUMNS[$key] === 'app_url') {
            return $this;
        }

        return parent::setAttribute(self::LEGACY_COLUMNS[$key], $value);
    }

    /**
     * What the CV should print for this project: the short summary if one was
     * written, otherwise the caption, otherwise a trimmed description — so a
     * full case study never lands in the PDF by accident.
     */
    public function cvSummary(): Attribute
    {
        return Attribute::make(
            get: fn () => trim((string) $this->summary)
                ?: trim((string) $this->caption)
                ?: Str::limit(trim(strip_tags((string) $this->description)), 300),
        );
    }

    public function getkills()
    {
        return $this->belongsToMany(Skill::class, 'skillProject', 'project_id', 'skill_id');
    }
}
