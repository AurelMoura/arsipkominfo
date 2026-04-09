<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    // Nama tabel (opsional, tapi kita tulis biar jelas)
    protected $table = 'pegawai';

    // Primary key
    protected $primaryKey = 'id';

    // Karena bukan auto increment
    public $incrementing = false;

    // Tipe primary key (char/string)
    protected $keyType = 'string';

    // Field yang boleh diisi (mass assignment)
    protected $fillable = [
        'id',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'gol_darah',
        'status_kawin',
        'status_pegawai',
        'email',
        'no_hp',
        'no_kk',
        'no_nik',
        'no_bpjs',
        'no_taspen',
        'dok_kk',
        'dok_ktp',
        'dok_akte',
        'dok_nikah'
    ];

    // Casting untuk kolom
    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }
}