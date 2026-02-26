<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\View;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        return view('Admin.Dashboard.home');
    }
}
