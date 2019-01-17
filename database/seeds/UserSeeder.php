<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Влад',
            'last_name' => 'Кабанцов',
            'screen_name' => 'id31357193',
            'photo' => 'https://pp.userapi.com/c630018/v630018193/4c9e0/7gwa9D-ObGw.jpg?ava=1',
            'vk_id' => 31357193,
            'referral_reference' => 'e3RwS2eeyYU7177jhXcS2wxIegSTl7HGrrDmd3e468iB1FpsNL$2y$10$FkE9KnqkSwZNwssD0T4mZuZBjESTUfiCIb18iaEYMnslQC4M6zmoO',
        ]);

        $user->token()->create([
            'access_token' => '6544c4432276db0d7943b31e63b5b8ebb30a0dd297aef498d25e9c1cb073e6ff5924dd6e8095e1824734d',
            'expires_in' => 86399
        ]);
    }
}
