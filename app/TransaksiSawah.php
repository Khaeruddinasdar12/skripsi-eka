<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiSawah extends Model
{
    protected $table = 'transaksi_sawahs';
    protected $fillable = [
        'periode', 'jenis', 'harga', 'admin_id', 'sawah_id', 'jenis_bibit', 'jenis_pupuk', 'periode_tanam', 'keterangan', 'status', 'status_at', 'sertifikat_tanah',
    ];

    public function sawahs()
    {
        return $this->belongsTo('App\Sawah', 'sawah_id');
    }

    public function admins()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }
}
