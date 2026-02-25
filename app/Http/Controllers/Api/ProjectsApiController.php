<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


use App\Models\Projects;

class ProjectsApiController extends BaseController
{
    public function showAll()
    {
        return Projects::all();
    }

    public function show(Projects $project)
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

        $success = Projects::create([
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

    public function update(Projects $project)
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

    public function delete(Projects $project)
    {
        $success = $project->delete();

        return [
            "success" => $success
        ];
    }
}
