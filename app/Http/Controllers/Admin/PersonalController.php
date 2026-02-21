<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show()
    {
        return view('Admin.personal.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit()
    {
        return view('Admin.personal.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'FullName' => 'required',
            'Username' => 'required',
            'Title' => 'required',
            'Email' => 'required|string|min:4|max:255',
            'Address' => 'required',
            'Phone' => 'required',
            'ExpYear' => 'required',
            'profile' => 'required',
            'linked_in' => 'required',
            'behance' => 'required',
            'github' => 'required',
            'my_site' => 'required',
        ]);

        $user = User::where('id', $request['id'])->first();
        $user->fullName = $request['FullName'];
        $user->username = $request['Username'];
        $user->title = $request['Title'];
        $user->email = $request['Email'];
        $user->address = $request['Address'];
        $user->phone = $request['Phone'];
        $user->expYear = $request['ExpYear'];
        $user->profile = $request['profile'];
        $user->linked_in = $request['linked_in'];
        $user->behance = $request['behance'];
        $user->github = $request['github'];
        $user->my_site = $request['my_site'];

        $user->save();

        return redirect(route('info.show'));
    }

    public function updateProfileImage(Request $request)
    {
        $request->validate(([
            'id' => 'required',
            'profile_pic' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            'oldPic' => 'required'
        ]));

        $user = User::where('id', $request['id'])->first();

        $photo =  $user->username . '-' . time() . '.' . $request->profile_pic->extension();

        $request->profile_pic->move(public_path('storage/users'), $photo);

        $user->profileImage = $photo;

        $user->save();

        return redirect(route('info.show'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
