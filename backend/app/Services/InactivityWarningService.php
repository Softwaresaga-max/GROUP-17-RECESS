<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class InactivityWarningService
{

    public function checkInactiveUsers()
    {

        $inactiveUsers = User::where('last_activity', '<', Carbon::now()->subDays(7))
            ->where('is_blacklisted', false)
            ->get();


        foreach ($inactiveUsers as $user) {

            $this->giveWarning($user);

        }

    }



    private function giveWarning(User $user)
    {

        $user->increment('warning_count');


        if ($user->warning_count >= 3) {

            $user->update([
                'is_blacklisted' => true
            ]);

        }

    }

}