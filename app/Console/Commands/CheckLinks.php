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
                $client->request('GET', $link->url, ['timeout' => 20]);
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                $failedLinks[] = $link->url;
            }
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
