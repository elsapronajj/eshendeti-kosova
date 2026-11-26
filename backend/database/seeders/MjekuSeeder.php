<?php
namespace Database\Seeders;

use App\Data\Shared\Institucioni;
use App\Data\Shared\Mjeku;
use Illuminate\Database\Seeder;

class MjekuSeeder extends Seeder
{
    public function run(): void
    {
        $qkuk = Institucioni::where('kodi', 'QKUK')->first();
        $peja = Institucioni::where('kodi', 'SRP')->first();
        $prizreni = Institucioni::where('kodi', 'SRPZ')->first();
        $qkmfPrishtine = Institucioni::where('kodi', 'QKMF-PR')->first();

        $mjeku1 = Mjeku::create([
            'numri_i_licences' => 'LIC-1001',
            'titulli' => 'Prof. Dr.',
            'emri' => 'Blerim',
            'mbiemri' => 'Hoxha',
            'specializimi' => 'Kardiologji',
        ]);
        $mjeku1->institucionet()->attach([$qkuk->id, $peja->id]);
        $mjeku2 = Mjeku::create([
            'numri_i_licences' => 'LIC-1002',
            'titulli' => 'Dr.',
            'emri' => 'Vjosa',
            'mbiemri' => 'Berisha',
            'specializimi' => 'Mjekësi familjare',
        ]);
        $mjeku2->institucionet()->attach($qkmfPrishtine->id);

        $mjeku3 = Mjeku::create([
            'numri_i_licences' => 'LIC-1003',
            'titulli' => 'Dr. Sc.',
            'emri' => 'Arta',
            'mbiemri' => 'Gashi',
            'specializimi' => 'Pediatri',
        ]);
        $mjeku3->institucionet()->attach($prizreni->id);
    }

}