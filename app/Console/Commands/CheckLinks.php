<?php

namespace App\Console\Commands;

use App\Link;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class CheckLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks links in the system about their availability.';

    /**
     * Execute the console command.
     */
    public function handle(Client $client): void
    {
        $links = Link::all();

        $failedLinks = [];

        foreach ($links as $link) {
            $this->info('Checking link: ' . $link->url);
            try {
                $response = $client->request('GET', $link->url, [
                    'timeout' => 20,
                    'http_errors' => false,
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36',
                        'Accept' => 'text/html,application/xhtml+xml',
                    ],
                ]);

                if ($response->getStatusCode() >= 400) {
                    $failedLinks[] = $link->url;
                }
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                $failedLinks[] = $link->url;
            }
        }

        if (empty($failedLinks)) {
            return;
        }

        $message = [
            'text' => 'Bu linklere ulaşılamıyor',
            'attachments' => [
                ['text' => implode(" \n ", $failedLinks)],
            ],
            'channel' => '#genel',
        ];

        $client->request('POST', config('services.slack.webhook'), [
            'json' => $message,
        ]);
    }
}
