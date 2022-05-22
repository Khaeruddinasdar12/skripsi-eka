<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Sawah;

class UserTransformer extends TransformerAbstract
{
    public function transform(Sawah $sawah) {
        return [
            'id' => $sawah->id,
            'kecamatan' => $sawah->kecamatan
        ];
    }
}