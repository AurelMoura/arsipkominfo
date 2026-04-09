<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\DrhData;
use App\Models\Document;
use App\Helpers\TelegramHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    /**
     * Menampilkan Daftar Pegawai (Hanya untuk Role Admin)
     */
    public function index()
    {
        if (!Session::has('role') || Session::get('role') !== 'admin') {
            return redirect('/login');
        }

        $pegawai = User::where('role', 'pegawai')->get();
        $total_pegawai = $pegawai->count();

        return view('dashboard.pegawai_duk', compact('pegawai', 'total_pegawai'));
    }

    /**
     * Admin Menambahkan Pegawai Baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|unique:users,identifier',
            'nama_lengkap' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Password default adalah NIP pegawai
        $defaultPassword = (string) $request->nip;

        User::create([
            'identifier' => $request->nip,
            'name' => $request->nama_lengkap,
            'nama_lengkap' => $request->nama_lengkap,
            'nip' => $request->nip,
            'username' => $request->nip,
            'role' => 'pegawai',
            'password' => Hash::make($defaultPassword),
            'is_first_login' => true // Ditandai agar pegawai wajib mengubah password saat login pertama
        ]);

        return redirect('/pegawai')->with('success', 'Pegawai berhasil ditambahkan! Password default: NIP pegawai. Pegawai wajib mengubah password saat login pertama.');
    }

    /**
     * Menampilkan Halaman Kelola Profil Pegawai
     */
    public function profile()
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        // Ambil data Pegawai berdasarkan identifier/NIP
        $pegawaiData = Pegawai::where('id', Session::get('identifier'))->first();

        return view('dashboard.profile', compact('pegawaiData'));
    }

    /**
     * Update Profil Kontak (Email, No HP)
     */
    public function updateProfileBasic(Request $request)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        // Validasi
        $validated = $request->validate([
            'email' => 'required|email',
            'no_hp' => 'required|regex:/^08[0-9]{7,11}$/',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'gol_darah' => 'required|in:A,B,AB,O',
            'status_kawin' => 'required|in:M,BM,CH,CM',
            'status_pegawai' => 'required|in:PNS,PPPK',
            'no_nik' => 'required|string'
        ]);

        try {
            $pegawai = Pegawai::firstOrNew(['id' => Session::get('identifier')]);

            $pegawai->nama_lengkap = $validated['nama_lengkap'];
            $pegawai->jenis_kelamin = $validated['jenis_kelamin'];
            $pegawai->tempat_lahir = $validated['tempat_lahir'];
            $pegawai->tanggal_lahir = $validated['tanggal_lahir'];
            $pegawai->gol_darah = $validated['gol_darah'];
            $pegawai->status_kawin = $validated['status_kawin'];
            $pegawai->status_pegawai = $validated['status_pegawai'];
            $pegawai->no_nik = $validated['no_nik'];
            $pegawai->email = $validated['email'];
            $pegawai->no_hp = $validated['no_hp'];
            $pegawai->save();

            // Update nama pada tabel users jika perlu
            $user = User::find(Session::get('user_id'));
            if ($user) {
                $user->name = $validated['nama_lengkap'];
                $user->save();
                Session::put('name', $validated['nama_lengkap']);
            }

            return redirect('/profile')->with('success', 'Data profil berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect('/profile')->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan Halaman Daftar Riwayat Hidup (DRH) Pegawai
     */
    public function drh()
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        // Untuk saat ini, inisialisasi data DRH kosong
        // Data dapat diakses dari session atau database DRH jika ada
        $drhData = null;

        return view('dashboard.drh', compact('drhData'));
    }

    /**
     * Pegawai: View DRH file PDF inline
     */
    public function viewDrhFile($type)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        // DRH table belum di-setup, return error sementara
        return back()->with('error', 'Fitur DRH sedang dalam pengembangan.');
    }

    /**
     * Pegawai: Download DRH file
     */
    public function downloadDrhFile($type)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        // DRH table belum di-setup, return error sementara
        return back()->with('error', 'Fitur DRH sedang dalam pengembangan.');
    }

    /**
     * Pegawai Memperbarui Password (Ganti Password Wajib Pertama Kali)
     * Setelah berhasil, status is_first_login jadi false agar modal tidak muncul lagi selamanya.
     */
    public function updatePassword(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'password_baru' => 'required|min:6',
            'konfirmasi_password' => 'required|same:password_baru'
        ], [
            'password_baru.min' => 'Password minimal harus 6 karakter.',
            'konfirmasi_password.same' => 'Konfirmasi password tidak cocok.'
        ]);

        // 2. Ambil user yang sedang login
        $user = User::find(Session::get('user_id'));

        if ($user) {
            // 3. Update Password dan Matikan Status Login Pertama
            $user->update([
                'password' => Hash::make($request->password_baru),
                'is_first_login' => false 
            ]);

            // 4. Update Session secara instan dan simpan ke server
            Session::put('is_first_login', false);
            Session::save(); // Memastikan session benar-benar berubah detik ini juga

            // 5. Lempar ke halaman A. PROFIL DASAR (Wajib Diisi)
            return redirect('/profile/drh')->with('success', 'Password telah diubah dengan sukses. Silakan lengkapi Profil Dasar.');
        }

        return back()->with('error', 'User tidak ditemukan.');
    }

    /**
     * Menyimpan Data Daftar Riwayat Hidup (DRH) Pegawai
     */
    public function storeDrh(Request $request)
    {
        $step = $request->input('step', 0);

        // Validation rules per step
        $rules = [];
        $existingDrhData = null;
        $userId = Session::get('user_id');

        if ($step > 0) {
            $existingDrhData = DrhData::where('user_id', $userId)->first();
        }

        if ($step == 0) {
            // Step A: Profil Dasar - all required
            $rules = [
                'nik' => 'required|string|max:16',
                'email' => 'required|email',
                'no_hp' => 'required|string|max:15',
                'alamat_domisili' => 'required|string|max:255',
                'tempat_lahir' => 'required|string|max:100',
                'kabupaten_asal' => 'required|string|max:100',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha',
                'golongan_darah' => 'required|in:A,B,AB,O',
                'status_pegawai' => 'required|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
                'jenis_asn' => 'required|in:PNS,PPPK',
                'jabatan' => 'required|string|max:255',
                'tmt' => 'required|date',
                'golongan' => 'required|in:I/a,I/b,I/c,I/d,II/a,II/b,II/c,II/d,III/a,III/b,III/c,III/d,IV/a,IV/b,IV/c,IV/d,IV/e',
            ];
        } elseif ($step == 1) {
            // Step B: Keluarga - validasi dikondisikan berdasarkan status keluarga
            $statusPegawai = $request->input('status_pegawai');

            $fileAyahRule = empty($existingDrhData?->data_orang_tua['ayah']['file']) ? 'required|file|mimes:pdf|max:1024' : 'nullable|file|mimes:pdf|max:1024';
            $fileIbuRule = empty($existingDrhData?->data_orang_tua['ibu']['file']) ? 'required|file|mimes:pdf|max:1024' : 'nullable|file|mimes:pdf|max:1024';

            $rules = [
                'nama_ayah' => 'required|string|max:100',
                'tanggal_lahir_ayah' => 'required|date',
                'status_ayah' => 'required|in:Hidup,Meninggal',
                'pekerjaan_ayah' => 'required|string|max:100',
                'alamat_ayah' => 'required|string|max:255',
                'nama_ibu' => 'required|string|max:100',
                'alamat_ibu' => 'required|string|max:255',
                'tanggal_lahir_ibu' => 'required|date',
                'status_ibu' => 'required|in:Hidup,Meninggal',
                'pekerjaan_ibu' => 'required|string|max:100',
            ];

            if ($statusPegawai === 'Menikah') {
                $filePasanganRule = empty($existingDrhData?->data_pasangan['file']) ? 'required|file|mimes:pdf|max:1024' : 'nullable|file|mimes:pdf|max:1024';
                $fileAyahMertuaRule = empty($existingDrhData?->data_mertua['ayah']['file']) ? 'required|file|mimes:pdf|max:1024' : 'nullable|file|mimes:pdf|max:1024';
                $fileIbuMertuaRule = empty($existingDrhData?->data_mertua['ibu']['file']) ? 'required|file|mimes:pdf|max:1024' : 'nullable|file|mimes:pdf|max:1024';

                $rules = array_merge($rules, [
                    'nama_pasangan' => 'required|string|max:100',
                    'nik_pasangan' => 'required|string|max:16',
                    'status_pasangan_select' => 'required|in:SUAMI,ISTRI',
                    'status_hidup_pasangan' => 'required|in:Hidup,Meninggal',
                    'tempat_lahir_pasangan' => 'required|string|max:100',
                    'tanggal_lahir_pasangan' => 'required|date',
                    'pekerjaan_pasangan' => 'required|string|max:100',
                    'file_pasangan' => $filePasanganRule,
                    'nama_ayah_mertua' => 'required|string|max:100',
                    'tanggal_lahir_ayah_mertua' => 'required|date',
                    'status_ayah_mertua' => 'required|in:Hidup,Meninggal',
                    'pekerjaan_ayah_mertua' => 'required|string|max:100',
                    'file_ayah_mertua' => $fileAyahMertuaRule,
                    'nama_ibu_mertua' => 'required|string|max:100',
                    'tanggal_lahir_ibu_mertua' => 'required|date',
                    'status_ibu_mertua' => 'required|in:Hidup,Meninggal',
                    'pekerjaan_ibu_mertua' => 'required|string|max:100',
                    'file_ibu_mertua' => $fileIbuMertuaRule,
                ]);
            }

            if (in_array($statusPegawai, ['Menikah', 'Cerai Hidup', 'Cerai Mati'], true)) {
                if ($request->has('anak')) {
                    $rules = array_merge($rules, [
                        'anak' => 'array|min:1',
                        'anak.*.nama' => 'required|string|max:255',
                        'anak.*.nik' => 'required|string|max:16',
                        'anak.*.tempat_lahir' => 'required|string|max:100',
                        'anak.*.tanggal_lahir' => 'required|date',
                        'anak.*.status_anak' => 'required|string|max:50',
                        'anak.*.file' => 'required|file|mimes:pdf|max:1024',
                    ]);
                }
            }
        } elseif ($step == 2) {
            // Step C: Pendidikan
            $rules = [
                'pendidikan' => 'required|array|min:1',
                'pendidikan.*.jenjang' => 'required|string|max:50',
                'pendidikan.*.nama_sekolah' => 'required|string|max:255',
                'pendidikan.*.tahun_masuk' => 'required|string|max:10',
                'pendidikan.*.tahun_lulus' => 'required|string|max:10',
                'pendidikan.*.nomor_ijazah' => 'required|string|max:50',
                'pendidikan.*.nama_pejabat' => 'required|string|max:100',
                'pendidikan.*.file' => 'nullable|file|mimes:pdf|max:1024',
                'pendidikan.*.old_file' => 'nullable|string',
            ];

            $pendidikanRows = $request->input('pendidikan', []);
            if (is_array($pendidikanRows)) {
                foreach ($pendidikanRows as $index => $row) {
                    $hasExistingFile = !empty($row['old_file']) || !empty($existingDrhData?->riwayat_pendidikan[$index]['file']);
                    if (!$hasExistingFile) {
                        $rules["pendidikan.$index.file"] = 'required|file|mimes:pdf|max:1024';
                    }
                }
            }
        } elseif ($step == 3) {
            // Step D: Diklat
            $rules = [
                'diklat' => 'required|array|min:1',
                'diklat.*.nama' => 'required|string|max:255',
                'diklat.*.penyelenggara' => 'required|string|max:255',
                'diklat.*.nomor_sertifikat' => 'required|string|max:100',
                'diklat.*.tahun' => 'required|string|max:10',
                'diklat.*.file' => 'nullable|file|mimes:pdf|max:1024',
                'diklat.*.old_file' => 'nullable|string',
            ];

            $diklatRows = $request->input('diklat', []);
            if (is_array($diklatRows)) {
                foreach ($diklatRows as $index => $row) {
                    $hasExistingFile = !empty($row['old_file']) || !empty($existingDrhData?->riwayat_diklat[$index]['file']);
                    if (!$hasExistingFile) {
                        $rules["diklat.$index.file"] = 'required|file|mimes:pdf|max:1024';
                    }
                }
            }
        } elseif ($step == 4) {
            // Step E: Jabatan
            $rules = [
                'riwayat_jabatan' => 'required|array|min:1',
                'riwayat_jabatan.*.golongan' => 'required|string|max:10',
                'riwayat_jabatan.*.jabatan' => 'required|string|max:255',
                'riwayat_jabatan.*.unit_kerja' => 'required|string|max:255',
                'riwayat_jabatan.*.tmt' => 'required|date',
                'riwayat_jabatan.*.no_sk' => 'required|string|max:100',
                'riwayat_jabatan.*.file' => 'required|file|mimes:pdf|max:1024',
            ];
        } elseif ($step == 5) {
            // Step F: Penghargaan
            $rules = [
                'award' => 'required|array|min:1',
                'award.*.nama' => 'required|string|max:255',
                'award.*.tahun' => 'required|string|max:10',
                'award.*.instansi' => 'required|string|max:255',
                'award.*.file' => 'required|file|mimes:pdf|max:1024',
            ];
        } elseif ($step == 6) {
            // Step G: Sertifikasi
            $rules = [
                'sertif' => 'required|array|min:1',
                'sertif.*.nama' => 'required|string|max:255',
                'sertif.*.tahun' => 'required|string|max:10',
                'sertif.*.lembaga' => 'required|string|max:255',
                'sertif.*.file' => 'required|file|mimes:pdf|max:1024',
            ];
        } elseif ($step == 7) {
            // Step H: Legal
            $rules = [
                'nik_ktp' => 'required|string|max:16',
                'file_ktp' => 'required|file|mimes:pdf|max:1024',
                'nomor_npwp' => 'required|string|max:20',
                'file_npwp' => 'required|file|mimes:pdf|max:1024',
                'nomor_bpjs' => 'required|string|max:20',
                'file_bpjs' => 'required|file|mimes:pdf|max:1024',
                'file_kk' => 'required|file|mimes:pdf|max:1024',
                'file_akta_kelahiran' => 'required|file|mimes:pdf|max:1024',
                'file_diklat' => 'required|file|mimes:pdf|max:1024',
                'file_ijazah' => 'required|file|mimes:pdf|max:1024',
                'file_sk' => 'required|file|mimes:pdf|max:1024',
                'file_penghargaan' => 'required|file|mimes:pdf|max:1024',
                'file_sertifikat' => 'required|file|mimes:pdf|max:1024',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Belum selesai mengisi. Pastikan semua field di bagian ini telah diisi.');
        }

        try {
            $userId = Session::get('user_id');
            $drhData = DrhData::firstOrNew(['user_id' => $userId]);

            // Handle file uploads
            $filePaths = [];
            $files = [
                'file_ktp', 'file_npwp', 'file_bpjs', 'file_kk',
                'file_pasangan', 'file_ayah', 'file_ibu', 'file_ayah_mertua', 'file_ibu_mertua',
                'file_akta_kelahiran', 'file_diklat', 'file_ijazah', 'file_sk', 'file_penghargaan', 'file_sertifikat'
            ];
            
            foreach ($files as $fileField) {
                if ($request->hasFile($fileField)) {
                    $file = $request->file($fileField);
                    $fileName = time() . '_' . $userId . '_' . $fileField . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('drh_files', $fileName, 'public');
                    $filePaths[$fileField] = 'drh_files/' . $fileName;
                }
            }

            $dynamicFiles = [
                'pendidikan', 'diklat', 'riwayat_jabatan', 'award', 'sertif', 'anak'
            ];

            foreach ($dynamicFiles as $fieldName) {
                $nestedFiles = $request->file($fieldName, []);
                if (!is_array($nestedFiles)) {
                    continue;
                }
                foreach ($nestedFiles as $index => $subFiles) {
                    if (!is_array($subFiles)) {
                        continue;
                    }
                    if (isset($subFiles['file']) && $subFiles['file']) {
                        $file = $subFiles['file'];
                        $fileName = time() . '_' . $userId . '_' . $fieldName . '_' . $index . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('drh_files', $fileName, 'public');
                        $filePaths[$fieldName . '_' . $index . '_file'] = 'drh_files/' . $fileName;
                    }
                }
            }

            $mergeRowFile = function(array $rows, string $fieldName, array $existingRows = []) use ($filePaths) {
                $merged = [];
                $existingById = [];
                $existingByIndex = [];

                foreach ($existingRows as $existingIndex => $existing) {
                    if (!empty($existing['id'])) {
                        $existingById[$existing['id']] = $existing;
                    } else {
                        $existingByIndex[$existingIndex] = $existing;
                    }
                }

                foreach ($rows as $index => $row) {
                    $fileKey = $fieldName . '_' . $index . '_file';
                    if (!empty($filePaths[$fileKey])) {
                        $row['file'] = $filePaths[$fileKey];
                    } elseif (!empty($row['old_file'])) {
                        $row['file'] = $row['old_file'];
                    }
                    unset($row['old_file']);

                    if (!empty($row['id']) && isset($existingById[$row['id']])) {
                        $merged[] = array_merge($existingById[$row['id']], $row);
                        unset($existingById[$row['id']]);
                    } elseif (isset($existingByIndex[$index])) {
                        $merged[] = array_merge($existingByIndex[$index], $row);
                        unset($existingByIndex[$index]);
                    } else {
                        $row['id'] = uniqid($fieldName . '_', true);
                        $merged[] = $row;
                    }
                }

                foreach ($existingById as $remaining) {
                    $merged[] = $remaining;
                }

                return $merged;
            };

            if ($step == 0) {
                $drhData->fill([
                    'nip' => Session::get('identifier'),
                    'nama_lengkap' => Session::get('name'),
                    'nik' => $request->nik,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp,
                    'alamat_domisili' => $request->alamat_domisili,
                    'tempat_lahir' => $request->tempat_lahir,
                    'kabupaten_asal' => $request->kabupaten_asal,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'agama' => $request->agama,
                    'golongan_darah' => $request->golongan_darah,
                    'status_pegawai' => $request->status_pegawai,
                    'jenis_asn' => $request->jenis_asn,
                    'jabatan' => $request->jabatan,
                    'tmt' => $request->tmt,
                    'golongan' => $request->golongan,
                    'profil_dasar_lengkap' => true,
                ]);
            } elseif ($step == 1) {
                $anakRows = $request->input('anak', []);
                if (is_array($anakRows)) {
                    $anakRows = $mergeRowFile($anakRows, 'anak', $drhData->data_anak ?? []);
                }

                $drhData->fill([
                    'data_pasangan' => [
                        'nama' => $request->nama_pasangan,
                        'nik' => $request->nik_pasangan,
                        'status' => $request->status_pasangan_select,
                        'status_hidup' => $request->status_hidup_pasangan,
                        'tempat_lahir' => $request->tempat_lahir_pasangan,
                        'tanggal_lahir' => $request->tanggal_lahir_pasangan,
                        'pekerjaan' => $request->pekerjaan_pasangan,
                        'file' => $filePaths['file_pasangan'] ?? $drhData->data_pasangan['file'] ?? null,
                    ],
                    'data_orang_tua' => [
                        'ayah' => [
                            'nama' => $request->nama_ayah,
                            'alamat' => $request->alamat_ayah,
                            'tanggal_lahir' => $request->tanggal_lahir_ayah,
                            'status_hidup' => $request->status_ayah,
                            'pekerjaan' => $request->pekerjaan_ayah,
                            'file' => $filePaths['file_ayah'] ?? $drhData->data_orang_tua['ayah']['file'] ?? null,
                        ],
                        'ibu' => [
                            'nama' => $request->nama_ibu,
                            'alamat' => $request->alamat_ibu,
                            'tanggal_lahir' => $request->tanggal_lahir_ibu,
                            'status_hidup' => $request->status_ibu,
                            'pekerjaan' => $request->pekerjaan_ibu,
                            'file' => $filePaths['file_ibu'] ?? $drhData->data_orang_tua['ibu']['file'] ?? null,
                        ]
                    ],
                    'data_mertua' => [
                        'ayah' => [
                            'nama' => $request->nama_ayah_mertua,
                            'tanggal_lahir' => $request->tanggal_lahir_ayah_mertua,
                            'status_hidup' => $request->status_ayah_mertua,
                            'pekerjaan' => $request->pekerjaan_ayah_mertua,
                            'file' => $filePaths['file_ayah_mertua'] ?? $drhData->data_mertua['ayah']['file'] ?? null,
                        ],
                        'ibu' => [
                            'nama' => $request->nama_ibu_mertua,
                            'tanggal_lahir' => $request->tanggal_lahir_ibu_mertua,
                            'status_hidup' => $request->status_ibu_mertua,
                            'pekerjaan' => $request->pekerjaan_ibu_mertua,
                            'file' => $filePaths['file_ibu_mertua'] ?? $drhData->data_mertua['ibu']['file'] ?? null,
                        ]
                    ],
                    'data_anak' => $anakRows,
                ]);
            } elseif ($step == 2) {
                $pendidikanRows = $request->input('pendidikan', []);
                if (is_array($pendidikanRows)) {
                    $pendidikanRows = $mergeRowFile($pendidikanRows, 'pendidikan', $drhData->riwayat_pendidikan ?? []);
                }
                $drhData->riwayat_pendidikan = $pendidikanRows;
            } elseif ($step == 3) {
                $diklatRows = $request->input('diklat', []);
                if (is_array($diklatRows)) {
                    $diklatRows = $mergeRowFile($diklatRows, 'diklat', $drhData->riwayat_diklat ?? []);
                }
                $drhData->riwayat_diklat = $diklatRows;
            } elseif ($step == 4) {
                $jabatanRows = $request->input('riwayat_jabatan', []);
                if (is_array($jabatanRows)) {
                    $jabatanRows = $mergeRowFile($jabatanRows, 'riwayat_jabatan', $drhData->riwayat_jabatan ?? []);
                }
                $drhData->riwayat_jabatan = $jabatanRows;
            } elseif ($step == 5) {
                $awardRows = $request->input('award', []);
                if (is_array($awardRows)) {
                    $awardRows = $mergeRowFile($awardRows, 'award', $drhData->riwayat_penghargaan ?? []);
                }
                $drhData->riwayat_penghargaan = $awardRows;
            } elseif ($step == 6) {
                $sertifRows = $request->input('sertif', []);
                if (is_array($sertifRows)) {
                    $sertifRows = $mergeRowFile($sertifRows, 'sertif', $drhData->riwayat_sertifikasi ?? []);
                }
                $drhData->riwayat_sertifikasi = $sertifRows;
            } elseif ($step == 7) {
                $drhData->fill([
                    'nik_ktp' => $request->nik_ktp,
                    'file_ktp' => $filePaths['file_ktp'] ?? $drhData->file_ktp,
                    'nomor_npwp' => $request->nomor_npwp,
                    'file_npwp' => $filePaths['file_npwp'] ?? $drhData->file_npwp,
                    'nomor_bpjs' => $request->nomor_bpjs,
                    'file_bpjs' => $filePaths['file_bpjs'] ?? $drhData->file_bpjs,
                    'file_kk' => $filePaths['file_kk'] ?? $drhData->file_kk,
                    'dokumen_pendukung' => [
                        'akta_kelahiran' => $filePaths['file_akta_kelahiran'] ?? $drhData->dokumen_pendukung['akta_kelahiran'] ?? null,
                        'diklat' => $filePaths['file_diklat'] ?? $drhData->dokumen_pendukung['diklat'] ?? null,
                        'ijazah' => $filePaths['file_ijazah'] ?? $drhData->dokumen_pendukung['ijazah'] ?? null,
                        'sk' => $filePaths['file_sk'] ?? $drhData->dokumen_pendukung['sk'] ?? null,
                        'penghargaan' => $filePaths['file_penghargaan'] ?? $drhData->dokumen_pendukung['penghargaan'] ?? null,
                        'sertifikat' => $filePaths['file_sertifikat'] ?? $drhData->dokumen_pendukung['sertifikat'] ?? null,
                    ],
                ]);
            }

            $drhData->save();

            if ($step === 0) {
                return redirect()->back()->with('success', 'Berhasil diisi. Data telah disimpan.')->with('next', true)->with('step', $step);
            }

            return redirect()->back()->with('success', 'Data berhasil disimpan.')->with('step', $step);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Halaman Arsip Dokumen Pegawai
     */
    public function arsip()
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $userId = Session::get('user_id');
        $documents = Document::where('user_id', $userId)->latest('uploaded_at')->get();

        // Pisahkan dokumen berdasarkan status
        $approvedAndPending = $documents->whereIn('status', ['Approved', 'Pending']);
        $rejected = $documents->where('status', 'Rejected');

        $pending = $documents->where('status', 'Pending')->count();
        $approved = $documents->where('status', 'Approved')->count();
        $rejectedCount = $rejected->count();

        return view('dashboard.arsip', compact('approvedAndPending', 'rejected', 'pending', 'approved', 'rejectedCount'));
    }

    /**
     * Upload dokumen ke arsip pegawai
     */
    public function uploadDocument(Request $request)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $request->validate([
            'title' => 'required|string|max:150',
            'document' => 'required|file|mimes:pdf|max:2048',
        ], [
            'document.mimes' => 'Dokumen harus berformat PDF.',
            'document.max' => 'Ukuran file maksimum 2 MB.',
        ]);

        $userId = Session::get('user_id');
        $file = $request->file('document');
        $path = $file->storeAs('pegawai_docs/' . $userId, time() . '_' . $file->getClientOriginalName(), 'public');

        Document::create([
            'user_id' => $userId,
            'title' => $request->title,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'uploaded_at' => now(),
            'status' => 'Pending',
        ]);

        // Kirim notifikasi ke Telegram
        $user = Session::get('name');
        $pesan = "📥 *Arsip Baru Masuk*\n\n";
        $pesan .= "👤 Pegawai: " . $user . "\n";
        $pesan .= "📄 Dokumen: " . $request->title . "\n";
        $pesan .= "📅 Tanggal: " . date('d-m-Y H:i:s') . "\n\n";
        $pesan .= "🔍 Segera lakukan verifikasi.";
        TelegramHelper::kirimTelegram($pesan);

        return redirect('/pegawai/arsip')->with('success', 'Dokumen berhasil diunggah. Dokumen akan divalidasi oleh admin.');
    }

    /**
     * Download dokumen
     */
    public function downloadDocument($id)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $userId = Session::get('user_id');
        $document = Document::where('id', $id)->where('user_id', $userId)->firstOrFail();

        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($document->file_path, $document->original_name);
    }

    /**
     * Lihat dokumen (preview)
     */
    public function viewDocument($id)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $userId = Session::get('user_id');
        $document = Document::where('id', $id)->where('user_id', $userId)->firstOrFail();

        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = Storage::disk('public')->path($document->file_path);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $document->original_name . '"'
        ]);
    }

    /**
     * Hapus dokumen ditolak
     */
    public function deleteDocument($id)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $userId = Session::get('user_id');
        $document = Document::where('id', $id)->where('user_id', $userId)->where('status', 'Rejected')->firstOrFail();

        // Hapus file dari storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Hapus record dari database
        $document->delete();

        return redirect('/pegawai/arsip')->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Admin: Halaman validasi dokumen
     */
    public function adminValidasiDokumen()
    {
        if (!Session::has('role') || Session::get('role') !== 'admin') {
            return redirect('/login');
        }

        $documents = Document::with('user')->latest('uploaded_at')->get();
        $pendingCount = Document::where('status', 'Pending')->count();
        $approvedCount = Document::where('status', 'Approved')->count();
        $rejectedCount = Document::where('status', 'Rejected')->count();

        return view('dashboard.admin_validasi', compact('documents', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    /**
     * Admin: Setujui dokumen
     */
    public function approveDocument($id)
    {
        if (!Session::has('role') || Session::get('role') !== 'admin') {
            return redirect('/login');
        }

        $document = Document::findOrFail($id);
        $document->update([
            'status' => 'Approved',
            'rejection_reason' => null,
        ]);

        return redirect('/admin/validasi-dokumen')->with('success', 'Dokumen berhasil disetujui.');
    }

    /**
     * Admin: Tolak dokumen
     */
    public function rejectDocument(Request $request, $id)
    {
        if (!Session::has('role') || Session::get('role') !== 'admin') {
            return redirect('/login');
        }

        $request->validate([
            'reason' => 'required|string|min:10',
        ], [
            'reason.required' => 'Alasan penolakan harus diisi.',
            'reason.min' => 'Alasan penolakan minimal 10 karakter.',
        ]);

        $document = Document::findOrFail($id);
        $document->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->reason,
        ]);

        return redirect('/admin/validasi-dokumen')->with('success', 'Dokumen berhasil ditolak.');
    }

    /**
     * Admin: Lihat DRH detail pegawai
     */
    public function adminViewPegawaiDrh($id)
    {
        if (!Session::has('role') || Session::get('role') !== 'admin') {
            return redirect('/login');
        }

        $user = User::findOrFail($id);
        $drhData = DrhData::where('user_id', $user->id)->first();

        return view('dashboard.admin_pegawai_drh', compact('user', 'drhData'));
    }

    /**
     * Admin: Print DRH pegawai dengan kop resmi untuk PDF/print
     */
    public function adminPrintPegawaiDrh($id)
    {
        if (!Session::has('role') || Session::get('role') !== 'admin') {
            return redirect('/login');
        }

        $user = User::findOrFail($id);
        $drhData = DrhData::where('user_id', $user->id)->first();

        return view('dashboard.admin_pegawai_drh_pdf', compact('user', 'drhData'));
    }

    /**
     * Admin: View legal document PDF inline
     */
    public function adminViewLegalDoc($userId, $type)
    {
        if (!Session::has('role') || Session::get('role') !== 'admin') {
            return redirect('/login');
        }

        $mapping = [
            'ktp' => 'file_ktp',
            'npwp' => 'file_npwp',
            'bpjs' => 'file_bpjs',
            'kk' => 'file_kk',
            'pasangan' => 'data_pasangan.file',
            'ayah' => 'data_orang_tua.ayah.file',
            'ibu' => 'data_orang_tua.ibu.file',
            'ayah_mertua' => 'data_mertua.ayah.file',
            'ibu_mertua' => 'data_mertua.ibu.file',
            'akta_kelahiran' => 'dokumen_pendukung.akta_kelahiran',
            'diklat' => 'dokumen_pendukung.diklat',
            'ijazah' => 'dokumen_pendukung.ijazah',
            'sk' => 'dokumen_pendukung.sk',
            'penghargaan' => 'dokumen_pendukung.penghargaan',
            'sertifikat' => 'dokumen_pendukung.sertifikat',
        ];

        if (!isset($mapping[$type])) {
            abort(404);
        }

        $drhData = DrhData::where('user_id', $userId)->firstOrFail();
        $filePath = $this->resolveDrhFilePath($drhData, $mapping[$type]);

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'Dokumen tidak ditemukan.');
        }

        return response()->file(Storage::disk('public')->path($filePath), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
        ]);
    }

    /**
     * Admin: Download legal document
     */
    public function adminDownloadLegalDoc($userId, $type)
    {
        if (!Session::has('role') || Session::get('role') !== 'admin') {
            return redirect('/login');
        }

        $mapping = [
            'ktp' => 'file_ktp',
            'npwp' => 'file_npwp',
            'bpjs' => 'file_bpjs',
            'kk' => 'file_kk',
            'pasangan' => 'data_pasangan.file',
            'ayah' => 'data_orang_tua.ayah.file',
            'ibu' => 'data_orang_tua.ibu.file',
            'ayah_mertua' => 'data_mertua.ayah.file',
            'ibu_mertua' => 'data_mertua.ibu.file',
            'akta_kelahiran' => 'dokumen_pendukung.akta_kelahiran',
            'diklat' => 'dokumen_pendukung.diklat',
            'ijazah' => 'dokumen_pendukung.ijazah',
            'sk' => 'dokumen_pendukung.sk',
            'penghargaan' => 'dokumen_pendukung.penghargaan',
            'sertifikat' => 'dokumen_pendukung.sertifikat',
        ];

        if (!isset($mapping[$type])) {
            abort(404);
        }

        $drhData = DrhData::where('user_id', $userId)->firstOrFail();
        $filePath = $this->resolveDrhFilePath($drhData, $mapping[$type]);

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'Dokumen tidak ditemukan.');
        }

        return Storage::disk('public')->download($filePath, basename($filePath));
    }

    /**
     * Admin: Print legal document via browser print dialog
     */
    public function adminPrintLegalDoc($userId, $type)
    {
        if (!Session::has('role') || Session::get('role') !== 'admin') {
            return redirect('/login');
        }

        $mapping = [
            'ktp' => 'file_ktp',
            'npwp' => 'file_npwp',
            'bpjs' => 'file_bpjs',
            'kk' => 'file_kk',
            'pasangan' => 'data_pasangan.file',
            'ayah' => 'data_orang_tua.ayah.file',
            'ibu' => 'data_orang_tua.ibu.file',
            'ayah_mertua' => 'data_mertua.ayah.file',
            'ibu_mertua' => 'data_mertua.ibu.file',
            'akta_kelahiran' => 'dokumen_pendukung.akta_kelahiran',
            'diklat' => 'dokumen_pendukung.diklat',
            'ijazah' => 'dokumen_pendukung.ijazah',
            'sk' => 'dokumen_pendukung.sk',
            'penghargaan' => 'dokumen_pendukung.penghargaan',
            'sertifikat' => 'dokumen_pendukung.sertifikat',
        ];

        if (!isset($mapping[$type])) {
            abort(404);
        }

        $drhData = DrhData::where('user_id', $userId)->firstOrFail();
        $filePath = $this->resolveDrhFilePath($drhData, $mapping[$type]);

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'Dokumen tidak ditemukan.');
        }

        $url = asset('storage/' . $filePath);
        $label = strtoupper($type);

        return view('dashboard.admin_legal_print', compact('url', 'label'));
    }

    private function resolveDrhFilePath(DrhData $drhData, string $mapping)
    {
        if (strpos($mapping, '.') === false) {
            return $drhData->{$mapping} ?? null;
        }

        $parts = explode('.', $mapping);
        $value = $drhData;

        foreach ($parts as $part) {
            if (is_array($value)) {
                $value = $value[$part] ?? null;
            } elseif (is_object($value)) {
                $value = $value->{$part} ?? null;
            } else {
                return null;
            }
        }

        return $value;
    }

    /**
     * Admin: Menampilkan Daftar Pegawai (DUK) - Urutan sesuai NIP
     */
    public function adminDuk()
    {
        if (!Session::has('role') || Session::get('role') !== 'admin') {
            return redirect('/login');
        }

        // Query pegawai diurutkan berdasarkan NIP (identifier)
        $pegawai = User::where('role', 'pegawai')
                       ->orderBy('identifier', 'asc')
                       ->get();
        
        $total_pegawai = $pegawai->count();

        return view('dashboard.admin_duk', compact('pegawai', 'total_pegawai'));
    }

    /**
     * Halaman Pengajuan Berkas
     */
    public function pengajuanBerkas()
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        return view('dashboard.pengajuan_berkas');
    }
}
