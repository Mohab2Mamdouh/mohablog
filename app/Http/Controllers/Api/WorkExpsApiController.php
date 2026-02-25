<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


use App\Models\WorkExp;

class WorkExpsApiController extends BaseController
{
    public function showAll()
    {
        return WorkExp::all();
    }

    public function show(WorkExp $work)
    {
        return $work;
    }

    public function create()
    {
        request()->validate([
            'companyName' => 'required',
            'startDate' => 'required',
            'caption' => 'required',
            'environment' => 'required',
            'title' => 'required',
        ]);

        $success = WorkExp::create([
            'companyName' => request('companyName'),
            'startDate' => request('startDate'),
            'caption' => request('caption'),
            'environment' => request('environment'),
            'title' => request('title'),
            'current' => request('current'),
            'endDate' => request('endDate')
        ]);

        return [
            "success" => $success
        ];
    }

    public function update(WorkExp $work)
    {
        request()->validate([
            'companyName' => 'required',
            'startDate' => 'required',
            'caption' => 'required',
            'environment' => 'required',
            'title' => 'required',
        ]);

        $success = $work->update([
            'companyName' => request('companyName'),
            'startDate' => request('startDate'),
            'caption' => request('caption'),
            'environment' => request('environment'),
            'title' => request('title'),
            'current' => request('current'),
            'endDate' => request('endDate')
        ]);

        return [
            "success" => $success
        ];
    }

    public function delete(WorkExp $work)
    {
        $success = $work->delete();

        return [
            "success" => $success
        ];
    }
}
