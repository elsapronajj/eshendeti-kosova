<?php

namespace App\Data\Autorizimet;

use App\Data\Shared\Institucioni;
use App\Data\Shared\Pacienti;
use Illuminate\Database\Eloquent\Model;

class Autorizimi extends Model
{
  protected $table ='autorizimet';
  protected $fillable =['pacient_id','institucion_id', 'lloji','data_e_fillimit','data_e_skadimit','statusi' ];

  public function pacienti()
  {
    return $this-> belongsTo(Pacienti::class, 'pacient_id');

  }
public function institucioni()
{
    return $this-> belongsTo(Institucioni::class,'institucion_id');
}
public function eshteAktiv()
{
    return $this->statusi ==='aktiv' && ($this->data_e_skadimit === null || $this-> data_e_skadimit >= now()->toDateString());
}
}
