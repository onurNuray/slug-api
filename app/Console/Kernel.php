<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $users = User::all();
        foreach ($users as $user) {
            $process = $user->local[3];
            $hour = substr($user->local, 4, strlen($user->local));
            $hour = explode(":", $hour);
            $minute = $hour[1] ?? 0;
            $hour = $hour[0];
            if($process == '+') {
                $hour = 10 + $hour;
            } else {
                $hour = 10 - $hour;
            }
            $schedule->command('mail: send ' . $user->email)->dailyAt($hour . ':' . $minute);
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
