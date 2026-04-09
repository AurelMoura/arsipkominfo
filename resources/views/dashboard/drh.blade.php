<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRH - Arsip Digital Kominfo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { 
            --sidebar-color: #0b132b; 
            --primary-blue: #2563eb; 
            --light-blue: #eff6ff; 
            --border-blue: #dbeafe; 
        }
        body { background: #eef3fb; font-family: 'Inter', sans-serif; margin: 0; }
        .sidebar { width: 260px; height: 100vh; background: var(--sidebar-color); position: fixed; color: white; z-index: 100; }
        .nav-link { color: #8d94a3; margin: 5px 15px; border-radius: 10px; padding: 10px; text-decoration: none; display: block; }
        .nav-link.active { background: var(--primary-blue); color: white; }
        .nav-link:hover:not(.active) { background: rgba(255,255,255,0.1); color: white; }
        .main-content { margin-left: 260px; padding: 28px; min-height: 100vh; }
        .page-header-label { color: #2563eb; font-weight: 700; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; border-left: 3px solid #2563eb; padding-left: 10px; margin-bottom: 10px; }
        .icon-box { width: 42px; height: 42px; border-radius: 14px; background: rgba(255,255,255,0.18); display: grid; place-items: center; font-size: 1.1rem; }
        .section-card { border: none; border-radius: 18px; overflow: hidden; box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08); background: white; margin-bottom: 20px; }
        .section-card .card-body { background: #fbfdff; }
        .sub-card { background: var(--light-blue); border: 1px solid var(--border-blue); border-radius: 14px; padding: 20px; margin-bottom: 20px; position: relative; transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .sub-card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08); }
        .sub-card-header { font-size: 13px; font-weight: 700; color: #2563eb; margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #dbeafe; padding-bottom: 8px; }

        /* Progress Steps */
        .step-progress { display: flex; justify-content: space-between; gap: 10px; margin-bottom: 30px; background: white; padding: 20px; border-radius: 18px; box-shadow: 0 4px 18px rgba(0,0,0,0.08); overflow-x: auto; }
        .step-item { flex: 1; text-align: center; font-size: 11px; font-weight: 700; color: #94a3b8; min-width: 70px; cursor: pointer; border: none; background: none; padding: 0; text-transform: uppercase; }
        .step-item:focus { outline: none; }
        .step-item { flex: 1; text-align: center; font-size: 10px; font-weight: 700; color: #cbd5e1; min-width: 65px; }
        .step-item.disabled { opacity: 0.45; pointer-events: none; cursor: not-allowed; }
        .step-item.disabled .step-num { border-color: #e2e8f0; }
        .step-item.active { color: var(--primary-blue); }
        .step-num { width: 26px; height: 26px; line-height: 23px; border: 2px solid #cbd5e1; border-radius: 50%; display: block; margin: 0 auto 5px; background: white; }
        .step-item.active .step-num { background: var(--primary-blue); color: white; border-color: var(--primary-blue); }

        /* Card Styles */
        .section-card { border: none; border-radius: 18px; overflow: hidden; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06); background: white; margin-bottom: 20px; }
        .section-header { background: linear-gradient(90deg, #2563eb, #1d4ed8); color: white; padding: 18px 25px; }
        .sub-card { background: var(--light-blue); border: 1px solid var(--border-blue); border-radius: 14px; padding: 20px; margin-bottom: 20px; position: relative; }
        .sub-card-header { font-size: 13px; font-weight: 700; color: #2563eb; margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #dbeafe; padding-bottom: 8px; }

        .form-label { font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .form-control, .form-select { border-radius: 10px; padding: 10px 15px; border: 1px solid #e2e8f0; background-color: #f8fafc; font-size: 14px; }
        .form-control:focus { background-color: white; border-color: var(--primary-blue); box-shadow: none; }

        .upload-box { border: 2px dashed #93c5fd; background: #f8fbff; border-radius: 12px; padding: 15px; color: #2563eb; text-align: center; cursor: pointer; font-size: 13px; transition: 0.2s; }
        .upload-box:hover { background: #eff6ff; }
        .empty-state { border: 2px dashed #cbd5e1; border-radius: 14px; padding: 40px; text-align: center; color: #94a3b8; font-size: 14px; }

        .btn-nav-group { background: white; padding: 20px 30px; border-radius: 18px; display: flex; justify-content: space-between; gap: 10px; flex-wrap: wrap; margin-top: 25px; }
        .form-step { display: none; }
        .form-step.active { display: block; animation: slideUp 0.4s ease-out; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 991px) { .sidebar { display: none; } .main-content { margin-left: 0; } }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column p-3 shadow">
    <div class="d-flex align-items-center mb-4 px-2">
        <div class="d-flex align-items-center gap-2">
            <img src="{{ asset('image/pemkot.png') }}" width="42" class="rounded-circle" style="object-fit: cover;">
            <img src="{{ asset('image/LOGOKOMINFO.png') }}" width="42" class="rounded-circle" style="object-fit: cover;">
        </div>
        <div class="lh-1 text-white ms-3">
            <div class="fw-bold" style="font-size: 14px;">KOMINFO</div>
            <small class="opacity-50" style="font-size: 10px;">Arsip Digital</small>
        </div>
    </div>

    <a href="{{ url('/profile') }}" class="bg-white bg-opacity-10 rounded-4 p-3 d-flex align-items-center mb-4 mx-1 border border-white border-opacity-10 text-decoration-none" 
       style="cursor: pointer;">
        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2 text-white fw-bold shadow-sm" style="width: 40px; height: 40px;">
            {{ strtoupper(substr(Session::get('name'), 0, 1)) }}
        </div>
        <div class="text-white overflow-hidden" style="font-size: 12px;">
            <div class="fw-bold text-truncate">{{ Session::get('name') }}</div>
            <small class="opacity-50 text-truncate d-block">NIP: {{ Session::get('identifier') }}</small>
            <small class="text-white-50 text-truncate d-block mt-1">Kelola Profil</small>
        </div>
        <i class="bi bi-person-circle ms-auto opacity-75 text-white"></i>
    </a>

    <ul class="nav nav-pills flex-column mb-auto">
        <li><a href="{{ url('/dashboard') }}" class="nav-link"><i class="bi bi-grid-fill me-2"></i> Dashboard</a></li>
        <li><a href="{{ url('/pegawai/arsip') }}" class="nav-link"><i class="bi bi-folder2-open me-2"></i> Arsip Dokumen</a></li>
        <li><a href="{{ url('/pengajuan-berkas') }}" class="nav-link"><i class="bi bi-send-fill me-2"></i> Pengajuan Berkas</a></li>
    </ul>
    
    <div class="mt-auto pt-3 border-top border-secondary border-opacity-20">
        <a href="{{ url('/logout') }}" class="nav-link text-danger fw-bold">
            <i class="bi bi-box-arrow-left me-2"></i> Logout
        </a>
    </div>
</div>

<div class="main-content">
    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3 mb-4">
        <div>
            <div class="page-header-label">Daftar Riwayat Hidup</div>
            <h1 class="fw-bold">Daftar Riwayat Hidup</h1>
            <p class="text-muted small">Lengkapi data DRH Anda dan navigasi langsung ke setiap bagian melalui huruf di atas.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ url('/profile') }}" class="btn btn-outline-primary btn-sm">&larr; Kembali ke Kelola Profil</a>
        </div>
    </div>
    <div class="step-progress">
        <button class="step-item active" id="s0" type="button" onclick="setStep(0)"><span class="step-num">A</span>Profil</button>
        <button class="step-item" id="s1" type="button" onclick="setStep(1)"><span class="step-num">B</span>Keluarga</button>
        <button class="step-item" id="s2" type="button" onclick="setStep(2)"><span class="step-num">C</span>Pendidikan</button>
        <button class="step-item" id="s3" type="button" onclick="setStep(3)"><span class="step-num">D</span>Diklat</button>
        <button class="step-item" id="s4" type="button" onclick="setStep(4)"><span class="step-num">E</span>Jabatan</button>
        <button class="step-item" id="s5" type="button" onclick="setStep(5)"><span class="step-num">F</span>Penghargaan</button>
        <button class="step-item" id="s6" type="button" onclick="setStep(6)"><span class="step-num">G</span>Sertifikasi</button>
        <button class="step-item" id="s7" type="button" onclick="setStep(7)"><span class="step-num">H</span>Legal</button>
    </div>

    @if (!($drhData?->profil_dasar_lengkap ?? false))
        <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm mb-4 rounded-4 p-4 text-start" role="alert">
            <div class="d-flex align-items-start">
                <i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 20px; color: #ff9800;"></i>
                <div>
                    <h6 class="fw-bold mb-2" style="color: #ff6f00;">⚠️ Isi A. PROFIL DASAR terlebih dahulu</h6>
                    <p class="mb-0 small">Bagian B sampai H terkunci sampai Profil Dasar selesai disimpan. Lengkapi data A untuk membuka semua bagian DRH.</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class=\"alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-4 p-4 text-start\" role=\"alert\" style=\"background: #d4edda; border-left: 4px solid #28a745;\">
            <div class=\"d-flex align-items-start\">
                <i class=\"bi bi-check-circle-fill me-3\" style=\"font-size: 24px; color: #28a745; flex-shrink: 0;\"></i>
                <div>
                    <h6 class=\"fw-bold mb-2\" style=\"color: #155724;\">{{ session('success') }}</h6>
                    <p class=\"mb-0 small\">Data profil dasar Anda telah tersimpan dengan baik di sistem</p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 rounded-4 p-3 text-start" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form id="drhForm" action="{{ url('/profile/drh') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="step" id="stepInput" value="0">
        @php
            $anakRows = old('anak', $drhData?->data_anak ?? []);
            $pendidikanRows = old('pendidikan', $drhData?->riwayat_pendidikan ?? []);
            $diklatRows = old('diklat', $drhData?->riwayat_diklat ?? []);
            $jabatanRows = old('riwayat_jabatan', $drhData?->riwayat_jabatan ?? []);
            $awardRows = old('award', $drhData?->riwayat_penghargaan ?? []);
            $sertifRows = old('sertif', $drhData?->riwayat_sertifikasi ?? []);
        @endphp
        <div class="form-step active">
            <div class="card section-card">
                <div class="section-header d-flex align-items-center gap-3">
                    <div class="icon-box"><i class="bi bi-person-fill"></i></div>
                    <div><h5 class="fw-bold mb-0">A. Profil Dasar</h5><small class="opacity-75">Data identitas pribadi dan kepegawaian</small></div>
                </div>
                <div class="card-body p-4 text-start">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">NIP</label><input type="text" class="form-control" value="{{ Session::get('identifier') }}" readonly></div>
                        <div class="col-md-6"><label class="form-label">Nama Lengkap</label><input type="text" class="form-control" value="{{ Session::get('name') }}" readonly></div>
                        <div class="col-12"><label class="form-label">NIK *</label><input type="text" class="form-control" name="nik" placeholder="16 digit NIK" value="{{ old('nik', $drhData?->nik ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">Email *</label><input type="email" class="form-control" name="email" placeholder="nama@kominfo.go.id" value="{{ old('email', $drhData?->email ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">No. HP *</label><input type="text" class="form-control" name="no_hp" placeholder="081234567890" value="{{ old('no_hp', $drhData?->no_hp ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">Alamat Domisili *</label><textarea class="form-control" name="alamat_domisili" rows="2" placeholder="Jl. Contoh No. 1, Kelurahan, Kecamatan, Kota">{{ old('alamat_domisili', $drhData?->alamat_domisili ?? '') }}</textarea></div>
                        <div class="col-md-6"><label class="form-label">Tempat Lahir *</label><input type="text" class="form-control" name="tempat_lahir" placeholder="Nama kota lahir" value="{{ old('tempat_lahir', $drhData?->tempat_lahir ?? '') }}"></div>
                        <div class="col-md-6"><label class="form-label">Kabupaten Asal *</label><input type="text" class="form-control" name="kabupaten_asal" placeholder="Nama kabupaten" value="{{ old('kabupaten_asal', $drhData?->kabupaten_asal ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">Tanggal Lahir *</label><input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', $drhData?->tanggal_lahir?->format('Y-m-d') ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">Jenis Kelamin *</label><select class="form-select" name="jenis_kelamin"><option value="">Pilih</option><option value="Laki-laki" {{ old('jenis_kelamin', $drhData?->jenis_kelamin ?? '') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option><option value="Perempuan" {{ old('jenis_kelamin', $drhData?->jenis_kelamin ?? '') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option></select></div>
                        <div class="col-12"><label class="form-label">Agama *</label><select class="form-select" name="agama"><option value="">Pilih</option><option value="Islam" {{ old('agama', $drhData?->agama ?? '') === 'Islam' ? 'selected' : '' }}>Islam</option><option value="Kristen" {{ old('agama', $drhData?->agama ?? '') === 'Kristen' ? 'selected' : '' }}>Kristen</option><option value="Katolik" {{ old('agama', $drhData?->agama ?? '') === 'Katolik' ? 'selected' : '' }}>Katolik</option><option value="Hindu" {{ old('agama', $drhData?->agama ?? '') === 'Hindu' ? 'selected' : '' }}>Hindu</option><option value="Buddha" {{ old('agama', $drhData?->agama ?? '') === 'Buddha' ? 'selected' : '' }}>Buddha</option></select></div>
                        <div class="col-12"><label class="form-label">Golongan Darah *</label><select class="form-select" name="golongan_darah"><option value="">Pilih</option><option value="A" {{ old('golongan_darah', $drhData?->golongan_darah ?? '') === 'A' ? 'selected' : '' }}>A</option><option value="B" {{ old('golongan_darah', $drhData?->golongan_darah ?? '') === 'B' ? 'selected' : '' }}>B</option><option value="AB" {{ old('golongan_darah', $drhData?->golongan_darah ?? '') === 'AB' ? 'selected' : '' }}>AB</option><option value="O" {{ old('golongan_darah', $drhData?->golongan_darah ?? '') === 'O' ? 'selected' : '' }}>O</option></select></div>
                        <div class="col-12"><label class="form-label">Status Pegawai *</label>
                            <select class="form-select" id="statusPegawai" name="status_pegawai" onchange="toggleFamilyLogic()">
                                <option value="Belum Menikah" {{ old('status_pegawai', $drhData?->status_pegawai ?? '') === 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="Menikah" {{ old('status_pegawai', $drhData?->status_pegawai ?? '') === 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                <option value="Cerai Hidup" {{ old('status_pegawai', $drhData?->status_pegawai ?? '') === 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ old('status_pegawai', $drhData?->status_pegawai ?? '') === 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                        </div>
                        <div class="col-12"><label class="form-label">Jenis ASN *</label><select class="form-select" name="jenis_asn"><option value="">Pilih jenis</option><option value="PNS" {{ old('jenis_asn', $drhData?->jenis_asn ?? '') === 'PNS' ? 'selected' : '' }}>PNS</option><option value="PPPK" {{ old('jenis_asn', $drhData?->jenis_asn ?? '') === 'PPPK' ? 'selected' : '' }}>PPPK</option></select></div>
                        <div class="col-md-6"><label class="form-label">Jabatan *</label><input type="text" class="form-control" name="jabatan" placeholder="Contoh: Analis Sistem" value="{{ old('jabatan', $drhData?->jabatan ?? '') }}"></div>
                        <div class="col-md-6"><label class="form-label">TMT (Terhitung Mulai Tanggal) *</label><input type="date" class="form-control" name="tmt" value="{{ old('tmt', $drhData?->tmt?->format('Y-m-d') ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">Golongan *</label><select class="form-select" name="golongan"><option value="">Pilih golongan</option><option value="I/a" {{ old('golongan', $drhData?->golongan ?? '') === 'I/a' ? 'selected' : '' }}>I/a</option><option value="I/b" {{ old('golongan', $drhData?->golongan ?? '') === 'I/b' ? 'selected' : '' }}>I/b</option><option value="I/c" {{ old('golongan', $drhData?->golongan ?? '') === 'I/c' ? 'selected' : '' }}>I/c</option><option value="I/d" {{ old('golongan', $drhData?->golongan ?? '') === 'I/d' ? 'selected' : '' }}>I/d</option><option value="II/a" {{ old('golongan', $drhData?->golongan ?? '') === 'II/a' ? 'selected' : '' }}>II/a</option><option value="II/b" {{ old('golongan', $drhData?->golongan ?? '') === 'II/b' ? 'selected' : '' }}>II/b</option><option value="II/c" {{ old('golongan', $drhData?->golongan ?? '') === 'II/c' ? 'selected' : '' }}>II/c</option><option value="II/d" {{ old('golongan', $drhData?->golongan ?? '') === 'II/d' ? 'selected' : '' }}>II/d</option><option value="III/a" {{ old('golongan', $drhData?->golongan ?? '') === 'III/a' ? 'selected' : '' }}>III/a</option><option value="III/b" {{ old('golongan', $drhData?->golongan ?? '') === 'III/b' ? 'selected' : '' }}>III/b</option><option value="III/c" {{ old('golongan', $drhData?->golongan ?? '') === 'III/c' ? 'selected' : '' }}>III/c</option><option value="III/d" {{ old('golongan', $drhData?->golongan ?? '') === 'III/d' ? 'selected' : '' }}>III/d</option><option value="IV/a" {{ old('golongan', $drhData?->golongan ?? '') === 'IV/a' ? 'selected' : '' }}>IV/a</option><option value="IV/b" {{ old('golongan', $drhData?->golongan ?? '') === 'IV/b' ? 'selected' : '' }}>IV/b</option><option value="IV/c" {{ old('golongan', $drhData?->golongan ?? '') === 'IV/c' ? 'selected' : '' }}>IV/c</option><option value="IV/d" {{ old('golongan', $drhData?->golongan ?? '') === 'IV/d' ? 'selected' : '' }}>IV/d</option><option value="IV/e" {{ old('golongan', $drhData?->golongan ?? '') === 'IV/e' ? 'selected' : '' }}>IV/e</option></select></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-step">
            <div class="card section-card">
                <div class="section-header d-flex align-items-center gap-3">
                    <div class="icon-box"><i class="bi bi-people-fill"></i></div>
                    <div><h5 class="fw-bold mb-0">B. Dokumen Keluarga</h5><small class="opacity-75">Data Pasangan, Anak, Orang Tua, & Mertua</small></div>
                </div>
                <div class="card-body p-4 text-start">
                    <div id="sectionPasangan" style="display:none;" class="mb-5">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-heart text-danger me-2"></i>Data Pasangan</h6>
                        <div class="sub-card">
                            <div class="sub-card-header"><span><i class="bi bi-heart-fill"></i> Informasi Suami / Istri</span></div>
                            <div class="row g-3">
                                <div class="col-md-6"><label class="form-label">NIK Pasangan</label><input type="text" class="form-control @error('nik_pasangan') is-invalid @enderror" name="nik_pasangan" placeholder="16 digit NIK" value="{{ old('nik_pasangan', $drhData?->data_pasangan['nik'] ?? '') }}"><div class="invalid-feedback">@error('nik_pasangan'){{ $message }}@enderror</div></div>
                                <div class="col-md-6"><label class="form-label">Nama Pasangan *</label><input type="text" class="form-control @error('nama_pasangan') is-invalid @enderror" name="nama_pasangan" placeholder="Nama lengkap pasangan" value="{{ old('nama_pasangan', $drhData?->data_pasangan['nama'] ?? '') }}"><div class="invalid-feedback">@error('nama_pasangan'){{ $message }}@enderror</div></div>
                                <div class="col-md-6"><label class="form-label">Status Pasangan</label><select class="form-select @error('status_pasangan_select') is-invalid @enderror" name="status_pasangan_select"><option value="SUAMI" {{ old('status_pasangan_select', $drhData?->data_pasangan['status'] ?? '') === 'SUAMI' ? 'selected' : '' }}>SUAMI</option><option value="ISTRI" {{ old('status_pasangan_select', $drhData?->data_pasangan['status'] ?? '') === 'ISTRI' ? 'selected' : '' }}>ISTRI</option></select><div class="invalid-feedback">@error('status_pasangan_select'){{ $message }}@enderror</div></div>
                                <div class="col-md-6"><label class="form-label">Status Hidup</label><select class="form-select @error('status_hidup_pasangan') is-invalid @enderror" name="status_hidup_pasangan"><option value="Hidup" {{ old('status_hidup_pasangan', $drhData?->data_pasangan['status_hidup'] ?? '') === 'Hidup' ? 'selected' : '' }}>Hidup</option><option value="Meninggal" {{ old('status_hidup_pasangan', $drhData?->data_pasangan['status_hidup'] ?? '') === 'Meninggal' ? 'selected' : '' }}>Meninggal</option></select><div class="invalid-feedback">@error('status_hidup_pasangan'){{ $message }}@enderror</div></div>
                                <div class="col-md-6"><label class="form-label">Tempat Lahir</label><input type="text" class="form-control @error('tempat_lahir_pasangan') is-invalid @enderror" name="tempat_lahir_pasangan" placeholder="Kota lahir pasangan" value="{{ old('tempat_lahir_pasangan', $drhData?->data_pasangan['tempat_lahir'] ?? '') }}"><div class="invalid-feedback">@error('tempat_lahir_pasangan'){{ $message }}@enderror</div></div>
                                <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control @error('tanggal_lahir_pasangan') is-invalid @enderror" name="tanggal_lahir_pasangan" value="{{ old('tanggal_lahir_pasangan', $drhData?->data_pasangan['tanggal_lahir'] ?? '') }}"><div class="invalid-feedback">@error('tanggal_lahir_pasangan'){{ $message }}@enderror</div></div>
                                <div class="col-md-6"><label class="form-label">Pekerjaan</label><input type="text" class="form-control @error('pekerjaan_pasangan') is-invalid @enderror" name="pekerjaan_pasangan" placeholder="Pekerjaan pasangan" value="{{ old('pekerjaan_pasangan', $drhData?->data_pasangan['pekerjaan'] ?? '') }}"><div class="invalid-feedback">@error('pekerjaan_pasangan'){{ $message }}@enderror</div></div>
                                <div class="col-12">
                                    <div class="upload-box @error('file_pasangan') border border-danger @enderror">
                                        <input type="file" name="file_pasangan" accept=".pdf" style="display: none;" id="file_pasangan">
                                        <label for="file_pasangan" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-upload me-2"></i> Upload Dokumen Kartu Suami/Istri (PDF, maks 1 MB)
                                        </label>
                                    </div>
                                    @if(data_get($drhData, 'data_pasangan.file'))
                                        <div class="mt-2 d-flex gap-2 flex-wrap">
                                            <a href="{{ url('/profile/drh/file/pasangan/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                            <a href="{{ url('/profile/drh/file/pasangan/download') }}" class="btn btn-outline-secondary btn-sm">Unduh</a>
                                        </div>
                                    @endif
                                    @error('file_pasangan')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="sectionAnak" style="display:none;" class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0">Data Anak</h6>
                            <button type="button" class="btn btn-primary btn-sm rounded-pill" onclick="addAnak()">+ Tambah Anak</button>
                        </div>
                        <div id="anakContainer">
                            @if(count($anakRows) > 0)
                                @foreach($anakRows as $index => $anak)
                                    @php $anakFile = $anak['file'] ?? null; @endphp
                                    <div class="sub-card">
                                        <div class="sub-card-header d-flex justify-content-between align-items-center"><span class="text-primary">Anak ke-{{ $index + 1 }}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
                                        <div class="row g-3">
                                            <div class="col-md-6"><label class="form-label">Nama Anak *</label><input type="text" class="form-control" name="anak[{{ $index }}][nama]" value="{{ old('anak.'.$index.'.nama', $anak['nama'] ?? '') }}"></div>
                                            <div class="col-md-6"><label class="form-label">NIK</label><input type="text" class="form-control" name="anak[{{ $index }}][nik]" value="{{ old('anak.'.$index.'.nik', $anak['nik'] ?? '') }}"></div>
                                            <div class="col-md-6"><label class="form-label">Tempat Lahir</label><input type="text" class="form-control" name="anak[{{ $index }}][tempat_lahir]" value="{{ old('anak.'.$index.'.tempat_lahir', $anak['tempat_lahir'] ?? '') }}"></div>
                                            <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control" name="anak[{{ $index }}][tanggal_lahir]" value="{{ old('anak.'.$index.'.tanggal_lahir', $anak['tanggal_lahir'] ?? '') }}"></div>
                                            <div class="col-md-6"><label class="form-label">Status Anak</label><select class="form-select" name="anak[{{ $index }}][status_anak]"><option {{ old('anak.'.$index.'.status_anak', $anak['status_anak'] ?? '') === 'Kandung' ? 'selected' : '' }}>Kandung</option><option {{ old('anak.'.$index.'.status_anak', $anak['status_anak'] ?? '') === 'Tiri' ? 'selected' : '' }}>Tiri</option><option {{ old('anak.'.$index.'.status_anak', $anak['status_anak'] ?? '') === 'Angkat' ? 'selected' : '' }}>Angkat</option></select></div>
                                            <div class="col-md-6">
                                                <label class="form-label">Akta Kelahiran</label>
                                                @if($anakFile)
                                                    <div class="mt-2 d-flex gap-2 flex-wrap">
                                                        <a href="{{ asset('storage/'.$anakFile) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Dokumen</a>
                                                    </div>
                                                @else
                                                    <div class="upload-box">
                                                        <input type="file" id="anak_file_{{ $index }}" name="anak[{{ $index }}][file]" accept=".pdf" style="display:none;">
                                                        <label for="anak_file_{{ $index }}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload me-2"></i> Upload Akta Kelahiran</label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state" id="emptyAnak">Belum ada data anak. Klik "Tambah Anak" untuk menambahkan.</div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6 class="fw-bold text-dark mb-3">Data Orang Tua <span class="text-danger small">(Wajib)</span></h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="sub-card">
                                    <h6>Ayah</h6>
                                    <div class="row g-3">
                                        <div class="col-12"><label class="form-label">Nama Ayah</label><input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" name="nama_ayah" placeholder="Nama Ayah" value="{{ old('nama_ayah', $drhData?->data_orang_tua['ayah']['nama'] ?? '') }}"><div class="invalid-feedback">@error('nama_ayah'){{ $message }}@enderror</div></div>
                                        <div class="col-12"><label class="form-label">Alamat Ayah</label><textarea class="form-control @error('alamat_ayah') is-invalid @enderror" name="alamat_ayah" rows="2" placeholder="Alamat Ayah">{{ old('alamat_ayah', $drhData?->data_orang_tua['ayah']['alamat'] ?? '') }}</textarea><div class="invalid-feedback">@error('alamat_ayah'){{ $message }}@enderror</div></div>
                                        <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control @error('tanggal_lahir_ayah') is-invalid @enderror" name="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah', $drhData?->data_orang_tua['ayah']['tanggal_lahir'] ?? '') }}"><div class="invalid-feedback">@error('tanggal_lahir_ayah'){{ $message }}@enderror</div></div>
                                        <div class="col-md-6"><label class="form-label">Status Hidup</label><select class="form-select @error('status_ayah') is-invalid @enderror" name="status_ayah"><option value="Hidup" {{ old('status_ayah', $drhData?->data_orang_tua['ayah']['status_hidup'] ?? '') === 'Hidup' ? 'selected' : '' }}>Hidup</option><option value="Meninggal" {{ old('status_ayah', $drhData?->data_orang_tua['ayah']['status_hidup'] ?? '') === 'Meninggal' ? 'selected' : '' }}>Meninggal</option></select><div class="invalid-feedback">@error('status_ayah'){{ $message }}@enderror</div></div>
                                        <div class="col-md-6"><label class="form-label">Pekerjaan</label><input type="text" class="form-control @error('pekerjaan_ayah') is-invalid @enderror" name="pekerjaan_ayah" placeholder="Pekerjaan Ayah" value="{{ old('pekerjaan_ayah', $drhData?->data_orang_tua['ayah']['pekerjaan'] ?? '') }}"><div class="invalid-feedback">@error('pekerjaan_ayah'){{ $message }}@enderror</div></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sub-card">
                                    <h6>Ibu</h6>
                                    <div class="row g-3">
                                        <div class="col-12"><label class="form-label">Nama Ibu</label><input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" name="nama_ibu" placeholder="Nama Ibu" value="{{ old('nama_ibu', $drhData?->data_orang_tua['ibu']['nama'] ?? '') }}"><div class="invalid-feedback">@error('nama_ibu'){{ $message }}@enderror</div></div>
                                        <div class="col-12"><label class="form-label">Alamat Ibu</label><textarea class="form-control @error('alamat_ibu') is-invalid @enderror" name="alamat_ibu" rows="2" placeholder="Alamat Ibu">{{ old('alamat_ibu', $drhData?->data_orang_tua['ibu']['alamat'] ?? '') }}</textarea><div class="invalid-feedback">@error('alamat_ibu'){{ $message }}@enderror</div></div>
                                        <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control @error('tanggal_lahir_ibu') is-invalid @enderror" name="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu', $drhData?->data_orang_tua['ibu']['tanggal_lahir'] ?? '') }}"><div class="invalid-feedback">@error('tanggal_lahir_ibu'){{ $message }}@enderror</div></div>
                                        <div class="col-md-6"><label class="form-label">Status Hidup</label><select class="form-select @error('status_ibu') is-invalid @enderror" name="status_ibu"><option value="Hidup" {{ old('status_ibu', $drhData?->data_orang_tua['ibu']['status_hidup'] ?? '') === 'Hidup' ? 'selected' : '' }}>Hidup</option><option value="Meninggal" {{ old('status_ibu', $drhData?->data_orang_tua['ibu']['status_hidup'] ?? '') === 'Meninggal' ? 'selected' : '' }}>Meninggal</option></select><div class="invalid-feedback">@error('status_ibu'){{ $message }}@enderror</div></div>
                                        <div class="col-md-6"><label class="form-label">Pekerjaan</label><input type="text" class="form-control @error('pekerjaan_ibu') is-invalid @enderror" name="pekerjaan_ibu" placeholder="Pekerjaan Ibu" value="{{ old('pekerjaan_ibu', $drhData?->data_orang_tua['ibu']['pekerjaan'] ?? '') }}"><div class="invalid-feedback">@error('pekerjaan_ibu'){{ $message }}@enderror</div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="sectionMertua" style="display:none;" class="mt-4">
                        <h6 class="fw-bold text-dark mb-3">Data Mertua</h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="sub-card">
                                    <h6>Ayah Mertua</h6>
                                    <div class="row g-3">
                                        <div class="col-12"><label class="form-label">Nama Ayah Mertua</label><input type="text" class="form-control @error('nama_ayah_mertua') is-invalid @enderror" name="nama_ayah_mertua" placeholder="Nama Ayah Mertua" value="{{ old('nama_ayah_mertua', $drhData?->data_mertua['ayah']['nama'] ?? '') }}"><div class="invalid-feedback">@error('nama_ayah_mertua'){{ $message }}@enderror</div></div>
                                        <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control @error('tanggal_lahir_ayah_mertua') is-invalid @enderror" name="tanggal_lahir_ayah_mertua" value="{{ old('tanggal_lahir_ayah_mertua', $drhData?->data_mertua['ayah']['tanggal_lahir'] ?? '') }}"><div class="invalid-feedback">@error('tanggal_lahir_ayah_mertua'){{ $message }}@enderror</div></div>
                                        <div class="col-md-6"><label class="form-label">Status Hidup</label><select class="form-select @error('status_ayah_mertua') is-invalid @enderror" name="status_ayah_mertua"><option value="Hidup" {{ old('status_ayah_mertua', $drhData?->data_mertua['ayah']['status_hidup'] ?? '') === 'Hidup' ? 'selected' : '' }}>Hidup</option><option value="Meninggal" {{ old('status_ayah_mertua', $drhData?->data_mertua['ayah']['status_hidup'] ?? '') === 'Meninggal' ? 'selected' : '' }}>Meninggal</option></select><div class="invalid-feedback">@error('status_ayah_mertua'){{ $message }}@enderror</div></div>
                                        <div class="col-md-6"><label class="form-label">Pekerjaan</label><input type="text" class="form-control @error('pekerjaan_ayah_mertua') is-invalid @enderror" name="pekerjaan_ayah_mertua" placeholder="Pekerjaan Ayah Mertua" value="{{ old('pekerjaan_ayah_mertua', $drhData?->data_mertua['ayah']['pekerjaan'] ?? '') }}"><div class="invalid-feedback">@error('pekerjaan_ayah_mertua'){{ $message }}@enderror</div></div>
                                        <div class="col-12">
                                            <div class="upload-box @error('file_ayah_mertua') border border-danger @enderror">
                                                <input type="file" name="file_ayah_mertua" accept=".pdf" style="display: none;" id="file_ayah_mertua">
                                                <label for="file_ayah_mertua" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-upload me-2"></i> Upload Dokumen KTP Ayah Mertua (PDF, maks 1 MB)
                                                </label>
                                            </div>
                                            @if(data_get($drhData, 'data_mertua.ayah.file'))
                                                <div class="mt-2 d-flex gap-2 flex-wrap">
                                                    <a href="{{ url('/profile/drh/file/ayah_mertua/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                                    <a href="{{ url('/profile/drh/file/ayah_mertua/download') }}" class="btn btn-outline-secondary btn-sm">Unduh</a>
                                                </div>
                                            @endif
                                            @error('file_ayah_mertua')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sub-card">
                                    <h6>Ibu Mertua</h6>
                                    <div class="row g-3">
                                        <div class="col-12"><label class="form-label">Nama Ibu Mertua</label><input type="text" class="form-control @error('nama_ibu_mertua') is-invalid @enderror" name="nama_ibu_mertua" placeholder="Nama Ibu Mertua" value="{{ old('nama_ibu_mertua', $drhData?->data_mertua['ibu']['nama'] ?? '') }}"><div class="invalid-feedback">@error('nama_ibu_mertua'){{ $message }}@enderror</div></div>
                                        <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control @error('tanggal_lahir_ibu_mertua') is-invalid @enderror" name="tanggal_lahir_ibu_mertua" value="{{ old('tanggal_lahir_ibu_mertua', $drhData?->data_mertua['ibu']['tanggal_lahir'] ?? '') }}"><div class="invalid-feedback">@error('tanggal_lahir_ibu_mertua'){{ $message }}@enderror</div></div>
                                        <div class="col-md-6"><label class="form-label">Status Hidup</label><select class="form-select @error('status_ibu_mertua') is-invalid @enderror" name="status_ibu_mertua"><option value="Hidup" {{ old('status_ibu_mertua', $drhData?->data_mertua['ibu']['status_hidup'] ?? '') === 'Hidup' ? 'selected' : '' }}>Hidup</option><option value="Meninggal" {{ old('status_ibu_mertua', $drhData?->data_mertua['ibu']['status_hidup'] ?? '') === 'Meninggal' ? 'selected' : '' }}>Meninggal</option></select><div class="invalid-feedback">@error('status_ibu_mertua'){{ $message }}@enderror</div></div>
                                        <div class="col-md-6"><label class="form-label">Pekerjaan</label><input type="text" class="form-control @error('pekerjaan_ibu_mertua') is-invalid @enderror" name="pekerjaan_ibu_mertua" placeholder="Pekerjaan Ibu Mertua" value="{{ old('pekerjaan_ibu_mertua', $drhData?->data_mertua['ibu']['pekerjaan'] ?? '') }}"><div class="invalid-feedback">@error('pekerjaan_ibu_mertua'){{ $message }}@enderror</div></div>
                                        <div class="col-12">
                                            <div class="upload-box @error('file_ibu_mertua') border border-danger @enderror">
                                                <input type="file" name="file_ibu_mertua" accept=".pdf" style="display: none;" id="file_ibu_mertua">
                                                <label for="file_ibu_mertua" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-upload me-2"></i> Upload Dokumen KTP Ibu Mertua (PDF, maks 1 MB)
                                                </label>
                                            </div>
                                            @if(data_get($drhData, 'data_mertua.ibu.file'))
                                                <div class="mt-2 d-flex gap-2 flex-wrap">
                                                    <a href="{{ url('/profile/drh/file/ibu_mertua/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                                    <a href="{{ url('/profile/drh/file/ibu_mertua/download') }}" class="btn btn-outline-secondary btn-sm">Unduh</a>
                                                </div>
                                            @endif
                                            @error('file_ibu_mertua')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-step">
            <div class="card section-card">
                <div class="section-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0">C. Riwayat Pendidikan</h5>
                        <small class="opacity-75">Riwayat pendidikan formal dari SD hingga S3</small>
                    </div>
                    <button type="button" class="btn btn-light btn-sm text-primary fw-bold" onclick="addPendidikan()">+ Tambah Pendidikan</button>
                </div>
                <div class="card-body p-4" id="pendidikanContainer">
                    @if(count($pendidikanRows) > 0)
                        @foreach($pendidikanRows as $index => $pendidikan)
                            <div class="sub-card text-start">
                                <div class="sub-card-header d-flex justify-content-between align-items-center"><span>Pendidikan {{ $index + 1 }}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
                                <div class="row g-3">
                                    @if(!empty($pendidikan['id']))
                                        <input type="hidden" name="pendidikan[{{ $index }}][id]" value="{{ $pendidikan['id'] }}">
                                    @endif
                                    <div class="col-md-6"><label class="form-label">Jenjang Pendidikan *</label><select class="form-select" name="pendidikan[{{ $index }}][jenjang]"><option {{ old('pendidikan.'.$index.'.jenjang', $pendidikan['jenjang'] ?? '') === 'SD' ? 'selected' : '' }}>SD</option><option {{ old('pendidikan.'.$index.'.jenjang', $pendidikan['jenjang'] ?? '') === 'SMP' ? 'selected' : '' }}>SMP</option><option {{ old('pendidikan.'.$index.'.jenjang', $pendidikan['jenjang'] ?? '') === 'SMA' ? 'selected' : '' }}>SMA</option><option {{ old('pendidikan.'.$index.'.jenjang', $pendidikan['jenjang'] ?? '') === 'D1' ? 'selected' : '' }}>D1</option><option {{ old('pendidikan.'.$index.'.jenjang', $pendidikan['jenjang'] ?? '') === 'D2' ? 'selected' : '' }}>D2</option><option {{ old('pendidikan.'.$index.'.jenjang', $pendidikan['jenjang'] ?? '') === 'D3' ? 'selected' : '' }}>D3</option><option {{ old('pendidikan.'.$index.'.jenjang', $pendidikan['jenjang'] ?? '') === 'D4' ? 'selected' : '' }}>D4</option><option {{ old('pendidikan.'.$index.'.jenjang', $pendidikan['jenjang'] ?? '') === 'S1' ? 'selected' : '' }}>S1</option><option {{ old('pendidikan.'.$index.'.jenjang', $pendidikan['jenjang'] ?? '') === 'S2' ? 'selected' : '' }}>S2</option><option {{ old('pendidikan.'.$index.'.jenjang', $pendidikan['jenjang'] ?? '') === 'S3' ? 'selected' : '' }}>S3</option></select></div>
                                    <div class="col-md-6"><label class="form-label">Nama Sekolah / Universitas *</label><input type="text" class="form-control" name="pendidikan[{{ $index }}][nama_sekolah]" value="{{ old('pendidikan.'.$index.'.nama_sekolah', $pendidikan['nama_sekolah'] ?? '') }}"></div>
                                    <div class="col-md-6"><label class="form-label">Tahun Masuk</label><input type="text" class="form-control" name="pendidikan[{{ $index }}][tahun_masuk]" placeholder="2000" value="{{ old('pendidikan.'.$index.'.tahun_masuk', $pendidikan['tahun_masuk'] ?? '') }}"></div>
                                    <div class="col-md-6"><label class="form-label">Tahun Lulus</label><input type="text" class="form-control" name="pendidikan[{{ $index }}][tahun_lulus]" placeholder="2004" value="{{ old('pendidikan.'.$index.'.tahun_lulus', $pendidikan['tahun_lulus'] ?? '') }}"></div>
                                    <div class="col-md-6"><label class="form-label">No. Ijazah</label><input type="text" class="form-control" name="pendidikan[{{ $index }}][nomor_ijazah]" placeholder="Nomor Ijazah" value="{{ old('pendidikan.'.$index.'.nomor_ijazah', $pendidikan['nomor_ijazah'] ?? '') }}"></div>
                                    <div class="col-md-6"><label class="form-label">Nama Pejabat TTD Ijazah</label><input type="text" class="form-control" name="pendidikan[{{ $index }}][nama_pejabat]" placeholder="Nama pejabat penandatangan" value="{{ old('pendidikan.'.$index.'.nama_pejabat', $pendidikan['nama_pejabat'] ?? '') }}"></div>
                                    <div class="col-12">
                                        @php $pendidikanFile = old('pendidikan.'.$index.'.old_file', $pendidikan['file'] ?? null); @endphp
                                        @if($pendidikanFile)
                                            <div class="alert alert-success py-2 px-3 d-flex justify-content-between align-items-center">
                                                <span class="mb-0">Dokumen Tersedia</span>
                                                <a href="{{ asset('storage/'.$pendidikanFile) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Dokumen</a>
                                            </div>
                                            <input type="hidden" name="pendidikan[{{ $index }}][old_file]" value="{{ $pendidikanFile }}">
                                        @else
                                            <div class="upload-box">
                                                <input type="file" id="pendidikan_file_{{ $index }}" name="pendidikan[{{ $index }}][file]" accept=".pdf" style="display:none;">
                                                <label for="pendidikan_file_{{ $index }}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload"></i> Upload Ijazah (PDF, maks 1 MB)</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="form-step">
            <div class="card section-card">
                <div class="section-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0">D. Riwayat Diklat</h5>
                        <small class="opacity-75">Riwayat pelatihan dan pendidikan kedinasan</small>
                    </div>
                    <button type="button" class="btn btn-light btn-sm text-primary fw-bold" onclick="addDiklat()">+ Tambah Diklat</button>
                </div>
                <div class="card-body p-4" id="diklatContainer">
                    @if(count($diklatRows) > 0)
                        @foreach($diklatRows as $index => $diklat)
                            <div class="sub-card text-start">
                                <div class="sub-card-header d-flex justify-content-between align-items-center"><span>Diklat {{ $index + 1 }}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
                                <div class="row g-3">
                                    @if(!empty($diklat['id']))
                                        <input type="hidden" name="diklat[{{ $index }}][id]" value="{{ $diklat['id'] }}">
                                    @endif
                                    <div class="col-md-6"><label class="form-label">Nama Diklat *</label><input type="text" class="form-control" name="diklat[{{ $index }}][nama]" value="{{ old('diklat.'.$index.'.nama', $diklat['nama'] ?? '') }}"></div>
                                    <div class="col-md-6"><label class="form-label">Penyelenggara *</label><input type="text" class="form-control" name="diklat[{{ $index }}][penyelenggara]" value="{{ old('diklat.'.$index.'.penyelenggara', $diklat['penyelenggara'] ?? '') }}"></div>
                                    <div class="col-md-6"><label class="form-label">Nomor Sertifikat</label><input type="text" class="form-control" name="diklat[{{ $index }}][nomor_sertifikat]" value="{{ old('diklat.'.$index.'.nomor_sertifikat', $diklat['nomor_sertifikat'] ?? '') }}"></div>
                                    <div class="col-md-6"><label class="form-label">Tahun</label><input type="text" class="form-control" name="diklat[{{ $index }}][tahun]" placeholder="2020" value="{{ old('diklat.'.$index.'.tahun', $diklat['tahun'] ?? '') }}"></div>
                                    <div class="col-12">
                                        @php $diklatFile = old('diklat.'.$index.'.old_file', $diklat['file'] ?? null); @endphp
                                        @if($diklatFile)
                                            <div class="alert alert-success py-2 px-3 d-flex justify-content-between align-items-center">
                                                <span class="mb-0">Dokumen Tersedia</span>
                                                <a href="{{ asset('storage/'.$diklatFile) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Dokumen</a>
                                            </div>
                                            <input type="hidden" name="diklat[{{ $index }}][old_file]" value="{{ $diklatFile }}">
                                        @else
                                            <div class="upload-box">
                                                <input type="file" id="diklat_file_{{ $index }}" name="diklat[{{ $index }}][file]" accept=".pdf" style="display:none;">
                                                <label for="diklat_file_{{ $index }}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload"></i> Upload Sertifikat Diklat (PDF, maks 1 MB)</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="form-step">
            <div class="card section-card">
                <div class="section-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0">E. Riwayat Jabatan</h5>
                        <small class="opacity-75">Riwayat jabatan dan kepangkatan selama berkarir</small>
                    </div>
                    <button type="button" class="btn btn-light btn-sm text-primary fw-bold" onclick="addJabatan()">+ Tambah Jabatan</button>
                </div>
                <div class="card-body p-4" id="jabatanContainer">
                    @if(count($jabatanRows) > 0)
                        @foreach($jabatanRows as $index => $jabatan)
                            <div class="sub-card text-start">
                                <div class="sub-card-header d-flex justify-content-between align-items-center"><span>Jabatan {{ $index + 1 }}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
                                <div class="row g-3">
                                    <div class="col-md-6"><label class="form-label">Golongan *</label><select class="form-select" name="riwayat_jabatan[{{ $index }}][golongan]"><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'I/a' ? 'selected' : '' }}>I/a</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'I/b' ? 'selected' : '' }}>I/b</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'I/c' ? 'selected' : '' }}>I/c</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'I/d' ? 'selected' : '' }}>I/d</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'II/a' ? 'selected' : '' }}>II/a</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'II/b' ? 'selected' : '' }}>II/b</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'II/c' ? 'selected' : '' }}>II/c</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'II/d' ? 'selected' : '' }}>II/d</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'III/a' ? 'selected' : '' }}>III/a</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'III/b' ? 'selected' : '' }}>III/b</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'III/c' ? 'selected' : '' }}>III/c</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'III/d' ? 'selected' : '' }}>III/d</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'IV/a' ? 'selected' : '' }}>IV/a</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'IV/b' ? 'selected' : '' }}>IV/b</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'IV/c' ? 'selected' : '' }}>IV/c</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'IV/d' ? 'selected' : '' }}>IV/d</option><option {{ old('riwayat_jabatan.'.$index.'.golongan', $jabatan['golongan'] ?? '') === 'IV/e' ? 'selected' : '' }}>IV/e</option></select></div>
                                    <div class="col-md-6"><label class="form-label">Jabatan *</label><input type="text" class="form-control" name="riwayat_jabatan[{{ $index }}][jabatan]" value="{{ old('riwayat_jabatan.'.$index.'.jabatan', $jabatan['jabatan'] ?? '') }}"></div>
                                    <div class="col-md-6"><label class="form-label">Unit Kerja *</label><input type="text" class="form-control" name="riwayat_jabatan[{{ $index }}][unit_kerja]" value="{{ old('riwayat_jabatan.'.$index.'.unit_kerja', $jabatan['unit_kerja'] ?? '') }}"></div>
                                    <div class="col-md-6"><label class="form-label">TMT (Terhitung Mulai Tanggal) *</label><input type="date" class="form-control" name="riwayat_jabatan[{{ $index }}][tmt]" value="{{ old('riwayat_jabatan.'.$index.'.tmt', $jabatan['tmt'] ?? '') }}"></div>
                                    <div class="col-md-12"><label class="form-label">No. SK *</label><input type="text" class="form-control" name="riwayat_jabatan[{{ $index }}][no_sk]" value="{{ old('riwayat_jabatan.'.$index.'.no_sk', $jabatan['no_sk'] ?? '') }}"></div>
                                    <div class="col-12">
                                        @php $jabatanFile = $jabatan['file'] ?? null; @endphp
                                        @if($jabatanFile)
                                            <div class="mt-2 d-flex gap-2 flex-wrap">
                                                <a href="{{ asset('storage/'.$jabatanFile) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Dokumen</a>
                                            </div>
                                        @else
                                            <div class="upload-box">
                                                <input type="file" id="jabatan_file_{{ $index }}" name="riwayat_jabatan[{{ $index }}][file]" accept=".pdf" style="display:none;">
                                                <label for="jabatan_file_{{ $index }}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload"></i> Upload SK Jabatan (PDF, maks 1 MB)</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="form-step">
            <div class="card section-card">
                <div class="section-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0">F. Riwayat Penghargaan</h5>
                        <small class="opacity-75">Penghargaan, tanda jasa, dan piagam yang pernah diterima</small>
                    </div>
                    <button type="button" class="btn btn-light btn-sm text-primary fw-bold" onclick="addAward()">+ Tambah Penghargaan</button>
                </div>
                <div class="card-body p-4" id="awardContainer">
                    @if(count($awardRows) > 0)
                        @foreach($awardRows as $index => $award)
                            <div class="sub-card text-start">
                                <div class="sub-card-header d-flex justify-content-between align-items-center"><span>Penghargaan {{ $index + 1 }}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
                                <div class="row g-3">
                                    <div class="col-md-8"><label class="form-label">Nama Penghargaan *</label><input type="text" class="form-control" name="award[{{ $index }}][nama]" value="{{ old('award.'.$index.'.nama', $award['nama'] ?? '') }}"></div>
                                    <div class="col-md-4"><label class="form-label">Tahun *</label><input type="text" class="form-control" name="award[{{ $index }}][tahun]" placeholder="2020" value="{{ old('award.'.$index.'.tahun', $award['tahun'] ?? '') }}"></div>
                                    <div class="col-md-8"><label class="form-label">Instansi Pemberi *</label><input type="text" class="form-control" name="award[{{ $index }}][instansi]" placeholder="Nama instansi/lembaga pemberi" value="{{ old('award.'.$index.'.instansi', $award['instansi'] ?? '') }}"></div>
                                    <div class="col-md-4"><label class="form-label opacity-0 d-block">Upload</label>
                                        @php $awardFile = $award['file'] ?? null; @endphp
                                        @if($awardFile)
                                            <div class="mt-2 d-flex gap-2 flex-wrap">
                                                <a href="{{ asset('storage/'.$awardFile) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Dokumen</a>
                                            </div>
                                        @else
                                            <div class="upload-box">
                                                <input type="file" id="award_file_{{ $index }}" name="award[{{ $index }}][file]" accept=".pdf" style="display:none;">
                                                <label for="award_file_{{ $index }}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload me-2"></i> Upload Piagam / Sertifikat</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="form-step">
            <div class="card section-card">
                <div class="section-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0">G. Riwayat Sertifikasi</h5>
                        <small class="opacity-75">Sertifikasi profesi dan kompetensi yang telah diperoleh</small>
                    </div>
                    <button type="button" class="btn btn-light btn-sm text-primary fw-bold" onclick="addSertif()">+ Tambah Sertifikasi</button>
                </div>
                <div class="card-body p-4" id="sertifContainer">
                    @if(count($sertifRows) > 0)
                        @foreach($sertifRows as $index => $sertif)
                            <div class="sub-card text-start">
                                <div class="sub-card-header d-flex justify-content-between align-items-center"><span>Sertifikasi {{ $index + 1 }}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
                                <div class="row g-3">
                                    <div class="col-md-8"><label class="form-label">Nama Sertifikasi *</label><input type="text" class="form-control" name="sertif[{{ $index }}][nama]" placeholder="Nama sertifikasi / kompetensi" value="{{ old('sertif.'.$index.'.nama', $sertif['nama'] ?? '') }}"></div>
                                    <div class="col-md-4"><label class="form-label">Tahun *</label><input type="text" class="form-control" name="sertif[{{ $index }}][tahun]" placeholder="2020" value="{{ old('sertif.'.$index.'.tahun', $sertif['tahun'] ?? '') }}"></div>
                                    <div class="col-md-8"><label class="form-label">Lembaga Pelaksana *</label><input type="text" class="form-control" name="sertif[{{ $index }}][lembaga]" placeholder="Nama lembaga sertifikasi" value="{{ old('sertif.'.$index.'.lembaga', $sertif['lembaga'] ?? '') }}"></div>
                                    <div class="col-md-4"><label class="form-label opacity-0 d-block">Upload</label>
                                        @php $sertifFile = $sertif['file'] ?? null; @endphp
                                        @if($sertifFile)
                                            <div class="mt-2 d-flex gap-2 flex-wrap">
                                                <a href="{{ asset('storage/'.$sertifFile) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Dokumen</a>
                                            </div>
                                        @else
                                            <div class="upload-box">
                                                <input type="file" id="sertif_file_{{ $index }}" name="sertif[{{ $index }}][file]" accept=".pdf" style="display:none;">
                                                <label for="sertif_file_{{ $index }}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload me-2"></i> Upload Sertifikat</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="form-step">
            <div class="card section-card">
                <div class="section-header d-flex align-items-center gap-3">
                    <div class="icon-box"><i class="bi bi-card-text"></i></div>
                    <div><h5 class="fw-bold mb-0">H. Identitas Legal</h5><small class="opacity-75">Dokumen identitas resmi (tidak berhistori)</small></div>
                </div>
                <div class="card-body p-4 text-start">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="sub-card">
                                <div class="sub-card-header"><span><i class="bi bi-person-vcard me-2"></i>KTP — Kartu Tanda Penduduk</span></div>
                                <label class="form-label">NIK *</label><input type="text" class="form-control mb-3" name="nik_ktp" placeholder="16 digit NIK" value="{{ old('nik_ktp', $drhData?->nik_ktp ?? '') }}">
                                @if(!data_get($drhData, 'file_ktp'))
                                    <div class="upload-box">
                                        <input type="file" name="file_ktp" accept=".pdf" style="display: none;" id="file_ktp">
                                        <label for="file_ktp" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-upload me-2"></i>Upload KTP <small>(PDF, maks 1 MB)</small>
                                        </label>
                                    </div>
                                @else
                                    <div class="mt-2 d-flex gap-2 flex-wrap">
                                        <a href="{{ url('/profile/drh/file/ktp/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Dokumen</a>
                                    </div>
                                @endif
                                @if(data_get($drhData, 'file_ktp'))
                                    <div class="mt-2 d-flex gap-2 flex-wrap">
                                        <a href="{{ url('/profile/drh/file/ktp/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                        <a href="{{ url('/profile/drh/file/ktp/download') }}" class="btn btn-outline-secondary btn-sm">Unduh</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sub-card">
                                <div class="sub-card-header"><span><i class="bi bi-file-earmark-text me-2"></i>NPWP</span></div>
                                <label class="form-label">Nomor NPWP *</label><input type="text" class="form-control mb-3" name="nomor_npwp" placeholder="XX.XXX.XXX.X-XXX.XXX" value="{{ old('nomor_npwp', $drhData?->nomor_npwp ?? '') }}">
                                @if(!data_get($drhData, 'file_npwp'))
                                    <div class="upload-box">
                                        <input type="file" name="file_npwp" accept=".pdf" style="display: none;" id="file_npwp">
                                        <label for="file_npwp" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-upload me-2"></i>Upload NPWP <small>(PDF, maks 1 MB)</small>
                                        </label>
                                    </div>
                                @else
                                    <div class="mt-2 d-flex gap-2 flex-wrap">
                                        <a href="{{ url('/profile/drh/file/npwp/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Dokumen</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sub-card">
                                <div class="sub-card-header"><span><i class="bi bi-shield-check me-2"></i>BPJS Kesehatan / Ketenagakerjaan</span></div>
                                <label class="form-label">Nomor BPJS *</label><input type="text" class="form-control mb-3" name="nomor_bpjs" placeholder="Nomor BPJS" value="{{ old('nomor_bpjs', $drhData?->nomor_bpjs ?? '') }}">
                                @if(!data_get($drhData, 'file_bpjs'))
                                    <div class="upload-box">
                                        <input type="file" name="file_bpjs" accept=".pdf" style="display: none;" id="file_bpjs">
                                        <label for="file_bpjs" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-upload me-2"></i>Upload BPJS <small>(PDF, maks 1 MB)</small>
                                        </label>
                                    </div>
                                @else
                                    <div class="mt-2 d-flex gap-2 flex-wrap">
                                        <a href="{{ url('/profile/drh/file/bpjs/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Dokumen</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sub-card">
                                <div class="sub-card-header"><span><i class="bi bi-people me-2"></i>Kartu Keluarga (KK)</span></div>
                                <p class="text-muted" style="font-size: 11px;">Upload Kartu Keluarga terbaru (format PDF, maks 1 MB)</p>
                                <div class="upload-box">
                                    <input type="file" name="file_kk" accept=".pdf" style="display: none;" id="file_kk">
                                    <label for="file_kk" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-upload me-2"></i>Upload Kartu Keluarga
                                    </label>
                                </div>
                                @if(data_get($drhData, 'file_kk'))
                                    <div class="mt-2 d-flex gap-2 flex-wrap">
                                        <a href="{{ url('/profile/drh/file/kk/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                        <a href="{{ url('/profile/drh/file/kk/download') }}" class="btn btn-outline-secondary btn-sm">Unduh</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="sub-card">
                                <div class="sub-card-header"><span><i class="bi bi-file-earmark-text me-2"></i>Dokumen Pendukung</span></div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Akta Kelahiran *</label>
                                        <div class="upload-box">
                                            <input type="file" name="file_akta_kelahiran" accept=".pdf" style="display: none;" id="file_akta_kelahiran">
                                            <label for="file_akta_kelahiran" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload me-2"></i>Upload Akta Kelahiran</label>
                                        </div>
                                        @if(data_get($drhData, 'dokumen_pendukung.akta_kelahiran'))
                                            <div class="mt-2 d-flex gap-2 flex-wrap">
                                                <a href="{{ url('/profile/drh/file/akta_kelahiran/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                                <a href="{{ url('/profile/drh/file/akta_kelahiran/download') }}" class="btn btn-outline-secondary btn-sm">Unduh</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Dokumen Diklat *</label>
                                        <div class="upload-box">
                                            <input type="file" name="file_diklat" accept=".pdf" style="display: none;" id="file_diklat">
                                            <label for="file_diklat" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload me-2"></i>Upload Dokumen Diklat</label>
                                        </div>
                                        @if(data_get($drhData, 'dokumen_pendukung.diklat'))
                                            <div class="mt-2 d-flex gap-2 flex-wrap">
                                                <a href="{{ url('/profile/drh/file/diklat/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                                <a href="{{ url('/profile/drh/file/diklat/download') }}" class="btn btn-outline-secondary btn-sm">Unduh</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Ijazah / Transkrip *</label>
                                        <div class="upload-box">
                                            <input type="file" name="file_ijazah" accept=".pdf" style="display: none;" id="file_ijazah">
                                            <label for="file_ijazah" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload me-2"></i>Upload Ijazah</label>
                                        </div>
                                        @if(data_get($drhData, 'dokumen_pendukung.ijazah'))
                                            <div class="mt-2 d-flex gap-2 flex-wrap">
                                                <a href="{{ url('/profile/drh/file/ijazah/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                                <a href="{{ url('/profile/drh/file/ijazah/download') }}" class="btn btn-outline-secondary btn-sm">Unduh</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">SK Jabatan *</label>
                                        <div class="upload-box">
                                            <input type="file" name="file_sk" accept=".pdf" style="display: none;" id="file_sk">
                                            <label for="file_sk" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload me-2"></i>Upload SK Jabatan</label>
                                        </div>
                                        @if(data_get($drhData, 'dokumen_pendukung.sk'))
                                            <div class="mt-2 d-flex gap-2 flex-wrap">
                                                <a href="{{ url('/profile/drh/file/sk/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                                <a href="{{ url('/profile/drh/file/sk/download') }}" class="btn btn-outline-secondary btn-sm">Unduh</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Penghargaan / Piagam *</label>
                                        <div class="upload-box">
                                            <input type="file" name="file_penghargaan" accept=".pdf" style="display: none;" id="file_penghargaan">
                                            <label for="file_penghargaan" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload me-2"></i>Upload Penghargaan</label>
                                        </div>
                                        @if(data_get($drhData, 'dokumen_pendukung.penghargaan'))
                                            <div class="mt-2 d-flex gap-2 flex-wrap">
                                                <a href="{{ url('/profile/drh/file/penghargaan/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                                <a href="{{ url('/profile/drh/file/penghargaan/download') }}" class="btn btn-outline-secondary btn-sm">Unduh</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sertifikat *</label>
                                        <div class="upload-box">
                                            <input type="file" name="file_sertifikat" accept=".pdf" style="display: none;" id="file_sertifikat">
                                            <label for="file_sertifikat" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload me-2"></i>Upload Sertifikat</label>
                                        </div>
                                        @if(data_get($drhData, 'dokumen_pendukung.sertifikat'))
                                            <div class="mt-2 d-flex gap-2 flex-wrap">
                                                <a href="{{ url('/profile/drh/file/sertifikat/view') }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                                <a href="{{ url('/profile/drh/file/sertifikat/download') }}" class="btn btn-outline-secondary btn-sm">Unduh</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="btn-nav-group shadow-sm">
            <button type="button" class="btn btn-outline-secondary px-4" id="prevBtn" onclick="move(-1)" style="display:none;">Kembali</button>
            <button type="button" class="btn btn-primary px-4 ms-auto" id="nextBtn" onclick="moveOrSubmit()">Simpan Profil Dasar</button>
            <button type="submit" class="btn btn-success px-4 ms-auto" id="submitBtn" style="display:none;">Simpan Semua DRH</button>
        </div>
    </form>
</div>

<script>
    let cur = {{ session('step', old('step', 0)) }};
    let counts = { p: {{ count($pendidikanRows) - 1 }}, d: {{ count($diklatRows) - 1 }}, j: {{ count($jabatanRows) - 1 }}, a: {{ count($anakRows) - 1 }}, aw: {{ count($awardRows) - 1 }}, s: {{ count($sertifRows) - 1 }} };
    const steps = document.getElementsByClassName("form-step");
    const progs = document.getElementsByClassName("step-item");
    const profileComplete = {{ $drhData?->profil_dasar_lengkap ? 'true' : 'false' }};

    function canAccessStep(index) {
        if (index === 0) return true;
        return profileComplete;
    }

    function renderStep() {
        for (let i = 0; i < steps.length; i++) {
            steps[i].classList.toggle('active', i === cur);
            progs[i].classList.toggle('active', i === cur);
        }
        document.getElementById('prevBtn').style.display = (cur === 0) ? 'none' : 'block';
        if (cur === steps.length - 1) {
            document.getElementById('nextBtn').style.display = 'none';
            document.getElementById('submitBtn').style.display = 'block';
        } else {
            document.getElementById('nextBtn').style.display = 'block';
            document.getElementById('submitBtn').style.display = 'none';
        }
        updateButtonText();
        document.getElementById('stepInput').value = cur;
    }

    function handleRestrictedStep(index) {
        if (!canAccessStep(index)) {
            alert('Lengkapi Profil Dasar terlebih dahulu sebelum mengisi bagian lain.');
            return false;
        }
        return true;
    }

    function moveOrSubmit() {
        // Set step value
        document.getElementById('stepInput').value = cur;
        
        // If di step A (profil dasar), submit form
        if (cur === 0) {
            document.getElementById("drhForm").submit();
        } else {
            // Jika bukan step A, submit form untuk save current step
            document.getElementById("drhForm").submit();
        }
    }

    function move(n) {
        const nextIndex = cur + n;
        if (!handleRestrictedStep(nextIndex)) return;
        cur = nextIndex;
        renderStep();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function setStep(index) {
        if (index < 0 || index >= steps.length || index === cur) return;
        if (!handleRestrictedStep(index)) return;
        steps[cur].classList.remove("active");
        progs[cur].classList.remove("active");
        cur = index;
        steps[cur].classList.add("active");
        progs[cur].classList.add("active");
        document.getElementById("prevBtn").style.display = (cur === 0) ? "none" : "block";
        renderStep();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function updateButtonText() {
        const nextBtn = document.getElementById("nextBtn");
        if (cur === 0) {
            nextBtn.textContent = "Simpan Profil Dasar";
        } else {
            nextBtn.textContent = "Simpan dan Lanjutkan";
        }
    }

    function highlightSavedStep() {
        const stepItem = progs[cur];
        if (!stepItem) return;
        stepItem.style.transition = 'box-shadow 0.4s ease, transform 0.4s ease';
        stepItem.style.boxShadow = '0 0 0 4px rgba(40, 167, 69, 0.35)';
        stepItem.style.transform = 'scale(1.02)';
        setTimeout(() => {
            stepItem.style.boxShadow = '';
            stepItem.style.transform = '';
        }, 2000);
    }

    // On load, restore the current step and family section state
    renderStep();
    toggleFamilyLogic();
    @if(session('success'))
        highlightSavedStep();
    @endif

    function toggleFamilyLogic() {
        const st = document.getElementById("statusPegawai").value;
        if (st === "Menikah") {
            document.getElementById("sectionPasangan").style.display = "block";
            document.getElementById("sectionAnak").style.display = "block";
            document.getElementById("sectionMertua").style.display = "block";
        } else if (st === "Belum Menikah") {
            document.getElementById("sectionPasangan").style.display = "none";
            document.getElementById("sectionAnak").style.display = "none";
            document.getElementById("sectionMertua").style.display = "none";
        } else { // Cerai Hidup or Cerai Mati
            document.getElementById("sectionPasangan").style.display = "none";
            document.getElementById("sectionAnak").style.display = "block";
            document.getElementById("sectionMertua").style.display = "none";
        }
    }

    // --- DINAMIS PENDIDIKAN ---
    function addPendidikan() {
        counts.p++;
        const cont = document.getElementById("pendidikanContainer");
        const div = document.createElement("div");
        div.className = "sub-card text-start";
        div.id = "pendidikan_row_" + counts.p;
        div.innerHTML = `
            <div class="sub-card-header"><span>Pendidikan ${counts.p}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Jenjang Pendidikan *</label>
                    <select class="form-select" name="pendidikan[${counts.p}][jenjang]"><option>SD</option><option>SMP</option><option>SMA</option><option>D1</option><option>D2</option><option>D3</option><option>D4</option><option>S1</option><option>S2</option><option>S3</option></select>
                </div>
                <div class="col-md-6"><label class="form-label">Nama Sekolah / Universitas *</label><input type="text" class="form-control" name="pendidikan[${counts.p}][nama_sekolah]"></div>
                <div class="col-md-6"><label class="form-label">Tahun Masuk</label><input type="text" class="form-control" name="pendidikan[${counts.p}][tahun_masuk]" placeholder="2000"></div>
                <div class="col-md-6"><label class="form-label">Tahun Lulus</label><input type="text" class="form-control" name="pendidikan[${counts.p}][tahun_lulus]" placeholder="2004"></div>
                <div class="col-md-6"><label class="form-label">No. Ijazah</label><input type="text" class="form-control" name="pendidikan[${counts.p}][nomor_ijazah]" placeholder="Nomor Ijazah"></div>
                <div class="col-md-6"><label class="form-label">Nama Pejabat TTD Ijazah</label><input type="text" class="form-control" name="pendidikan[${counts.p}][nama_pejabat]" placeholder="Nama pejabat penandatangan"></div>
                <div class="col-12">
                    <div class="upload-box">
                        <input type="file" id="pendidikan_file_${counts.p}" name="pendidikan[${counts.p}][file]" accept=".pdf" style="display:none;">
                        <label for="pendidikan_file_${counts.p}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-upload"></i> Upload Ijazah (PDF, maks 1 MB)
                        </label>
                    </div>
                </div>
            </div>`;
        cont.appendChild(div);
        div.scrollIntoView({ behavior: 'smooth' });
    }

    // --- DINAMIS DIKLAT ---
    function addDiklat() {
        counts.d++;
        const cont = document.getElementById("diklatContainer");
        const div = document.createElement("div");
        div.className = "sub-card text-start";
        div.id = "diklat_row_" + counts.d;
        div.innerHTML = `
            <div class="sub-card-header"><span>Diklat ${counts.d}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nama Diklat *</label><input type="text" class="form-control" name="diklat[${counts.d}][nama]"></div>
                <div class="col-md-6"><label class="form-label">Penyelenggara *</label><input type="text" class="form-control" name="diklat[${counts.d}][penyelenggara]"></div>
                <div class="col-md-6"><label class="form-label">Nomor Sertifikat</label><input type="text" class="form-control" name="diklat[${counts.d}][nomor_sertifikat]"></div>
                <div class="col-md-6"><label class="form-label">Tahun</label><input type="text" class="form-control" name="diklat[${counts.d}][tahun]" placeholder="2020"></div>
                <div class="col-12">
                    <div class="upload-box">
                        <input type="file" id="diklat_file_${counts.d}" name="diklat[${counts.d}][file]" accept=".pdf" style="display:none;">
                        <label for="diklat_file_${counts.d}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-upload"></i> Upload Sertifikat Diklat (PDF, maks 1 MB)
                        </label>
                    </div>
                </div>
            </div>`;
        cont.appendChild(div);
        div.scrollIntoView({ behavior: 'smooth' });
    }

    // --- DINAMIS JABATAN ---
    function addJabatan() {
        counts.j++;
        const cont = document.getElementById("jabatanContainer");
        const div = document.createElement("div");
        div.className = "sub-card text-start";
        div.innerHTML = `
            <div class="sub-card-header"><span>Jabatan ${counts.j}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Golongan *</label>
                    <select class="form-select" name="riwayat_jabatan[${counts.j}][golongan]">
                        <option>I/a</option><option>I/b</option><option>I/c</option><option>I/d</option>
                        <option>II/a</option><option>II/b</option><option>II/c</option><option>II/d</option>
                        <option>III/a</option><option>III/b</option><option>III/c</option><option>III/d</option>
                        <option>IV/a</option><option>IV/b</option><option>IV/c</option><option>IV/d</option><option>IV/e</option>
                    </select>
                </div>
                <div class="col-md-6"><label class="form-label">Jabatan *</label><input type="text" class="form-control" name="riwayat_jabatan[${counts.j}][jabatan]"></div>
                <div class="col-md-6"><label class="form-label">Unit Kerja *</label><input type="text" class="form-control" name="riwayat_jabatan[${counts.j}][unit_kerja]"></div>
                <div class="col-md-6"><label class="form-label">TMT (Terhitung Mulai Tanggal) *</label><input type="date" class="form-control" name="riwayat_jabatan[${counts.j}][tmt]"></div>
                <div class="col-md-12"><label class="form-label">No. SK *</label><input type="text" class="form-control" name="riwayat_jabatan[${counts.j}][no_sk]"></div>
                <div class="col-12">
                    <div class="upload-box">
                        <input type="file" id="jabatan_file_${counts.j}" name="riwayat_jabatan[${counts.j}][file]" accept=".pdf" style="display:none;">
                        <label for="jabatan_file_${counts.j}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-upload"></i> Upload SK Jabatan (PDF, maks 1 MB)
                        </label>
                    </div>
                </div>
            </div>`;
        cont.appendChild(div);
    }

    // --- DINAMIS PENGHARGAAN ---
    function addAward() {
        counts.aw++;
        const cont = document.getElementById("awardContainer");
        const div = document.createElement("div");
        div.className = "sub-card text-start";
        div.innerHTML = `
            <div class="sub-card-header"><span>Penghargaan ${counts.aw}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
            <div class="row g-3">
                <div class="col-md-8"><label class="form-label">Nama Penghargaan *</label><input type="text" class="form-control" name="award[${counts.aw}][nama]"></div>
                <div class="col-md-4"><label class="form-label">Tahun *</label><input type="text" class="form-control" name="award[${counts.aw}][tahun]" placeholder="2020"></div>
                <div class="col-md-8"><label class="form-label">Instansi Pemberi *</label><input type="text" class="form-control" name="award[${counts.aw}][instansi]" placeholder="Nama instansi/lembaga pemberi"></div>
                <div class="col-md-4"><label class="form-label opacity-0 d-block">Upload</label>
                    <div class="upload-box">
                        <input type="file" id="award_file_${counts.aw}" name="award[${counts.aw}][file]" accept=".pdf" style="display:none;">
                        <label for="award_file_${counts.aw}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-upload me-2"></i> Upload Piagam / Sertifikat
                        </label>
                    </div>
                </div>
            </div>`;
        cont.appendChild(div);
    }

    // --- DINAMIS SERTIFIKASI ---
    function addSertif() {
        counts.s++;
        const cont = document.getElementById("sertifContainer");
        const div = document.createElement("div");
        div.className = "sub-card text-start";
        div.innerHTML = `
            <div class="sub-card-header"><span>Sertifikasi ${counts.s}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
            <div class="row g-3">
                <div class="col-md-8"><label class="form-label">Nama Sertifikasi *</label><input type="text" class="form-control" name="sertif[${counts.s}][nama]" placeholder="Nama sertifikasi / kompetensi"></div>
                <div class="col-md-4"><label class="form-label">Tahun *</label><input type="text" class="form-control" name="sertif[${counts.s}][tahun]" placeholder="2020"></div>
                <div class="col-md-8"><label class="form-label">Lembaga Pelaksana *</label><input type="text" class="form-control" name="sertif[${counts.s}][lembaga]" placeholder="Nama lembaga sertifikasi"></div>
                <div class="col-md-4"><label class="form-label opacity-0 d-block">Upload</label>
                    <div class="upload-box">
                        <input type="file" id="sertif_file_${counts.s}" name="sertif[${counts.s}][file]" accept=".pdf" style="display:none;">
                        <label for="sertif_file_${counts.s}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-upload me-2"></i> Upload Sertifikat
                        </label>
                    </div>
                </div>
            </div>`;
        cont.appendChild(div);
    }

    function addAnak() {
        counts.a++;
        const cont = document.getElementById("anakContainer");
        const empty = document.getElementById("emptyAnak");
        if (empty) empty.style.display = "none";
        const div = document.createElement("div");
        div.className = "sub-card";
        div.innerHTML = `
            <div class="sub-card-header"><span class="text-primary">Anak ke-${counts.a}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nama Anak *</label><input type="text" class="form-control" name="anak[${counts.a}][nama]"></div>
                <div class="col-md-6"><label class="form-label">NIK</label><input type="text" class="form-control" name="anak[${counts.a}][nik]"></div>
                <div class="col-md-6"><label class="form-label">Tempat Lahir</label><input type="text" class="form-control" name="anak[${counts.a}][tempat_lahir]"></div>
                <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control" name="anak[${counts.a}][tanggal_lahir]"></div>
                <div class="col-md-6"><label class="form-label">Status Anak</label><select class="form-select" name="anak[${counts.a}][status_anak]"><option>Kandung</option><option>Tiri</option><option>Angkat</option></select></div>
                <div class="col-md-6">
                    <label class="form-label">Akta Kelahiran</label>
                    <div class="upload-box">
                        <input type="file" id="anak_file_${counts.a}" name="anak[${counts.a}][file]" accept=".pdf" style="display:none;">
                        <label for="anak_file_${counts.a}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload me-2"></i> Upload Akta Kelahiran</label>
                    </div>
                </div>
            </div>`;
        cont.appendChild(div);
    }

    window.onload = () => {
        if (!profileComplete) {
            for (let i = 1; i < progs.length; i++) {
                progs[i].disabled = true;
                progs[i].classList.add('disabled');
            }
        }
        toggleFamilyLogic();
    };

    // Handle file upload preview for both static and dynamic file inputs
    document.addEventListener('change', function(e) {
        const input = e.target;
        if (!input.matches('input[type="file"]')) {
            return;
        }

        const file = input.files[0];
        if (!file) {
            return;
        }

        const maxSize = 1024 * 1024;
        if (file.size > maxSize) {
            alert('File ' + file.name + ' terlalu besar. Maksimal 1 MB.');
            input.value = '';
            return;
        }

        if (file.type !== 'application/pdf') {
            alert('File ' + file.name + ' harus berformat PDF.');
            input.value = '';
            return;
        }

        const label = document.querySelector('label[for="' + input.id + '"]');
        if (label) {
            label.innerHTML = '<i class="bi bi-check-circle-fill me-2 text-success"></i>' + file.name + ' <small>(PDF, ' + (file.size / 1024 / 1024).toFixed(2) + ' MB)</small>';
        }
    });
</script>
</body>
</html>