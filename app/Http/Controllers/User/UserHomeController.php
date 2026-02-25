<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

// Models
use App\Models\Projects;
use App\Models\Skill;
use App\Models\SpeakingLanguage;
use App\Models\User;
use App\Models\WorkExp;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


class UserHomeController extends BaseController
{

    /**
     * It gets all the projects, skills, speaking languages, work experiences, and the user from the
     * database and then returns the index view with all the data
     *
     * @return The index view is being returned.
     */
    public function index()
    {
        $types = ['Backend', 'Fontend', 'Database', 'Prior Knowledge', 'Little Knowledge',  'Other Skills'];

        foreach ($types as $type ) {
            $t = str_replace(" ", "_", $type);
            $$t = Skill::where('type', "=", $type)->get();
        }


        $projects = Projects::orderBy('endDate', 'DESC')->get();
        $sLanguages = SpeakingLanguage::all();
        $user = User::first();
        $works = WorkExp::orderBy('startDate', 'DESC')->get();
        return view('index',[
            'projects' => $projects,
            'sLanguages' => $sLanguages,
            'works' => $works,
            'user' => $user,
            'Backend' => $Backend,
            'Fontend' => $Fontend,
            'Database' => $Database,
            'Prior_Knowledge' => $Prior_Knowledge,
            'Little_Knowledge' => $Little_Knowledge,
            'Other_Skills' => $Other_Skills,
        ]);
    }

    /**
     * It gets all the data from the database and passes it to the view
     *
     * @return The view pdf.blade.php
     */
    public function pdfview()
    {
        $projects = Projects::orderBy('endDate', 'DESC')->get();
        $skills = Skill::all();
        $sLanguages = SpeakingLanguage::all();
        $user = User::first();
        $works = WorkExp::all();

        return view('pdf', compact('projects', 'skills', 'sLanguages', 'user', 'works'));
    }

    public function pdfview2()
    {
        $projects = Projects::orderBy('endDate', 'DESC')->get();
        $skills = Skill::all();
        $sLanguages = SpeakingLanguage::all();
        $user = User::first();
        $works = WorkExp::all();

        return view('pdf2', compact('projects', 'skills', 'sLanguages', 'user', 'works'));
    }

    /**
     * It takes the data from the database and passes it to the view, then it loads the view and
     * downloads it as a pdf
     *
     * @return a pdf file.
     */
    public function downloadPDF()
    {
        set_time_limit(-100);
        $projects = Projects::orderBy('endDate', 'DESC')->get();
        $skills = Skill::all();
        $sLanguages = SpeakingLanguage::all();
        $user = User::first();
        $works = WorkExp::all();

        $pdf = Pdf::loadView('pdf', compact('projects', 'skills', 'sLanguages', 'user', 'works'));

        $strArray = explode(' ',$user->fullName);
        $firstName = $strArray[0];
        $lastName = $strArray[1];
        return $pdf->download($firstName . '-' . $lastName  . '-C.V.pdf');
    }

    private function getPortfolioData()
    {
        $types = ['Backend', 'Fontend', 'Database', 'Prior Knowledge', 'Little Knowledge',  'Other Skills'];
        $skillsData = [];
        foreach ($types as $type) {
            $t = str_replace(" ", "_", $type);
            $skillsData[$t] = Skill::where('type', "=", $type)->get();
        }

        return array_merge([
            'projects' => Projects::orderBy('endDate', 'DESC')->get(),
            'sLanguages' => SpeakingLanguage::all(),
            'user' => User::first(),
            'works' => WorkExp::orderBy('startDate', 'DESC')->get(),
        ], $skillsData);
    }

    public function templateTerminal()
    {
        return view('templates.terminal', $this->getPortfolioData());
    }

    public function templateCodeFirst()
    {
        return view('templates.code-first', $this->getPortfolioData());
    }

    public function templateArchitecture()
    {
        return view('templates.architecture', $this->getPortfolioData());
    }

    public function templateMinimalist()
    {
        return view('templates.minimalist', $this->getPortfolioData());
    }
}
