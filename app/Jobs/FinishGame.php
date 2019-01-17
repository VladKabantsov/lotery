<?php

namespace App\Jobs;

use App\CurrentGame;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class FinishGame implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->finishGame($this->id);
        \App\Events\FinishGame::dispatch($data['game'], $data['winner']);
    }

    public function finishGame($roomId)
    {
        return DB::transaction(function () use ($roomId) {

            $result = $this->calculateWinner($roomId);
            $wonBet = $result['winner'];
            $casinoPrize = ($result['amount'] - $wonBet->bet) * User::casinoPercent / 100;
            $userPrize = $result['amount'] - $casinoPrize;
            $casinoUser = $wonBet->room()
                ->first()
                ->user()
                ->first();
            $winner = $wonBet->user()
                ->first();
            $casinoUser->balance()
                ->first()
                ->decrement('amount', $userPrize);
            $winner->balance()
                ->first()
                ->increment('amount', $userPrize);
            $completedRound = $winner->completedRounds()->create([
                'win' => $userPrize,
                'chance' => $wonBet->chance,
                'bet' => $wonBet->bet,
                'room_id' => $roomId,
            ]);
            CurrentGame::where('room_id', $roomId)->delete();

            return [
                'game' => $completedRound,
                'winner' => $winner,
            ];
        });
    }

    public function calculateWinner($roomId)
    {
        $data = [];
        $amount = 0;
        $bets = CurrentGame::where('room_id', $roomId)->get();

        foreach ($bets as $value) {
            $amount += $value->bet;
        }

        $data['amount'] = $amount;

        $bets = $bets->map(function ($value) use ($amount) {

            $value->chance = ($value->bet * 100) / $amount;

            return $value;
        });

        $randVal = rand(1, 100);
        $weight = 0;

        foreach ($bets as $idx => $value) {
            $weight += $value->chance;

            if ($weight >= $randVal) {
                $data['winner'] = $bets[$idx];
                break;
            }
        }

        return $data;
    }
}
