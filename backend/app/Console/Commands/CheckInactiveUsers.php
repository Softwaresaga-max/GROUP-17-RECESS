<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\InactivityWarningService;


class CheckInactiveUsers extends Command
{

    protected $signature = 'users:check-inactivity';


    protected $description = 'Check inactive users and issue warnings';



    public function handle(InactivityWarningService $service)
    {

        $service->checkInactiveUsers();


        $this->info('Inactive users checked successfully.');

    }

}