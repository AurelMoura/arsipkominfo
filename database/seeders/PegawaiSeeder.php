<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Superadmin
        Pegawai::create([
            'id' => '0987654321',
            'nama_lengkap' => 'Superadmin Kominfo',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-01-01',
            'gol_darah' => 'O',
            'status_kawin' => 'M',
            'status_pegawai' => 'PNS'
        ]);
        
        // Data Admin
        Pegawai::create([
            'id' => '1111111111',
            'nama_lengkap' => 'Admin',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1985-05-15',
            'gol_darah' => 'A',
            'status_kawin' => 'M',
            'status_pegawai' => 'PNS'
        ]);

        // Data Pegawai - Budi Santoso
        Pegawai::create([
            'id' => '197501012000031001',
            'nama_lengkap' => 'Budi Santoso',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1975-01-01',
            'gol_darah' => 'B',
            'status_kawin' => 'M',
            'status_pegawai' => 'PNS'
        ]);

        // Data Pegawai - Siti Aminah
        Pegawai::create([
            'id' => '198001152000032002',
            'nama_lengkap' => 'Siti Aminah',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Medan',
            'tanggal_lahir' => '1980-01-15',
            'gol_darah' => 'AB',
            'status_kawin' => 'M',
            'status_pegawai' => 'PNS'
        ]);

        // Data Pegawai - Hendra Wijaya
        Pegawai::create([
            'id' => '199001202000033003',
            'nama_lengkap' => 'Hendra Wijaya',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Yogyakarta',
            'tanggal_lahir' => '1990-01-20',
            'gol_darah' => 'O',
            'status_kawin' => 'BM',
            'status_pegawai' => 'PPPK'
        ]);
    }
}
