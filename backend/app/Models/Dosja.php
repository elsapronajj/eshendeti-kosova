<?php

namespace App\Models;

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
}

