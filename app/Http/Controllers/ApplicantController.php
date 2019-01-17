<?php

namespace App\Http\Controllers;

use App\Application;
use App\User;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index()
    {
        $applications = Application::all();
        foreach ($applications as $application) {
            $user = User::where('user_id', $application->user_id);
            $application->user = $user;
        }
        return view('applications')
            ->with(['applications' => $applications]);
    }

    public function accept($applicantId)
    {
        $application = Application::where('id', $applicantId)->first();
        $application->status = true;
        $user = User::where('id', $application->user_id)->first();
        $user->balance()
            ->first()
            ->decrement('amount', $application->amount * 100);

        return redirect('/cabinet');
    }

}
