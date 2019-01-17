<?php

namespace App\Http\Controllers;

use App\Events\UserLoggedIn;
use App\User;
use Illuminate\Support\Facades\Hash;

class BaseAuthController extends Controller
{
    public function callbackSocialNetworks($data)
    {

        $user = $data->user;
        $user['referral_reference'] = $this->generateReference(isset($user['vk_id']) ? $user['vk_id'] : $user['ok_id']);
        $user = User::updateOrCreate([
            'screen_name' => $user['screen_name']
        ], $user);
        $user->token()->updateOrCreate([
            'user_id' => $user->id
        ], $data->accessTokenResponseBody);
        if (!$user->balance()->first()) {
            $user->balance()->create([ 'amount' => 5000 ]);
        }
        $user->load('token');
        UserLoggedIn::dispatch($user);

        return $user;
    }

    public function generateReference($id)
    {
        return str_random(50) . Hash::make($id);
    }
}
