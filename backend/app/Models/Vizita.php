<?php

namespace App\Models;

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
}
