<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    private $types = ['Backend', 'Fontend', 'Database', 'Little Knowledge', 'Prior Knowledge', 'Other Skills'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = Skill::all();
        return view('Admin.Skills.skills', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Skills.create');
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
            'type' => 'in:' . implode(',', $this->types),
        ]);

        $skill = new Skill();
        $skill->languageName = $request['languageName'];

        $skill->type = $request['type'];

        if ($request['main'] != null) {
            $skill->main = $request['main'];
        } else {
            $skill->main = "null";
        }
        $skill->save();

        return redirect(route('skills.show'));
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
        $skill = Skill::where('id', $id)->first();
        return view('Admin.Skills.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $id)
    {
        $request->validate([
            'languageName' => 'required',
            'type' => 'in:' . implode(',', $this->types),
        ]);

        // $skill = Skill::where('id', $id)->first();
        $id->languageName = $request['languageName'];

        $id->type = $request['type'];

        if ($request['main'] != null) {
            $id->main = $request['main'];
        } else {
            $id->main = "null";
        }

        $id->save();

        return redirect(route('skills.show'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $skill = Skill::where('id', $id)->delete();
        return redirect(route('skills.show'));
    }
}
