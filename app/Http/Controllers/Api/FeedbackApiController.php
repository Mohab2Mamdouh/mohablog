<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Models\FeedBack;

class FeedbackApiController extends BaseController
{
    public function showAll()
    {
        return FeedBack::all();
    }

    public function show(FeedBack $feed)
    {
        return $feed;
    }

    public function create()
    {
        request()->validate([
            'name' => 'required',
            'caption' => 'required',
            'stars' => 'required'
        ]);

        $success = FeedBack::create([
            'name' => request('name'),
            'caption' => request('caption'),
            'stars' => request('stars')
        ]);

        return [
            "success" => $success
        ];
    }

    public function update(FeedBack $feed)
    {
        request()->validate([
            'name' => 'required',
            'caption' => 'required',
            'stars' => 'required'
        ]);

        $success = $feed->update([
            'name' => request('name'),
            'caption' => request('caption'),
            'stars' => request('stars')
        ]);

        return [
            "success" => $success
        ];
    }

    public function delete(FeedBack $feed)
    {
        $success = $feed->delete();

        return [
            "success" => $success
        ];
    }
}
