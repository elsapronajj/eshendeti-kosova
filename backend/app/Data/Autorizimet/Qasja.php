<?php

namespace App\Data\Autorizimet;

use App\Data\HistorikuKlinik\Dosja;
use App\Data\Shared\Mjeku;
use Illuminate\Database\Eloquent\Model;

class Qasja extends Model 
{
    protected $table ='qasjet';
    protected $fillable = ['dosje_id', 'mjek_id', 'data_ora','arsyeja','eshte_emergjente'];
    
    public function dosja()
    {
        return $this->belongsTo(Dosja::class, 'dosje_id');
    }
    
    public function mjeku()
    {
        return $this->belongsTo(Mjeku::class, 'mjek_id');
    }
}