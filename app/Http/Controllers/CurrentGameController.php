<?php

namespace App\Http\Controllers;

use App\CurrentGame;
use App\Events\MakeBet;
use App\Events\StartGame;
use App\Http\Requests\StoreBet;
use App\Jobs\FinishGame;
use App\Room;
use App\User;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Mockery\Exception;

class CurrentGameController extends Controller
{

    public function store(StoreBet $request)
    {

        try {
            DB::transaction(function () use ($request) {

                $data = $request->validated();
                $user = $request->get('user');
                if (CurrentGame::where('user_id', $user->id)->get()->count()) {

                    throw new Exception('You can`t make bet twice!');
                }
                $room = Room::where('id', $data['room_id'])->first();
                $roomUser = $room->user()->first();

                if ($data['bet'] <= $room->max_bet && $data['bet'] >= $room->min_bet) {

                    $userBalance = $user->balance()->first()->amount;
                    if ($userBalance < $data['bet']) {

                        throw new Exception('You don`t have enough money');
                    }
                    $user->balance()
                        ->first()
                        ->decrement('amount', $data['bet']);
                    $roomUser->balance()
                        ->first()
                        ->increment('amount', $data['bet']);
                    $bet = $user->bet()->create($data);
                    MakeBet::dispatch($bet, $user);
                    if (CurrentGame::where('room_id', $room->id)->get()->count() === 2) {
                        StartGame::dispatch(Carbon::now());
                        FinishGame::dispatch($room->id)->delay(now()->addSeconds(30));
                    }
                } else {

                    throw new Exception('Please make bet between ' . $room->min_bet . ' and ' . $room->max_bet, 400);
                }
            });
        } catch (Exception $exception) {

            return response($exception->getMessage(), 400);
        }

        return response('Successfully', 200);
    }

    public function index($roomId) {

        return CurrentGame::with('user')->where('room_id', $roomId)->get();
    }



}
