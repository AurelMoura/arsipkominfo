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
        Schema::table('drh_data', function (Blueprint $table) {
            $table->string('jabatan')->nullable()->after('status_aktif');
            $table->string('golongan')->nullable()->after('jabatan');
            $table->boolean('profil_dasar_lengkap')->default(false)->after('golongan');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('profil_dasar_lengkap')->default(false)->after('is_first_login');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drh_data', function (Blueprint $table) {
            $table->dropColumn('jabatan');
            $table->dropColumn('golongan');
            $table->dropColumn('profil_dasar_lengkap');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profil_dasar_lengkap');
        });
    }
};
