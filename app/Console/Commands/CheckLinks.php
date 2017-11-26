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
        $links = Link::all()->take(3);

        $results = [
            'failed' => [],
            'moved' => [],
        ];

        foreach ($links as $link) {
            $url = $link->url;

            $this->info('Checking link: ' . $url);

            try {
                $res = $client->request('GET', $url, ['allow_redirects' => false, 'timeout' => 20]);
                $statusCode = $res->getStatusCode();
                if (substr($statusCode, 0, 1) === '3') {
                    $this->info('This have been moved to somewhere else: ' . $url);
                    $results['moved'][] = $url;
                }
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                $this->info('This may not be accesible anymore: ' . $url);
                $results['failed'][] = $url;
            }
        }

        $message = [
            'text' => 'Bu linklere ulaşılamıyor',
            'attachments' => [
                ['text' => implode(' \n ', $results['failed'])]
            ],
            'channel' => '#genel'
        ];

        var_dump(json_encode($message));
        die;

        $client->request('POST', 'https://hooks.slack.com/services/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', [
            'json' => $message,
        ]);
    }
}
