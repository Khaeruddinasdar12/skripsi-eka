<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;

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
        $data = DB::table('transaksi_barangs')
                ->whereNotNull('transaksi_code')
                ->where('updated_at', '<=', \Carbon\Carbon::now()->subMinutes(2)
                ->toDateTimeString())
                ->get();
                
                foreach ($data as $datas) {
                    $delete_cart = \App\CartTransaksi::where('transaksi_id', $datas->id)->delete();
                    
                    $delete_transaksi = DB::table('transaksi_barangs')->where('id', $datas->id)->delete();
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
