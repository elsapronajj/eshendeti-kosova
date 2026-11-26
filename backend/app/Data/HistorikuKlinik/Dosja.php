<?php

namespace App\Data\HistorikuKlinik;

use App\Data\Autorizimet\Qasja;
use App\Data\Shared\Pacienti;
use Illuminate\Database\Eloquent\Model;

class Dosja extends Model
{
    protected $table = 'dosjet';

    protected $fillable= [
        'pacient_id', 'data_e_krijimit', 'data_e_perditesimit',
    ];

    public function pacienti()
    {
        return $this->belongsTo(Pacienti::class, 'pacient_id');
    }

    public function alergjite()
    {
        return $this->hasMany(Alergjia::class, 'dosje_id');
    }

    public function vizitat()
    {
        return $this->hasMany(Vizita::class, 'dosje_id');
    }

    public function qasjet()
    {
        return $this->hasMany(Qasja::class, 'dosje_id');
    }
}

