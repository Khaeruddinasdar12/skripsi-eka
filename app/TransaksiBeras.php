<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiBeras extends Model
{
    protected $table = 'transaksi_beras';

    protected $fillable = [
        'jumlah', 'harga', 'alamat', 'kecamatan', 'kelurahan', 'keterangan', 'jenis_bayar', 'bukti', 'status', 'beras_id', 'user_id', 'admin_id',
    ];

    public function admins()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function beras()
    {
        return $this->belongsTo('App\Beras', 'beras_id');
    }
}
