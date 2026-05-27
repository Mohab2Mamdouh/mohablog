<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpeakingLanguageRequest;
use App\Services\SpeakingLanguageService;

class LanguageController extends Controller
{
    public function __construct(
        private readonly SpeakingLanguageService $speakingLanguageService
    ) {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index()
    {
        $langs = $this->speakingLanguageService->getAll();
        return view('Admin.Slanguage.Slanguage', compact('langs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function create()
    {
        return view('Admin.Slanguage.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SpeakingLanguageRequest $request)
    {
        $this->speakingLanguageService->create($request);
        return redirect(route('langs.show'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
//        $lang = $this->speakingLanguageService->getById($id);
//        return view('Admin.Slanguage.edit', compact('lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SpeakingLanguageRequest $request, int $id)
    {
        $this->speakingLanguageService->update($id, $request);
        return redirect(route('langs.show'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this->speakingLanguageService->delete($id);
        return redirect(route('langs.show'));
    }
}
