<?php

namespace App\Http\Controllers\User;

use App\Enums\SkillType;
use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use App\Services\SkillService;
use App\Services\SpeakingLanguageService;
use App\Services\UserService;
use App\Services\WorkExpService;
use Barryvdh\DomPDF\Facade\Pdf;

class UserHomeController extends Controller
{
    public function __construct(
        private readonly SkillService $skillService,
        private readonly ProjectService $projectService,
        private readonly SpeakingLanguageService $speakingLanguageService,
        private readonly UserService $userService,
        private readonly WorkExpService $workExpService,
    ) {}

    /**
     * It gets all the projects, skills, speaking languages, work experiences, and the user from the
     * database and then returns the index view with all the data
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View index view is being returned.
     */
    public function index()
    {
        $data = $this->getPortfolioData();

        return view('index', $data);
    }

    /**
     * It gets all the data from the database and passes it to the view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View view pdf.blade.php
     */
    public function pdfview()
    {
        return view('pdf', $this->getPdfData());
    }

    public function pdfview2()
    {
        return view('pdf2', $this->getPdfData());
    }

    /**
     * It takes the data from the database and passes it to the view, then it loads the view and
     * downloads it as a pdf
     *
     * @return \Illuminate\Http\Response pdf file....
     */
    public function downloadPDF()
    {
        set_time_limit(-100);
        $data = $this->getPdfData();
        $pdf = Pdf::loadView('pdf', $data);

        $strArray = explode(' ', $data['user']->fullName);
        $firstName = $strArray[0];
        $lastName = $strArray[1];

        return $pdf->download($firstName . '-' . $lastName . '-C.V.pdf');
    }

    private function getPdfData(): array
    {
        return [
            'projects'   => $this->projectService->getAllOrdered('endDate', 'DESC'),
            'skills'     => $this->skillService->getAll(),
            'sLanguages' => $this->speakingLanguageService->getAll(),
            'user'       => $this->userService->getFirst(),
            'works'      => $this->workExpService->getAll(),
        ];
    }

    private function getPortfolioData(): array
    {
        $types = SkillType::values();
        $skillsData = [];

        foreach ($types as $type) {
            $t = str_replace(" ", "_", $type);
            $skillsData[$t] = $this->skillService->getByType($type);
        }

        return array_merge([
            'projects'   => $this->projectService->getAllOrdered('endDate', 'DESC'),
            'sLanguages' => $this->speakingLanguageService->getAll(),
            'works'      => $this->workExpService->getAllOrdered('startDate', 'DESC'),
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
