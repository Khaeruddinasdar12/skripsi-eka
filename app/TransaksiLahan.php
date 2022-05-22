<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiLahan extends Model
{
    protected $table = 'transaksi_lahans';
    protected $fillable = [
        'kode', 'jenis', 'periode', 'harga', 'status', 'jenis_bibit', 'jenis_pupuk', 'keterangan', 'sertifikat_tanah', 'surat_pajak', 'surat_perjanjian', 'status_at', 'kecamatan', 'kelurahan', 'alamat', 'titik_koordinat', 'luas_lahan', 'user_id', 'admin_id',
    ];

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function admins()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
        // ->diffForHumans();
        ->translatedFormat('l, d F Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['updated_at'])
        // ->diffForHumans();
        ->translatedFormat('l, d F Y H:i');
    }
}
