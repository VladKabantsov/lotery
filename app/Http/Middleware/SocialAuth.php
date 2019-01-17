<?php

namespace App\Http\Middleware;

use App\Token;
use Carbon\Carbon;
use Closure;
use function MongoDB\BSON\toJSON;

class SocialAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();
        $tokenFromDB = Token::where('access_token', $token)->first();

        if (!$tokenFromDB) {

            return response('Unauthorized', 401);
        }

        $currentDate = Carbon::now();
        $expireAt = clone Carbon::parse($tokenFromDB->created_at)->addSeconds($tokenFromDB->expires_in);

        if (!$token || ($currentDate > $expireAt)) {

            $tokenFromDB->delete();
            return response('Unauthorized', 401);
        }

        $user = $tokenFromDB->user()->first();
        $request->request->add(['user' => $user]);

        return $next($request);
    }
}
