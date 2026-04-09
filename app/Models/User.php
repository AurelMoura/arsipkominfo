<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Daftarkan kolom yang boleh diisi secara massal.
     * Ini akan menggantikan penggunaan #[Fillable] yang tadi error.
     */
    protected $fillable = [
        'name',
        'identifier',
        'nama_lengkap',
        'nip',
        'jabatan',
        'bidang',
        'no_hp',
        'alamat',
        'username',
        'email',
        'password',
        'role',
        'is_first_login',
        'profil_dasar_lengkap'
    ];

    /**
     * Sembunyikan data sensitif saat dipanggil.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Pengaturan tipe data (Casting).
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}