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
}
