<?php

namespace App\Http\Controllers;

use App\Events\MakeBet;
use stdClass;

class SpaController extends Controller
{
    public function index()
    {
        $user = session('user');

        return view('base')->with('user', $user);
    }
}
