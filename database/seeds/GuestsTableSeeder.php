<?php

use Illuminate\Database\Seeder;
use App\Guest;

class GuestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guest::unsetEventDispatcher();
        factory(Guest::class, 50)->create();
        Guest::setEventDispatcher(new \Illuminate\Events\Dispatcher);
    }
}
