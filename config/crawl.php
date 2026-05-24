<?php

return [
    'main_admin_id' => (int) env('CRAWL_MAIN_ADMIN_ID', 1),

    'allowed_hosts' => [
        'linkedin.com',
        'www.linkedin.com',
        'jobstreet.co.id',
        'www.jobstreet.co.id',
        'id.indeed.com',
        'www.indeed.com',
    ],

    'daily_limit' => (int) env('CRAWL_DAILY_LIMIT', 3),
    'cooldown_minutes' => (int) env('CRAWL_COOLDOWN_MINUTES', 240),
    'max_urls_per_run' => (int) env('CRAWL_MAX_URLS_PER_RUN', 5),
    'timeout_seconds' => (int) env('CRAWL_TIMEOUT_SECONDS', 15),
    'retry_times' => (int) env('CRAWL_RETRY_TIMES', 2),
    'default_expired_days' => (int) env('CRAWL_DEFAULT_EXPIRED_DAYS', 30),
    'job_title_prefix' => env('CRAWL_JOB_TITLE_PREFIX', 'Hasil Crawl: '),
    'default_source_urls' => array_values(array_filter(array_map('trim', explode(',', env('CRAWL_DEFAULT_SOURCE_URLS', ''))))),
];
