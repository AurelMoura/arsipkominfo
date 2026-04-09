<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Profil - Arsip Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { 
            --sidebar-color: #0b132b; 
            --primary-blue: #3a86ff; 
            --primary-green: #06d6a0; 
            --bg-light: #f4f7fe;
        }

        body { 
            background-color: var(--bg-light); 
            font-family: 'Inter', sans-serif; 
            margin: 0; 
            color: #2d3748;
        }
        
        /* Sidebar Modern */
        .sidebar { 
            width: 260px; 
            height: 100vh; 
            background: var(--sidebar-color); 
            position: fixed; 
            color: white; 
            z-index: 1000; 
            box-shadow: 10px 0 30px rgba(0,0,0,0.05);
        }
        .nav-link { 
            color: #8d94a3; 
            margin: 5px 15px; 
            border-radius: 12px; 
            padding: 12px; 
            text-decoration: none; 
            display: block; 
            transition: 0.3s;
            font-weight: 500;
        }
        .nav-link.active { 
            background: linear-gradient(135deg, var(--primary-blue), #2563eb); 
            color: white !important; 
            box-shadow: 0 4px 15px rgba(58, 134, 255, 0.3);
        }
        .nav-link:hover:not(.active) { 
            background: rgba(255,255,255,0.1); 
            color: white; 
        }
        
        /* Main Content */
        .main-content { margin-left: 260px; padding: 40px; }
        .page-header-label { 
            color: var(--primary-blue); 
            font-weight: 800; 
            font-size: 11px; 
            letter-spacing: 1.5px; 
            text-transform: uppercase; 
            border-left: 4px solid var(--primary-blue); 
            padding-left: 12px; 
            margin-bottom: 12px; 
            display: block;
        }
        
        /* Custom Cards Luxe */
        .card-custom { 
            border: none; 
            border-radius: 24px; 
            background: white; 
            overflow: hidden; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: transform 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }

        .form-control { 
            background-color: #f8fafc; 
            border: 2px solid #edf2f7; 
            padding: 12px 18px; 
            border-radius: 14px; 
            font-size: 14px;
            color: #4a5568;
            transition: all 0.3s;
        }
        .form-control:focus { 
            background-color: white; 
            box-shadow: 0 0 0 4px rgba(58, 134, 255, 0.1); 
            border-color: var(--primary-blue); 
        }
        
        .btn-primary { 
            background: linear-gradient(135deg, var(--primary-blue), #2563eb); 
            border: none; 
            border-radius: 14px; 
            padding: 12px 25px; 
            font-weight: 700; 
            box-shadow: 0 4px 15px rgba(58, 134, 255, 0.3);
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(58, 134, 255, 0.4);
            filter: brightness(1.1);
        }

        /* Modal Styles Luxe */
        .modal-content { border-radius: 30px; border: none; padding: 10px; }
        .modal-header { border-radius: 20px 20px 0 0; }

        @media (max-width: 991px) {
            .sidebar { width: 80px; }
            .sidebar .lh-1, .sidebar .text-white, .sidebar small, .sidebar span { display: none; }
            .main-content { margin-left: 80px; padding: 25px; }
        }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column p-3 shadow">
    <div class="d-flex align-items-center mb-5 px-2 mt-2">
        <div class="d-flex align-items-center gap-2">
            <img src="{{ asset('image/pemkot.png') }}" width="35" class="rounded-circle shadow-sm">
            <img src="{{ asset('image/LOGOKOMINFO.png') }}" width="35" class="rounded-circle shadow-sm">
        </div>
        <div class="lh-1 text-white ms-3 d-none d-lg-block">
            <div class="fw-bold" style="font-size: 15px; letter-spacing: 1px;">KOMINFO</div>
            <small class="opacity-50" style="font-size: 10px;">Arsip Digital</small>
        </div>
    </div>

    <div class="bg-white bg-opacity-10 rounded-4 p-3 d-flex align-items-center mb-4 mx-1 border border-white border-opacity-10 shadow-sm" style="cursor: pointer;">
        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2 text-white fw-bold shadow-sm" style="width: 40px; height: 40px; font-size: 16px;">
            {{ strtoupper(substr(Session::get('name'), 0, 1)) }}
        </div>
        <div class="text-white overflow-hidden d-none d-lg-block" style="font-size: 12px;">
            <div class="fw-bold text-truncate">{{ Session::get('name') }}</div>
            <small class="opacity-50 text-truncate d-block">NIP: {{ Session::get('identifier') }}</small>
            <small class="text-white-50 text-truncate d-block mt-1">Kelola Profil</small>
        </div>
    </div>

    <ul class="nav nav-pills flex-column mb-auto">
        <li><a href="{{ url('/dashboard') }}" class="nav-link mb-2"><i class="bi bi-grid-fill me-2"></i> <span>Dashboard</span></a></li>
        <li><a href="{{ url('/pegawai/arsip') }}" class="nav-link mb-2"><i class="bi bi-folder2-open me-2"></i> <span>Arsip Dokumen</span></a></li>
        <li><a href="{{ url('/pengajuan-berkas') }}" class="nav-link"><i class="bi bi-send-fill me-2"></i> <span>Pengajuan Berkas</span></a></li>
    </ul>
    
    <div class="mt-auto pt-3 border-top border-secondary border-opacity-20">
        <a href="{{ url('/logout') }}" class="nav-link text-danger fw-bold">
            <i class="bi bi-box-arrow-left me-2"></i> <span>Logout</span>
        </a>
    </div>
</div>

<div class="main-content">
    <div class="mb-5">
        <div class="page-header-label">Account Settings</div>
        <h1 class="fw-bold text-dark" style="letter-spacing: -1px;">Kelola Profil</h1>
        <p class="text-muted small">Perbarui kredensial akun dan lengkapi Daftar Riwayat Hidup (DRH) Anda</p>
    </div>

    <div class="card card-custom shadow-sm mb-5">
        <div class="bg-primary text-white p-4 d-flex align-items-center" style="background: linear-gradient(135deg, var(--primary-blue), #2563eb) !important;">
            <div class="bg-white bg-opacity-20 rounded-3 p-3 me-3 shadow-sm"><i class="bi bi-person-badge fs-4"></i></div>
            <div>
                <h6 class="fw-bold mb-1" style="font-size: 17px;">Informasi Kontak & Kepegawaian</h6>
                <p class="opacity-75 mb-0 small">Perbarui informasi kontak dan data kepegawaian Anda</p>
            </div>
        </div>
        
        @if ($errors->any())
            <div class="alert alert-danger m-4 mb-0 alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if (session('success'))
            <div class="alert alert-success m-4 mb-0 alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger m-4 mb-0 alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="card-body p-5">
            <form action="{{ url('/profile/update-profil') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">NIP</label>
                        <input type="text" class="form-control shadow-sm" value="{{ Session::get('identifier') }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">Nama Lengkap *</label>
                        <input type="text" class="form-control shadow-sm" name="nama_lengkap" value="{{ $pegawaiData?->nama_lengkap ?? Session::get('name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">Jenis Kelamin *</label>
                        <select class="form-select shadow-sm" name="jenis_kelamin" required>
                            <option value="">Pilih</option>
                            <option value="L" {{ ($pegawaiData?->jenis_kelamin ?? '') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ ($pegawaiData?->jenis_kelamin ?? '') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">Tempat Lahir *</label>
                        <input type="text" class="form-control shadow-sm" name="tempat_lahir" value="{{ $pegawaiData?->tempat_lahir ?? '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">Tanggal Lahir *</label>
                        <input type="date" class="form-control shadow-sm" name="tanggal_lahir" value="{{ $pegawaiData?->tanggal_lahir?->format('Y-m-d') ?? '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">Golongan Darah *</label>
                        <select class="form-select shadow-sm" name="gol_darah" required>
                            <option value="">Pilih</option>
                            <option value="A" {{ ($pegawaiData?->gol_darah ?? '') === 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ ($pegawaiData?->gol_darah ?? '') === 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ ($pegawaiData?->gol_darah ?? '') === 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ ($pegawaiData?->gol_darah ?? '') === 'O' ? 'selected' : '' }}>O</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">Status Kawin *</label>
                        <select class="form-select shadow-sm" name="status_kawin" required>
                            <option value="">Pilih</option>
                            <option value="BM" {{ ($pegawaiData?->status_kawin ?? '') === 'BM' ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="M" {{ ($pegawaiData?->status_kawin ?? '') === 'M' ? 'selected' : '' }}>Menikah</option>
                            <option value="CH" {{ ($pegawaiData?->status_kawin ?? '') === 'CH' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="CM" {{ ($pegawaiData?->status_kawin ?? '') === 'CM' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">Status Pegawai *</label>
                        <select class="form-select shadow-sm" name="status_pegawai" required>
                            <option value="">Pilih</option>
                            <option value="PNS" {{ ($pegawaiData?->status_pegawai ?? '') === 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="PPPK" {{ ($pegawaiData?->status_pegawai ?? '') === 'PPPK' ? 'selected' : '' }}>PPPK</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">NIK *</label>
                        <input type="text" class="form-control shadow-sm" name="no_nik" value="{{ $pegawaiData?->no_nik ?? '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">Email *</label>
                        <input type="email" class="form-control shadow-sm" name="email" value="{{ $pegawaiData?->email ?? '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">No. HP *</label>
                        <input type="text" class="form-control shadow-sm" name="no_hp" value="{{ $pegawaiData?->no_hp ?? '' }}" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-5 px-4 py-3"><i class="bi bi-check-circle me-2"></i> Simpan Perubahan Profil</button>
            </form>
        </div>
    </div>

    <div class="card card-custom card-hover shadow-sm mb-5 p-5 text-center border-0">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px;">
            <i class="bi bi-file-earmark-person fs-2"></i>
        </div>
        <h5 class="fw-bold mb-2" style="font-size: 22px;">Daftar Riwayat Hidup (DRH)</h5>
        <p class="text-muted small mb-4 mx-auto" style="max-width: 500px;">Lengkapi dan kelola data kurikulum vitae, pendidikan, dan pengalaman kerja Anda secara profesional dalam satu sistem terpusat.</p>
        <div class="col-md-4 mx-auto">
            <a href="{{ url('/profile/drh') }}" class="btn btn-primary w-100 py-3 shadow-lg">
                <i class="bi bi-file-earmark-text me-2"></i> Buka Portal DRH
            </a>
        </div>
    </div>

    <div class="card card-custom shadow-sm p-5 border-0">
        <div class="d-flex align-items-center mb-4">
            <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-2 me-3"><i class="bi bi-shield-lock fs-4"></i></div>
            <div>
                <h6 class="fw-bold mb-1" style="font-size: 18px;">Ubah Keamanan Akun</h6>
                <p class="text-muted small mb-0">Perbarui username dan password secara berkala</p>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success d-flex align-items-center border-0 py-3 mb-4 shadow-sm" style="background-color: #f0fff4; border-radius: 16px;">
            <i class="bi bi-check-circle-fill text-success me-3 fs-5"></i>
            <span class="small text-success fw-bold">{{ session('success') }}</span>
        </div>
        @endif

        <div class="col-md-4">
            <button class="btn btn-primary w-100 py-3 shadow-lg" data-bs-toggle="modal" data-bs-target="#modalUpdateKredensial" style="background: linear-gradient(135deg, #4a5568, #2d3748) !important;">
                <i class="bi bi-person-gear me-2"></i> Pengaturan Akun & Sandi
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdateKredensial" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white border-0 p-5 rounded-4 shadow-sm" style="background: linear-gradient(135deg, var(--primary-blue), #2563eb) !important;">
                <div class="text-center w-100">
                    <div class="bg-white bg-opacity-20 rounded-circle p-3 d-inline-block mb-3"><i class="bi bi-shield-lock fs-1"></i></div>
                    <h5 class="modal-title fw-bold d-block">Ubah Kredensial Akun</h5>
                    <p class="mb-0 opacity-75 small">Pastikan password baru Anda aman dan unik</p>
                </div>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-4" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/pegawai/update-password') }}" method="POST">
                @csrf
                <div class="modal-body p-5">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Username Baru</label>
                        <input type="text" name="username_baru" class="form-control py-3 rounded-4 shadow-sm" value="{{ Session::get('name') }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Password Baru</label>
                        <input type="password" name="password_baru" class="form-control py-3 rounded-4 shadow-sm" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_password" class="form-control py-3 rounded-4 shadow-sm" placeholder="Ulangi password baru" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-5 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 fw-bold shadow-lg">Simpan Kredensial Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>