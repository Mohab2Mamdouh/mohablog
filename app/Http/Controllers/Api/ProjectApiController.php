<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Project;

class ProjectApiController extends BaseController
{
    public function showAll()
    {
        return Project::all();
    }

    public function show(Project $project)
    {
        return $project;
    }

    public function create()
    {
        request()->validate([
            'name' => 'required',
            'url' => 'required',
            'caption' => 'required',
            'techmologyStack' => 'required',
            'endDate' => 'required',
            'appURL' => 'required'
        ]);

        $success = Project::create([
            'name' => request('name'),
            'url' => request('url'),
            'caption' => request('caption'),
            'techmologyStack' => request('techmologyStack'),
            'endDate' => request('endDate'),
            'appURL' => request('appURL')
        ]);

        return [
            "success" => $success
        ];
    }

    public function update(Project $project)
    {
        request()->validate([
            'name' => 'required',
            'url' => 'required',
            'caption' => 'required',
            'techmologyStack' => 'required',
            'endDate' => 'required',
            'appURL' => 'required'
        ]);

        $success = $project->update([
            'name' => request('name'),
            'url' => request('url'),
            'caption' => request('caption'),
            'techmologyStack' => request('techmologyStack'),
            'endDate' => request('endDate'),
            'appURL' => request('appURL')
        ]);

        return [
            "success" => $success
        ];
    }

    public function delete(Project $project)
    {
        $success = $project->delete();

        return [
            "success" => $success
        ];
    }
}
