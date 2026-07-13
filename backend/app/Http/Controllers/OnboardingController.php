<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    // Show onboarding page
    public function index(Request $request)
    {
        $step = session('onboarding_step', 1);

        return view('onboarding.index', compact('step'));
    }

    // Move to next step
    public function next(Request $request)
    {
        $step = session('onboarding_step', 1);

        if ($step < 3) {
            session(['onboarding_step' => $step + 1]);
        }

        return redirect()->route('onboarding');
    }

    // Move back step
    public function back(Request $request)
    {
        $step = session('onboarding_step', 1);

        if ($step > 1) {
            session(['onboarding_step' => $step - 1]);
        }

        return redirect()->route('onboarding');
    }

    // Finish onboarding
    public function complete(Request $request)
{
    $user = Auth::user();

    $action = $request->input('action'); 
    // accept or decline

    if ($action === 'accept') {
        $user->onboarding_completed = true;
        $user->onboarding_status = 'accepted';
        $user->save();

        return redirect()->route('dashboard');
    }

    if ($action === 'decline') {
        $user->onboarding_status = 'rejected';
        $user->save();

        Auth::logout();

        return redirect('/login')->withErrors([
            'access' => 'Account rejected due to onboarding refusal.'
        ]);
    }

    return back();
}
}