<?php

namespace App\Console\Commands;

use App\City;
use App\Ruin;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates the sitemap';

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
    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/en/about')->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)->addAlternate('/tr/hakkinda',
                'tr'));

        $ruins = Ruin::all();

        $ruins->each(function (Ruin $ruin) use ($sitemap) {
            $sitemap->add(
                Url::create("/en/{$ruin->slug}")
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->addAlternate("/tr/{$ruin->slug}", 'tr')
            );
        });

        $cities = City::all();

        $cities->each(function (City $city) use ($sitemap) {
            $sitemap->add(
                Url::create("en/ancient-cities-in{$city->slug}/")
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->addAlternate("/tr/{$city->slug}-antik-kentleri", 'tr')
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
