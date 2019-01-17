<?php

use App\User;
use Illuminate\Database\Seeder;

class UserBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->balance()->create(['amount' => rand(1, 100) * 1000]);
        }
    }
}
