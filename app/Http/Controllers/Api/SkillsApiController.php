<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


use App\Models\Skill;

class SkillsApiController extends BaseController
{
    public function showAll()
    {
        return Skill::all();
    }

    public function show(Skill $skill)
    {
        return $skill;
    }

    public function create()
    {
        request()->validate([
            'languageName' => 'required',
            'type' => 'required',
        ]);

        $success = Skill::create([
            'languageName' => request('languageName'),
            'type' => request('level'),
            'main' => request('main')
        ]);

        return [
            "success" => $success
        ];
    }

    public function update(Skill $skill)
    {
        request()->validate([
            'languageName' => 'required',
            'type' => 'required',
        ]);

        $success = $skill->update([
            'languageName' => request('languageName'),
            'type' => request('level'),
            'main' => request('main')
        ]);

        return [
            "success" => $success
        ];
    }

    public function delete(Skill $skill)
    {
        $success = $skill->delete();

        return [
            "success" => $success
        ];
    }
}
