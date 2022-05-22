<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use DateTimeInterface;
class TransaksiBarang extends Model
{   
    protected $table = 'transaksi_barangs';
    protected $fillable = [
        'jumlah', 'harga', 'alamat', 'kecamatan', 'kelurahan', 'keterangan', 'jenis_bayar', 'bukti', 'status', 'barang_id', 'user_id', 'admin_id',
    ];

    public function admins()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function barangs()
    {
        return $this->belongsTo('App\Barang', 'barang_id');
    }

    public function items()
    {
        return $this->hasMany('App\CartTransaksi', 'transaksi_id', 'id')->orderBy('created_at', 'desc');
    }

    // protected function serializeDate(DateTimeInterface $date)
    // {
    //     return $date->format('Y-m-d H:i:s');
    // }
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
