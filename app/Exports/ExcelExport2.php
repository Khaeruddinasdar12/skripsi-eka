<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExcelExport2 implements FromView
{
    public $convert;
	public function __construct($data)
    {
    	$this->convert = $data; 
    }

    public function view(): View
    {
        return view('excel-laporan2', [
            'data' => $this->convert
        ]);
    }
}
