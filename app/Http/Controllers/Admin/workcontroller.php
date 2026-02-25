<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\WorkExp;
use Illuminate\Http\Request;

class workcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $works = WorkExp::all();
        return view('Admin.works.works', compact('works'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.works.create');
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
            'companyName' => 'required',
            'title' => 'required',
            'caption' => 'required',
            'environment' => 'required',
            'startDate' => 'required',
        ]);

        $exp = new WorkExp();
        $exp->companyName = $request['companyName'];
        $exp->title = $request['title'];
        $exp->caption = $request['caption'];
        $exp->environment = $request['environment'];
        $exp->startDate = $request['startDate'];

        if ($request['present'] != null) {
            $exp->current = $request['present'];
        } else {
            $exp->endDate = $request['endDate'];
        }

        $exp->save();

        return redirect(route('works.show'));
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
        $work = WorkExp::where('id', $id)->first();
        return view('Admin.works.edit', compact('work'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkExp $id)
    {
        $request->validate([
            'companyName' => 'required',
            'title' => 'required',
            'caption' => 'required',
            'environment' => 'required',
            'startDate' => 'required',
        ]);

        // $exp = new WorkExp();
        // $exp = WorkExp::where('id', $id)->first();
        $id->companyName = $request['companyName'];
        $id->title = $request['title'];
        $id->caption = $request['caption'];
        $id->environment = $request['environment'];
        $id->startDate = $request['startDate'];

        if ($request['Present'] != null) {
            $id->current = $request['Present'];
            $id->endDate = null;
        } else {
            $id->endDate = $request['endDate'];
            $id->current = null;
        }

        $id->save();

        return redirect(route('works.show'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $work = WorkExp::where('id', $id)->delete();
        return redirect(route('works.show'));
    }
}
