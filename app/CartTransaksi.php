<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartTransaksi extends Model
{
    protected $table = 'cart_transaksis';
    protected $fillable = [
        'jumlah', 'barang_id', 'transaksi_id', 'harga'
    ];

    public function barangs()
    {
        return $this->belongsTo('App\Barang', 'barang_id');
    }

    public function tbarangs()
    {
        return $this->belongsTo('App\TransaksiBarang', 'transaksi_id');
    }

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
        // ->diffForHumans();
        ->translatedFormat('l, d F Y');
    }

    public function getUpdatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['updated_at'])
        // ->diffForHumans();
        ->translatedFormat('l, d F Y');
    }
}
