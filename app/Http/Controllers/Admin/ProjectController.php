<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectOrderRequest;
use App\Http\Requests\ProjectRequest;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectService $projectService
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index()
    {
        $projects = $this->projectService->getAll();
        return view('Admin.Projects.projects', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function create()
    {
        return view('Admin.Projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ProjectRequest $request)
    {
        $this->projectService->create($request);
        return redirect(route('projects.show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function edit($id)
    {
        $project = $this->projectService->getById($id);
        return view('Admin.Projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ProjectRequest $request, int $id)
    {
        $this->projectService->update($id, $request);
        return redirect(route('projects.show'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this->projectService->delete($id);
        return redirect(route('projects.show'));
    }

    public function toggleCV(int $id)
    {
        $project = $this->projectService->toggleCV($id);

        return response()->json(['show_at_cv' => $project->show_at_cv]);
    }

    /**
     * Show the project ordering page.
     */
    public function order()
    {
        $projects = $this->projectService->getAllOrdered('order', 'ASC');
        return view('Admin.Projects.order', compact('projects'));
    }

    /**
     * Save the new project order (AJAX).
     */
    public function updateOrder(ProjectOrderRequest $request)
    {
        $this->projectService->updateOrder($request->validated('order'));

        return response()->json(['success' => true]);
    }
}
