<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


use App\Models\User;

class UserApiController extends BaseController
{
    public function showAll()
    {
        return User::all();
    }

    public function update(User $user)
    {
        request()->validate([
            'fullName' => 'required',
            'username' => 'required',
        ]);

        // $user->fullName = request('fullName');
        // $user->username = request('username');

        $success = $user->update([
            'fullName' => request('fullName'),
            'username' => request('username')
        ]);

        return [
            "success" => $success
        ];
    }
}
