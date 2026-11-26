<?php

namespace Database\Seeders;
use App\Data\Shared\Institucioni;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitucioniSeeder extends Seeder
{
    public function run(): void
    {
       Institucioni::create([
        'kodi' => 'QKUK',
        'emri' => 'Qendra Klinike Universitare e Kosoves',
        'qyteti' => 'Pershtine',
        'telefoni' => '038500600',
        'lloji' => 'spital',
        'numri_shtreterve' => 2100,
       ]);

       Institucioni::create([
        'kodi' => 'SRP',
        'emri' => 'Spital Regjional i Pejes',
        'qyteti' => 'Peje',
        'telefoni' => '039422100',
        'lloji' => 'spital',
        'numri_shtreterve' => 450,
       ]);

       Institucioni::create([
        'kodi' => 'SRPZ',
        'emri' => 'Spital Regjional i Prizrenit',
        'qyteti' => 'Prizreni',
        'telefoni' => '029244300',
        'lloji' => 'spital',
        'numri_shtreterve' => 520,
       ]);

       Institucioni::create([
        'kodi' => 'QKMF-PR',
        'emri' => 'QKMF Prishtine',
        'qyteti' => 'Prishtine',
        'telefoni' => '038200400',
        'lloji' => 'qkmf',
        'komuna' => 'Prishtine',
       ]);

        Institucioni::create([
        'kodi' => 'QKMF-GJ',
        'emri' => 'QKMF Gjilan',
        'qyteti' => 'Gjilan',
        'telefoni' => '028320500',
        'lloji' => 'qkmf',
        'komuna' => 'Gjilan',
       ]);
    }
}
