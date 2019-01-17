<?php

use App\User;
use Illuminate\Database\Seeder;

class CasinoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User([
            'id' => 0,
            'first_name' => 'casino',
            'last_name' => 'casino',
            'screen_name' => 'casino',
            'referral_reference' => 'casino',
        ]);

        $user->save();
    }
}
