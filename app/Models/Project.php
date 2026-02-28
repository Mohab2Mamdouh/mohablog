<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'endDate' => 'date',
    ];


    public function getkills()
    {
        return $this->belongsToMany(Skill::class, 'skillProject', 'project_id', 'skill_id');
    }
}
