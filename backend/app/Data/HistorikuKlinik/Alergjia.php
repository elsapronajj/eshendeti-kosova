<?php

namespace App\Data\HistorikuKlinik;

use Illuminate\Database\Eloquent\Model;

class Alergjia extends Model
{
    protected $table = 'alergjite';

    protected $fillable = [
        'dosje_id', 'substanca', 'ashpersia',
    ];

    public function dosja()
    {
        return $this->belongsTo(Dosja::class, 'dosje_id');

    }
}
