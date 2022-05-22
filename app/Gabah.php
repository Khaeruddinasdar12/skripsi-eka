<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gabah extends Model
{
    protected $table = 'gabahs';
    protected $fillable = [
        'nama', 'harga', 'admin_id'
    ];

    public function admins()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }
}
