<?php

namespace App\Models;

use App\Enums\SkillType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'languageName',
        'main',
        'type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'main' => 'boolean',
        'type' => SkillType::class,
    ];

    public function getProject()
    {
        return $this->belongsTo(Project::class, 'skillProject', 'skill_id', 'project_id');
    }

    /**
     * Accessor for 'name' as an alias of 'languageName'.
     */
    public function getNameAttribute(): string
    {
        return $this->languageName;
    }
}
