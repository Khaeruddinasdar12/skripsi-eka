<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sawah extends Model
{
	protected $table = 'sawahs';

    protected $fillable = [
        'titik_koordinat', 'alamat_id', 'kecamatan', 'kelurahan', 'alamat', 'created_by', 'luas_sawah', 'nama',
    ];

    public function alamats()
    {
        return $this->belongsTo('App\Kota', 'alamat_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function tsawahs()
    {
        return $this->hasMany('App\TransaksiSawah', 'sawah_id');
    }
}
