<?php

use App\Room;
use Illuminate\Database\Seeder;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Room::create([ 'name' => 'test', 'min_bet' => 10, 'max_bet' => 1000 ]);
        Room::create([ 'name' => 'low', 'min_bet' => 500, 'max_bet' => 5000 ]);
        Room::create([ 'name' => 'medium', 'min_bet' => 1000, 'max_bet' => 10000 ]);
        Room::create([ 'name' => 'hard', 'min_bet' => 10000, 'max_bet' => 100000 ]);

    }
}
