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
        'url',
        'link',
        'appURL',
        'caption',
        'summary',
        'description',
        'techmologyStack',
        'endDate',
        'order',
        'show_at_cv',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'endDate'    => 'date',
        'show_at_cv' => 'boolean',
    ];


    #[Scope]
    public function showAtCV(Builder $query, bool $value = true): void
    {
        $query->where('show_at_cv', $value);
    }

    public function formattedEndDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->endDate?->format('M Y'),
        );
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
