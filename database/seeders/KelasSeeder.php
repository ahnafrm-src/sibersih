<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $kelas = [
            // Tingkat 10
            ['nama_kelas' => 'X RPL 1', 'tingkat' => 10],
            ['nama_kelas' => 'X RPL 2', 'tingkat' => 10],
            ['nama_kelas' => 'X TKJ 1', 'tingkat' => 10],
            ['nama_kelas' => 'X TKJ 2', 'tingkat' => 10],

            // Tingkat 11
            ['nama_kelas' => 'XI RPL 1', 'tingkat' => 11],
            ['nama_kelas' => 'XI RPL 2', 'tingkat' => 11],
            ['nama_kelas' => 'XI TKJ 1', 'tingkat' => 11],
            ['nama_kelas' => 'XI TKJ 2', 'tingkat' => 11],

            // Tingkat 12
            ['nama_kelas' => 'XII RPL 1', 'tingkat' => 12],
            ['nama_kelas' => 'XII RPL 2', 'tingkat' => 12],
            ['nama_kelas' => 'XII TKJ 1', 'tingkat' => 12],
            ['nama_kelas' => 'XII TKJ 2', 'tingkat' => 12],
        ];

        DB::table('kelas')->insert($kelas);
    }
}
