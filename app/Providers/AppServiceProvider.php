<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\TransaksiLahan;
use App\TransaksiBarang;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {   
        if ($request->is('api/*') || $request->is('/')) {
        
        } else {
            $mt = TransaksiLahan::where('jenis', 'mt')
            ->where('status', null)
            ->count(); //jumlah transaksi modal tanam
            $gs = TransaksiLahan::where('jenis', 'gs')
            ->where('status', null)

            ->count(); // jumlah transaksi gadai sawah
            $brg = TransaksiBarang::where('status', '0')
            ->whereNotNull('bukti')
            ->count(); // jumlah transaksi barang
            View::share('mt', $mt);
            View::share('gs', $gs);
            View::share('brg', $brg);
        }
    }
}
