<?php

namespace App\Data\HistorikuKlinik;

use App\Data\Analizat\Analiza;
use App\Data\Shared\Institucioni;
use App\Data\Shared\Mjeku;
use Illuminate\Database\Eloquent\Model;

class Vizita extends Model
{
    protected $table = 'vizitat';

    protected $fillable = [
        'dosje_id', 'mjek_id', 'institucion_id', 'data', 'lloji', 
        'arsyeja', 'pershkrimi',
    ];

    public function dosja()
    {
        return $this->belongsTo(Dosja::class, 'dosje_id');
    }

    public function mjeku()
    {
        return $this->belongsTo(Mjeku::class, 'mjek_id');
    }

    public function institucioni()
    {
        return $this->belongsTo(Institucioni::class, 'institucion_id');
    }

    public function analizat()
    {
        return $this->hasMany(Analiza::class, 'vizite_id');
    }

    public function diagnozat()
    {
        return $this->hasMany(Diagnoza::class, 'vizite_id');
    }

    public function terapite()
    {
        return $this->hasMany(Terapia::class, 'vizite_id');
    }
}
