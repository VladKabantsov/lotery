<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends BaseAuthController
{
    /**
     * Redirect to O2Auth vk.com
     *
     * @return mixed
     */
    public function vkAuth() {
        return Socialite::with('vkontakte')->redirect();
    }

    /**
     * Handle information about auth user from vk provider
     */
    public function vkUser() {
        $availableFields = ['id', 'email', 'first_name', 'last_name', 'screen_name', 'photo_400_orig', 'photo'];
        Socialite::driver('vkontakte')->fields($availableFields);
        $data = Socialite::driver('vkontakte')->user();
        $data->user[ 'big_photo' ] = $data->user[ 'photo_400_orig' ];
        $data->user[ 'vk_id' ] = $data->user[ 'id' ];
        $user = $this->callbackSocialNetworks($data);

        return view('base')->with('user', $user);
//        return redirect()->route('base', ['any' => 'cabinet'])->with('user', $user);
    }

    /**
     * Redirect to O2Auth vk.com
     *
     * @return mixed
     */
    public function okAuth() {
        return Socialite::with('odnoklassniki')->redirect();
    }

    /**
     * Handle information about auth user from vk provider
     */
    public function okUser() {
        $data = Socialite::driver('odnoklassniki')->user();
        $data->user[ 'ok_id' ] = $data->user[ 'uid' ];
        $data->user[ 'screen_name' ] = $data->user[ 'uid' ];
        $data->user[ 'photo' ] = $data->user[ 'pic_1' ];
        $data->user[ 'big_photo' ] = $data->user[ 'pic_3' ];
        $user = $this->callbackSocialNetworks($data);

        return view('base')->with('user', $user);
//        return redirect()->route('base', ['any' => 'cabinet'])->with('user', $user);
    }


}
