<?php

namespace App\Console\Commands;

use App\Link;
use Illuminate\Console\Command;
use function GuzzleHttp\json_encode;

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(\GuzzleHttp\Client $client)
    {
        $links = Link::all();
        
        $failedLinks = [];

        foreach ($links as $link) {
            $this->info('Checking link: ' . $link->url);
            try {
                $res = $client->request('GET', $link->url, ['timeout' => 20]);
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                $failedLinks[] = $link->url;
            }
        }

        $message = [
            'text' => 'Bu linklere ulaşılamıyor',
            'attachments' => [
                ['text' => implode(" \n ", $results['failed'])]
            ],
            'channel' => '#genel'
        ];

        $client->request('POST', config('services.slack.webhook'), [
            'json' => $message,
        ]);
    }
}
