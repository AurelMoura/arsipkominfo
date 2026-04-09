<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// 1. Halaman awal langsung lempar ke login
Route::get('/', function () { 
    return redirect('/login'); 
});

// 2. Auth Routes
Route::get('/login', function () { 
    return view('login'); 
});
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// 3. Dashboard Route (GANTI BAGIAN INI)
// Sekarang kita arahkan ke function 'dashboard' di AuthController
Route::get('/dashboard', [AuthController::class, 'dashboard']);
use App\Http\Controllers\PegawaiController;

// Halaman Daftar Pegawai (DUK)
Route::get('/pegawai', [PegawaiController::class, 'index']);
Route::get('/admin/duk', [PegawaiController::class, 'adminDuk']);

// Aksi simpan pegawai baru
Route::post('/pegawai/store', [PegawaiController::class, 'store']);

// Aksi update password pegawai
Route::post('/pegawai/update-password', [App\Http\Controllers\PegawaiController::class, 'updatePassword']);

// Halaman Profile Pegawai
Route::get('/profile', [PegawaiController::class, 'profile']);
Route::post('/profile/update-profil', [PegawaiController::class, 'updateProfileBasic']);
Route::get('/profile/drh', [PegawaiController::class, 'drh']);
Route::post('/profile/drh', [PegawaiController::class, 'storeDrh']);
Route::get('/profile/drh/file/{type}/view', [PegawaiController::class, 'viewDrhFile']);
Route::get('/profile/drh/file/{type}/download', [PegawaiController::class, 'downloadDrhFile']);

// Arsip Dokumen Pegawai
Route::get('/pegawai/arsip', [PegawaiController::class, 'arsip']);
Route::post('/pegawai/arsip/upload', [PegawaiController::class, 'uploadDocument']);
Route::get('/pegawai/arsip/download/{id}', [PegawaiController::class, 'downloadDocument']);
Route::get('/pegawai/arsip/view/{id}', [PegawaiController::class, 'viewDocument']);
Route::delete('/pegawai/arsip/delete/{id}', [PegawaiController::class, 'deleteDocument']);

// Admin Validasi Dokumen
Route::get('/admin/validasi-dokumen', [PegawaiController::class, 'adminValidasiDokumen']);
Route::post('/admin/validasi-dokumen/{id}/approve', [PegawaiController::class, 'approveDocument'])->name('admin.document.approve');
Route::post('/admin/validasi-dokumen/{id}/reject', [PegawaiController::class, 'rejectDocument'])->name('admin.document.reject');

// Admin Pegawai DRH
Route::get('/admin/pegawai/{id}/drh', [PegawaiController::class, 'adminViewPegawaiDrh']);
Route::get('/admin/pegawai/{id}/drh/print', [PegawaiController::class, 'adminPrintPegawaiDrh']);
Route::get('/admin/drh/legal/{userId}/{type}/view', [PegawaiController::class, 'adminViewLegalDoc']);
Route::get('/admin/drh/legal/{userId}/{type}/download', [PegawaiController::class, 'adminDownloadLegalDoc']);
Route::get('/admin/drh/legal/{userId}/{type}/print', [PegawaiController::class, 'adminPrintLegalDoc']);

// Pengajuan Berkas
Route::get('/pengajuan-berkas', [PegawaiController::class, 'pengajuanBerkas']);

// Test Telegram (debug route - hapus setelah testing)
Route::get('/test-telegram', function () {
    $pesan = "🧪 *Test Pesan Telegram*\n\n";
    $pesan .= "Waktu: " . date('d-m-Y H:i:s') . "\n";
    $pesan .= "Status: Pesan test berhasil terkirim!";
    
    $result = \App\Helpers\TelegramHelper::kirimTelegram($pesan);
    
    return response()->json([
        'status' => $result ? 'success' : 'failed',
        'message' => $result ? 'Pesan berhasil dikirim ke Telegram' : 'Gagal mengirim pesan'
    ]);
});

