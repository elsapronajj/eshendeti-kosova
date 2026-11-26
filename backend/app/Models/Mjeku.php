<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mjeku extends Model
{
    protected $table = 'mjeket';

    protected $fillable = [
        'numri_i_licences', 'titulli', 'emri', 'mbiemri',
        'specializimi', 'statusi_i_licences',
    ];

    public function institucionet()
    {
        return $this->belongsToMany(Institucioni::class, 'mjek_institucion', 'mjek_id', 'institucion_id')
            ->withTimestamps();
    }

    public function vizitat()
    {
        return $this->hasMany(Vizita::class, 'mjek_id');
    }

    public function qasjet()
    {
        return $this->hasMany(Qasja::class, 'mjek_id');
    }

    public function kaLicenceAktive()
    {
        return $this->statusi_i_licences === 'aktive';
    }
}