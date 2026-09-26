<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI Agent Detection
    |--------------------------------------------------------------------------
    |
    | When one of these agents requests the CV page we serve a plain Markdown
    | document instead of the styled HTML template, so the data is trivial to
    | parse. Matching is a case-insensitive substring check on the User-Agent.
    |
    */

    'enabled' => env('AI_AGENT_MARKDOWN', true),

    'user_agents' => [
        // OpenAI
        'gptbot',
        'oai-searchbot',
        'chatgpt-user',
        'chatgpt',
        // Anthropic
        'claudebot',
        'claude-user',
        'claude-searchbot',
        'anthropic-ai',
        // Google
        'google-extended',
        'googleother',
        'gemini',
        // Perplexity
        'perplexitybot',
        'perplexity-user',
        // Others
        'bingbot-chat',
        'ccbot',
        'cohere-ai',
        'youbot',
        'bytespider',
        'amazonbot',
        'applebot-extended',
        'meta-externalagent',
        'meta-externalfetcher',
        'facebookbot',
        'diffbot',
        'timpibot',
        'omgili',
        'firecrawl',
        'mistralai-user',
        'duckassistbot',
        // Generic scripted clients that are almost always agents/tools
        'python-requests',
        'langchain',
        'llamaindex',
        'node-fetch',
        'httpx',
        'aiohttp',
    ],

    /*
    | A request may also opt in explicitly, without pretending to be a bot:
    |   - ?format=md  (or ?format=markdown)
    |   - Accept: text/markdown
    |   - X-Requested-Format: markdown
    */
    'query_parameter' => 'format',
    'query_values'    => ['md', 'markdown', 'text'],

];
