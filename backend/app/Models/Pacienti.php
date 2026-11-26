<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pacienti extends Model
{
    protected $table = 'pacientet';

    protected $fillable = [
        'numri_personal', 'emri', 'mbiemri', 'data_e_lindjes', 'gjinia',
        'grupi_gjakut', 'telefoni',
 
    ];
 
    public function dosja()
    {
        return $this->hasOne(Dosja::class, 'pacient_id');
    }

    public function autorizimet()
    {
        return $this->hasMany(Autorizimi::class, 'pacient_id');
    }
}
