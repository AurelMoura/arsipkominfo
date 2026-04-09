<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrhData extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'nik',
        'email',
        'no_hp',
        'alamat_domisili',
        'tempat_lahir',
        'kabupaten_asal',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'golongan_darah',
        'status_pegawai',
        'jenis_asn',
        'status_aktif',
        'jabatan',
        'tmt',
        'golongan',
        'profil_dasar_lengkap',
        'nik_ktp',
        'file_ktp',
        'nomor_npwp',
        'file_npwp',
        'nomor_bpjs',
        'file_bpjs',
        'file_kk',
        'data_pasangan',
        'data_anak',
        'data_orang_tua',
        'data_mertua',
        'dokumen_pendukung',
        'riwayat_pendidikan',
        'riwayat_diklat',
        'riwayat_jabatan',
        'riwayat_penghargaan',
        'riwayat_sertifikasi'
    ];

    protected $casts = [
        'dokumen_pendukung' => 'array',
        'tanggal_lahir' => 'date',
        'tmt' => 'date',
        'data_pasangan' => 'array',
        'data_anak' => 'array',
        'data_orang_tua' => 'array',
        'data_mertua' => 'array',
        'riwayat_pendidikan' => 'array',
        'riwayat_diklat' => 'array',
        'riwayat_jabatan' => 'array',
        'riwayat_penghargaan' => 'array',
        'riwayat_sertifikasi' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
