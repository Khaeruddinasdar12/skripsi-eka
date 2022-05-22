<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\TransaksiBarang;
use App\TransaksiGabah;
use App\TransaksiSawah;
use DB;

class ExcelExport implements FromView
{
	public $convert;
	public function __construct($data)
    {
    	$this->convert = $data; 
    }

    public function view(): View
    {
        return view('excel', [
            'data' => $this->convert
        ]);
    }
}
