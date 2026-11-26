<?php

namespace App\Data\HistorikuKlinik;

use Illuminate\Database\Eloquent\Model;

class Diagnoza extends Model
{
    protected $table = 'diagnozat';

    protected $fillable= [
        'vizite_id', 'kodi', 'pershkrimi', 'data', 'statusi',
    ];

    public function vizita()
    {
        return $this->belongsTo(Vizita::class, 'vizite_id');
    }
}
