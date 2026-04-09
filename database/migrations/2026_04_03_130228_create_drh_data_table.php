<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('drh_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Profil Dasar
            $table->string('nip');
            $table->string('nama_lengkap');
            $table->string('nik')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('alamat_domisili')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('kabupaten_asal')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'])->nullable();
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O'])->nullable();
            $table->enum('status_pegawai', ['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'])->nullable();
            $table->enum('jenis_asn', ['PNS', 'PPPK'])->nullable();
            $table->enum('status_aktif', ['Aktif', 'Tidak Aktif'])->nullable();
            
            // Identitas Legal
            $table->string('nik_ktp')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('nomor_npwp')->nullable();
            $table->string('file_npwp')->nullable();
            $table->string('nomor_bpjs')->nullable();
            $table->string('file_bpjs')->nullable();
            $table->string('file_kk')->nullable();
            
            // Data Keluarga (JSON untuk data dinamis)
            $table->json('data_pasangan')->nullable();
            $table->json('data_anak')->nullable();
            $table->json('data_orang_tua')->nullable();
            $table->json('data_mertua')->nullable();
            
            // Riwayat (JSON untuk data dinamis)
            $table->json('riwayat_pendidikan')->nullable();
            $table->json('riwayat_diklat')->nullable();
            $table->json('riwayat_jabatan')->nullable();
            $table->json('riwayat_penghargaan')->nullable();
            $table->json('riwayat_sertifikasi')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drh_data');
    }
};
