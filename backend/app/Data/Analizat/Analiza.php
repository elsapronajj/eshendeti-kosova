<?php

namespace App\Data\Analizat;

use App\Data\HistorikuKlinik\Vizita;
use Illuminate\Database\Eloquent\Model;

class Analiza extends Model
{
    protected $table = 'analizat';

    protected $fillable = [
        'vizite_id', 'lloji', 'rezultati', 'njesia',
        'kufiri_i_poshtem', 'kufiri_i_siperm', 'data', 'statusi',
    ];

    public function vizita()
    {
        return $this->belongsTo(Vizita::class, 'vizite_id');
    }

    public function eshteJashteKufijve()
    {
        return $this->rezultati < $this->kufiri_i_poshtem || $this->rezultati > $this->kufiri_i_siperm;
    }
}