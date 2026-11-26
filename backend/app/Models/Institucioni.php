<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institucioni extends Model
{
    protected $table='institucionet';

    protected $fillable=[
        'kodi', 'emri', 'qyteti', 'telefoni', 'lloji', 'numri_shtreterve', 'komuna',
    ];
    
    public function eshteSpital(){
        return $this->lloji === 'spital';
    }
    public function eshteQkmf(){
        return $this->lloji === 'qkmf';
    }
    public function mjeket(){
        return $this->belongsToMany(Mjeku::class, 'mjek_institucion','institucion_id','mjek_id')
        ->withTimestamps();
    }
    public function vizitat(){
        return $this->hasMany(Vizita::class, 'institucion_id');
    }
    public function autorizimet(){
        return $this->hasMany(Autorizimi::class, 'institucion_id');
    }
}
