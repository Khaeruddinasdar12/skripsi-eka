<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiGabah extends Model
{
    protected $table = 'transaksi_gabahs';
    protected $appends = ['jenis'];
    protected $fillable = [
        'jumlah', 'harga', 'alamat', 'kecamatan', 'kelurahan', 'keterangan', 'jenis_bayar', 'bukti', 'status', 'waktu_jemput','gabah_id', 'user_id', 'admin_id', 'sertifikat_tanah',
    ];

    public function admins()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function gabahs()
    {
        return $this->belongsTo('App\Gabah', 'gabah_id');
    }
}
