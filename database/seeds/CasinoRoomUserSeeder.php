<?php

use App\Room;
use App\User;
use Illuminate\Database\Seeder;

class CasinoRoomUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = Room::all();

        foreach ($rooms as $room) {
            $data = [];
            $data[ 'first_name' ] = $data[ 'last_name' ] = $data[ 'referral_reference' ] = strtoupper($room->name);
            $data[ 'room_id' ] = $room->id;
            $user = new User($data);
            $user->save();
            $user->balance()->create(['amount' => 5000]);
        }
    }
}
