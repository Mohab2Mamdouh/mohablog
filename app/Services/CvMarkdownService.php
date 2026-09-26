<?php

namespace App\Services;

use App\Enums\SkillType;
use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * Renders the portfolio data as a single Markdown document, so that AI agents
 * browsing the site get clean, structured text instead of styled HTML.
 */
class CvMarkdownService
{
    /**
     * @param  array  $data  The array returned by UserHomeController::getPortfolioData()
     */
    public function render(array $data): string
    {
        $user = $data['user'] ?? null;

        $sections = [
            $this->header($user),
            $this->contact($user),
            $this->summary($user),
            $this->skills($data),
            $this->experience($data['works'] ?? []),
            $this->projects($data['projects'] ?? []),
            $this->languages($data['sLanguages'] ?? []),
            $this->footer(),
        ];

        return implode("\n\n", array_filter($sections)) . "\n";
    }

    private function header($user): string
    {
        if (! $user) {
            return '# CV';
        }

        $lines = ['# ' . $user->fullName];

        if ($user->title) {
            $lines[] = '> ' . $user->title;
        }

        return implode("\n\n", $lines);
    }

    private function contact($user): string
    {
        if (! $user) {
            return '';
        }

        $rows = [];

        $this->addRow($rows, 'Current position', $user->currentPosition);
        $this->addRow($rows, 'Location', $user->address);
        $this->addRow($rows, 'Email', $user->email);
        $this->addRow($rows, 'Phone', $user->phone);
        $this->addRow($rows, 'Years of experience', $user->expYear);
        $this->addRow($rows, 'GitHub', $user->github);
        $this->addRow($rows, 'LinkedIn', $user->linked_in);
        $this->addRow($rows, 'Website', $user->my_site);
        $this->addRow($rows, 'Behance', $user->behance);

        if ($rows === []) {
            return '';
        }

        $table = ["## Contact", '', '| Field | Value |', '| --- | --- |'];

        foreach ($rows as [$label, $value]) {
            $table[] = sprintf('| %s | %s |', $label, $this->escapeCell($value));
        }

        $table[] = '';
        $table[] = 'Download the PDF version: ' . route('downloadPDF');

        return implode("\n", $table);
    }

    private function summary($user): string
    {
        if (! $user || ! $user->profile) {
            return '';
        }

        return "## Summary\n\n" . $this->clean($user->profile);
    }

    private function skills(array $data): string
    {
        $groups = [];

        foreach (SkillType::values() as $type) {
            $key = str_replace(' ', '_', $type);
            $skills = $data[$key] ?? [];

            if (count($skills) === 0) {
                continue;
            }

            $names = [];
            foreach ($skills as $skill) {
                $names[] = $skill->name;
            }

            $groups[] = sprintf('- **%s**: %s', $type, implode(', ', $names));
        }

        if ($groups === []) {
            return '';
        }

        return "## Skills\n\n" . implode("\n", $groups);
    }

    private function experience($works): string
    {
        if (count($works) === 0) {
            return '';
        }

        $blocks = ['## Experience'];

        foreach ($works as $work) {
            $start = $work->startDate ? Carbon::parse($work->startDate)->format('M Y') : null;
            $end   = $work->endDate ? Carbon::parse($work->endDate)->format('M Y') : 'Present';

            $block = ['### ' . $work->title . ' — ' . $work->companyName];

            if ($start) {
                $block[] = '*' . $start . ' – ' . $end . '*';
            }

            if ($work->caption) {
                $block[] = $this->clean($work->caption);
            }

            if ($work->environment) {
                $block[] = '**Environment:** ' . $this->joinList($work->environment);
            }

            $blocks[] = implode("\n\n", $block);
        }

        return implode("\n\n", $blocks);
    }

    private function projects($projects): string
    {
        if (count($projects) === 0) {
            return '';
        }

        $blocks = ['## Projects'];

        foreach ($projects as $project) {
            $block = ['### ' . $project->name];

            $date = $project->endDate ? $project->endDate->format('M Y') : 'Ongoing';
            $block[] = '*' . $date . '*';

            $description = $project->description ?: $project->caption;
            if ($description) {
                $block[] = $this->clean($description);
            }

            if ($project->techmologyStack) {
                $block[] = '**Stack:** ' . $this->joinList($project->techmologyStack);
            }

            $links = [];
            if ($project->link) {
                $links[] = '[Source](' . $project->link . ')';
            }
            if ($project->appURL) {
                $links[] = '[Live](' . $project->appURL . ')';
            }
            if ($links !== []) {
                $block[] = '**Links:** ' . implode(' · ', $links);
            }

            $blocks[] = implode("\n\n", $block);
        }

        return implode("\n\n", $blocks);
    }

    private function languages($languages): string
    {
        if (count($languages) === 0) {
            return '';
        }

        $lines = ['## Languages', ''];

        foreach ($languages as $language) {
            $lines[] = '- ' . $language->languageName
                . ($language->level ? ' — ' . $language->level : '');
        }

        return implode("\n", $lines);
    }

    private function footer(): string
    {
        return "---\n\n"
            . 'This Markdown document is the machine-readable version of '
            . route('portfolio') . ', served automatically to AI agents. '
            . 'Last generated: ' . now()->toDayDateTimeString() . '.';
    }

    /**
     * @param  array<int, array{0: string, 1: string}>  $rows
     */
    private function addRow(array &$rows, string $label, $value): void
    {
        if (filled($value)) {
            $rows[] = [$label, (string) $value];
        }
    }

    /**
     * Turn a comma separated column into a readable inline list.
     */
    private function joinList(string $value): string
    {
        $items = array_filter(array_map('trim', explode(',', $value)));

        return implode(', ', $items);
    }

    /**
     * Collapse whitespace and strip any stray HTML so the output stays valid Markdown.
     */
    private function clean(?string $value): string
    {
        $text = strip_tags((string) $value);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(Str::squish($text));
    }

    private function escapeCell(string $value): string
    {
        return str_replace('|', '\|', $this->clean($value));
    }
}
