<?php

namespace App\Console;

use App\Models\Transaction;
use App\Models\TransactionCashOut;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $transaction = Transaction::with('transactionProduct')
        ->where('status', 'Settlement')
        ->get();
        // dd($transaction);

        foreach ($transaction as $key => $value) {
            foreach ($value->transactionProduct as $key => $values) {
                $data = array(
                    'user_id' => $values->product->user_id,
                    'transaction_id' => $values->transaction_id,
                    'status' => 'Pending',
                );
                TransactionCashOut::create($data);
            }
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
