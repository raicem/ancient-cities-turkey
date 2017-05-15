<?php

use App\Ruin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Ruin::class, 5)->create()->each(function ($ruin) {
            factory(App\Link::class, 3)->create(['ruin_id' => $ruin->id]);
        });
    }
}
