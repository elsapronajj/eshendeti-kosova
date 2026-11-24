<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institucioni extends Model
{
    protected $table='institucionet';

    protected$fillable=[
        'kodi', 'emri', 'qyteti', 'telefoni', 'lloji', 'numri_shtreterve', 'komuna',
    ];
    
    public function eshteSpital(){
        return $this->lloji === 'spital';
    }
    public function eshteQkmf(){
        return $this->lloji === 'qkmf';
    }
    
}
