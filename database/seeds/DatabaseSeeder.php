<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(CasinoUserSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserBalanceSeeder::class);
        $this->call(RoomsSeeder::class);
        $this->call(CasinoRoomUserSeeder::class);
    }
}
