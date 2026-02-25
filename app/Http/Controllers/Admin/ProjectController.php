<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Projects;
use App\Models\Skill;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Projects::all();
        return view('Admin.Projects.projects', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Projects.create');
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
            'projectName' => 'required',
            'caption' => 'required',
            'TechnologyStack' => 'required',
            'endDate' => 'required',
        ]);

        $project = new Projects();
        $project->name = $request['projectName'];
        $project->url = $request['URL'];
        $project->caption = $request['caption'];
        $project->techmologyStack = $request['TechnologyStack'];
        $project->endDate = $request['endDate'];
        $project->appURL = ($request['appURL'] != "") ? $request['appURL'] : $request['URL'] ;

        $project->save();

        return redirect(route('projects.show'));
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
        $project = Projects::where('id', $id)->first();
        return view('Admin.Projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projects $id)
    {
        $request->validate([
            'projectName' => 'required',
            'caption' => 'required',
            'TechnologyStack' => 'required',
            'endDate' => 'required',
        ]);

        $id->name = $request['projectName'];
        $id->url = $request['URL'];
        $id->caption = $request['caption'];
        $id->techmologyStack = $request['TechnologyStack'];
        $id->endDate = $request['endDate'];
        $id->appURL = $request['appURL'];

        $id->save();

        return redirect(route('projects.show'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Projects::where('id', $id)->delete();
        return redirect(route('projects.show'));
    }
}
