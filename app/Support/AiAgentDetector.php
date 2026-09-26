<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Decides whether an incoming request should be answered with Markdown
 * instead of the styled HTML page.
 */
class AiAgentDetector
{
    /**
     * Should this request receive the Markdown representation of the CV?
     */
    public function wantsMarkdown(Request $request): bool
    {
        if (! config('ai_agents.enabled', true)) {
            return false;
        }

        return $this->explicitlyRequested($request) || $this->isAiAgent($request);
    }

    /**
     * The caller asked for Markdown out loud: ?format=md, an Accept header,
     * or the X-Requested-Format header.
     */
    public function explicitlyRequested(Request $request): bool
    {
        $parameter = config('ai_agents.query_parameter', 'format');
        $values    = config('ai_agents.query_values', ['md', 'markdown']);

        if (in_array(Str::lower((string) $request->query($parameter)), $values, true)) {
            return true;
        }

        if (Str::contains(Str::lower((string) $request->header('X-Requested-Format')), ['md', 'markdown'])) {
            return true;
        }

        $accept = Str::lower((string) $request->header('Accept'));

        // Browsers send "text/html,..." first; only honour Accept when the
        // caller asks for markdown/plain text without asking for HTML.
        return Str::contains($accept, ['text/markdown', 'text/x-markdown'])
            || ($accept === 'text/plain' || $accept === 'text/plain;charset=utf-8');
    }

    /**
     * Does the User-Agent look like a known AI crawler or scripted client?
     */
    public function isAiAgent(Request $request): bool
    {
        $userAgent = Str::lower((string) $request->userAgent());

        if ($userAgent === '') {
            return false;
        }

        foreach (config('ai_agents.user_agents', []) as $needle) {
            if (str_contains($userAgent, Str::lower($needle))) {
                return true;
            }
        }

        return false;
    }
}
