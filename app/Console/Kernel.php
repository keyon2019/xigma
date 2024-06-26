<?php

namespace App\Console;

use App\Enum\OrderStatus;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('backup:run --only-db --only-to-disk=s3')->daily()->at('00:00');
        $schedule->command('backup:clean')->daily()->at('00:00');
        $schedule->call(function () {
            Order::where('created_at', '<', Carbon::now()->subMinutes(20))
                ->whereStatus(OrderStatus::PLACED)
                ->update(['status' => OrderStatus::CANCELED]);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
