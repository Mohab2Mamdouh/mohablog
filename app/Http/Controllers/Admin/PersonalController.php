<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalInfoRequest;
use App\Http\Requests\ProfileImageRequest;
use App\Services\UserService;
use Illuminate\Contracts\View\View;

class PersonalController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}


    /**
     * Display the specified resource.
     *
     * @return View
     */
    public function show(): View
    {
        return view('Admin.personal.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function edit(): View
    {
        return view('Admin.personal.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PersonalInfoRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PersonalInfoRequest $request)
    {
        $this->userService->update($request);
        return redirect(route('info.show'));
    }

    /**
     * Update the profile image.
     *
     * @param ProfileImageRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateProfileImage(ProfileImageRequest $request)
    {
        $this->userService->updateProfileImage($request);
        return redirect(route('info.show'));
    }

}
