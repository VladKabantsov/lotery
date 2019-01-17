<?php

namespace App\Http\Controllers;

use App\CompletedRound;
use App\Http\Requests\SortCompletedRounds;

class CompletedRoundController extends Controller
{
    public function index(SortCompletedRounds $request)
    {
        $data = $request->validated();
        $data['orderBy'] = $data['orderBy'] ? $data['orderBy'] : 'asc';
        $data['sortBy'] = $data['sortBy'] ? $data['sortBy'] : 'id';

        $rounds = CompletedRound::with('user')
                                    ->where('room_id', $data['room_id'])
                                    ->orderBy($data['sortBy'], $data['orderBy'])
                                    ->skip($data['perPage'] * ($data['page'] - 1))
                                    ->take($data['perPage']);

//        $rounds->load('user');
        $result['count'] = $rounds->count();
        $result['rounds'] = $rounds;

        return $result;
    }
}
