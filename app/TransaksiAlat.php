<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiAlat extends Model
{
	protected $table = 'transaksi_alats';
    protected $fillable = [
        'jumlah', 'harga', 'alamat', 'kecamatan', 'kelurahan', 'keterangan', 'jenis_bayar', 'bukti', 'status', 'alat_id', 'user_id', 'admin_id',
    ];

    public function admins()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function alats()
    {
        return $this->belongsTo('App\Alat', 'alat_id');
    }
}
