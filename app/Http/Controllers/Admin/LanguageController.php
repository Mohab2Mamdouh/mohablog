<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\SpeakingLanguage;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $langs = SpeakingLanguage::all();
        return view('Admin.Slanguage.Slanguage', compact('langs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Slanguage.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'languageName' => 'required',
            'level' => 'required',
        ]);

        $sLanguage = new SpeakingLanguage();
        $sLanguage->languageName = $request['languageName'];
        $sLanguage->level = $request['level'];

        $sLanguage->save();

        return redirect(route('langs.show'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lang = SpeakingLanguage::where('id', $id)->first();
        return view('Admin.Slanguage.edit', compact('work'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SpeakingLanguage $id)
    {
        $request->validate([
            'languageName' => 'required',
            'level' => 'required',
        ]);

        // $sLanguage = SpeakingLanguage::where('id', $id)->first();
        $id->languageName = $request['languageName'];
        $id->level = $request['level'];

        $id->save();

        return redirect(route('langs.show'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lang = SpeakingLanguage::where('id', $id)->delete();
        return redirect(route('langs.show'));
    }
}
