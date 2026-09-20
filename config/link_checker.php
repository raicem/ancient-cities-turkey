<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Link Checker
    |--------------------------------------------------------------------------
    |
    | Tunables for the links:check command. The per-host delay keeps the
    | checker from tripping bot protection and rate limits, and the retry
    | settings give flaky servers a second chance before a link is
    | reported as unreachable.
    |
    */

    'host_delay_ms' => (int) env('LINK_CHECKER_HOST_DELAY_MS', 2000),

    'max_attempts' => (int) env('LINK_CHECKER_MAX_ATTEMPTS', 2),

    'retry_delay_seconds' => (int) env('LINK_CHECKER_RETRY_DELAY_SECONDS', 3),

    /*
    | Hosts that answer 401/403/429 to every scripted request (WAF, bot
    | protection, aggressive rate limits) while working fine in a real
    | browser. Their blocked/rate-limited results are counted but not
    | listed in the Slack report. Dead and SSL results are still reported.
    |
    | @var list<string>
    */
    'known_blocked_hosts' => [
        'atlasobscura.com',
        'academia.edu',
        'britannica.com',
        'eksisozluk.com',
        'metmuseum.org',
        'nytimes.com',
        'petersommer.com',
        'thoughtco.com',
        'tripadvisor.co.uk',
        'tripadvisor.com',
        'tripadvisor.com.tr',
        'umich.edu',
        'unesco.org',
        'web.archive.org',
    ],
];
