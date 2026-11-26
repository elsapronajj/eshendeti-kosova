<?php

namespace App\Data\HistorikuKlinik;

use Illuminate\Database\Eloquent\Model;

class Terapia extends Model
{
    protected $table = 'terapite';

    protected $fillable= [
        'vizite_id', 'medikamenti', 'dozimi', 'data_e_fillimit', 'data_e_perfundimit',
    ];

    public function vizita()
    {
        return $this->belongsTo(Vizita::class, 'vizite_id');
    }

    public function eshteAktive()
    {
        return $this->data_e_perfundimit === null
          || $this->data_e_perfundimit >= now()->toDateString();
    }
}
