<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

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

    public function getkills()
    {
        return $this->belongsToMany(Skill::class, 'skillProject', 'project_id', 'skill_id');
    }
}
