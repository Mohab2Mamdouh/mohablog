<?php

namespace App\Http\Controllers\User;

use App\Enums\SkillType;
use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use App\Services\SkillService;
use App\Services\SpeakingLanguageService;
use App\Services\UserService;
use App\Services\CvMarkdownService;
use App\Services\WorkExpService;
use App\Support\AiAgentDetector;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class UserHomeController extends Controller
{
    public function __construct(
        private readonly SkillService $skillService,
        private readonly ProjectService $projectService,
        private readonly SpeakingLanguageService $speakingLanguageService,
        private readonly UserService $userService,
        private readonly WorkExpService $workExpService,
        private readonly CvMarkdownService $cvMarkdownService,
        private readonly AiAgentDetector $aiAgentDetector,
    ) {
        parent::__construct();
    }

    /**
     * It gets all the projects, skills, speaking languages, work experiences, and the user from the
     * database and then returns the index view with all the data
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View index view is being returned.
     */
    public function index(Request $request)
    {
        return $this->respondWithTemplate($request, 'index');
    }

    /**
     * It gets all the data from the database and passes it to the view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View view pdf.blade.php
     */
    public function PDFView()
    {
        return view('pdf', $this->getPortfolioData());
    }

    public function PDFView2()
    {
        return view('pdf2', $this->getPortfolioData());
    }

    /**
     * It takes the data from the database and passes it to the view, then it loads the view and
     * downloads it as a pdf
     *
     * @return \Symfony\Component\HttpFoundation\Response pdf file....
     */
    public function downloadPDF()
    {
        $data = $this->getPortfolioData();
        $data['footerDate'] = now()->format('F Y');

        $pdf = PDF::loadView($data['user']->layout, $data, [], [
            'mode'           => 'utf-8',
            'format'         => 'A4',
            'margin_top'     => 5,
            'margin_bottom'  => 23,   // mm — must exceed margin_footer, or body
            'margin_left'    => 0,    //      text prints over the footer band
            'margin_right'   => 0,
            'margin_header'  => 0,
            'margin_footer'  => 9,    // mm — footer baseline from the paper edge
        ]);

        return $pdf->download(str_replace(' ', '-',$data['user']->fullName). '-C.V.pdf');
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
            'projects'   => $this->projectService->getAllOrdered(),
            'sLanguages' => $this->speakingLanguageService->getAll(),
            'user'       => $this->userService->getFirst(),
            'works'      => $this->workExpService->getAllOrdered('startDate', 'DESC'),
        ], $skillsData);
    }

    public function templateTerminal(Request $request)
    {
        return $this->respondWithTemplate($request, 'templates.terminal');
    }

    public function templateCodeFirst(Request $request)
    {
        return $this->respondWithTemplate($request, 'templates.code-first');
    }

    public function templateArchitecture(Request $request)
    {
        return $this->respondWithTemplate($request, 'templates.architecture');
    }

    public function templateMinimalist(Request $request)
    {
        return $this->respondWithTemplate($request, 'templates.minimalist');
    }

    /**
     * The CV as a plain Markdown document. Served explicitly at /cv.md and
     * automatically on any CV template route when an AI agent is browsing.
     *
     * Pass ?raw=1 to get it as text/plain, which browsers render inline
     * instead of downloading.
     */
    public function cvMarkdown(Request $request): Response
    {
        return $this->cvMarkdownResponse(
            $request->boolean('raw') ? 'text/plain' : 'text/markdown'
        );
    }

    /**
     * Human-facing preview: shows the exact Markdown an AI agent receives.
     */
    public function cvMarkdownPreview()
    {
        $markdown = $this->cvMarkdownService->render($this->getPortfolioData());

        return view('cv-markdown', [
            'markdown' => $markdown,
            'lines'    => substr_count($markdown, "\n") + 1,
            'bytes'    => strlen($markdown),
        ]);
    }

    /**
     * Render an HTML template, unless an AI agent asked for the page — then
     * hand back the Markdown version of the same CV.
     */
    private function respondWithTemplate(Request $request, string $view): Response
    {
        if ($this->aiAgentDetector->wantsMarkdown($request)) {
            return $this->cvMarkdownResponse();
        }

        return response()
            ->view($view, $this->getPortfolioData())
            ->header('Vary', 'User-Agent, Accept');
    }

    private function cvMarkdownResponse(string $contentType = 'text/markdown'): Response
    {
        $markdown = $this->cvMarkdownService->render($this->getPortfolioData());

        return response($markdown, 200, [
            'Content-Type' => $contentType . '; charset=UTF-8',
            'Vary'         => 'User-Agent, Accept',
            'X-Robots-Tag' => 'all',
        ]);
    }
}
