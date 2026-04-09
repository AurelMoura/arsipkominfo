<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai - Arsip Digital</title>
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
            transition: all 0.3s;
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
        .main-content { margin-left: 260px; padding: 40px; transition: all 0.3s; }
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
        
        /* Stat Cards Luxe */
        .stat-card { 
            border: none; 
            border-radius: 24px; 
            padding: 25px; 
            background: white; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.02); 
            transition: all 0.3s ease;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }
        
        /* Feature Cards Premium */
        .feature-card { 
            border: none; 
            border-radius: 28px; 
            padding: 40px; 
            background: white; 
            height: 100%; 
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
            overflow: hidden;
        }
        .feature-card:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.06) !important; 
        }
        .icon-circle { 
            width: 65px; 
            height: 65px; 
            border-radius: 20px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 30px; 
            margin-bottom: 25px; 
            box-shadow: 0 10px 20px rgba(58, 134, 255, 0.2);
        }
        
        .btn-action { 
            border-radius: 14px; 
            padding: 14px 24px; 
            font-weight: 700; 
            border: none; 
            width: 100%; 
            transition: 0.3s; 
            text-align: center;
        }
        .btn-action:hover {
            filter: brightness(1.1);
            transform: scale(1.02);
        }

        .info-box { 
            background: linear-gradient(to right, #eff6ff, #dbeafe); 
            border-radius: 20px; 
            padding: 25px; 
            border-left: 6px solid var(--primary-blue); 
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }

        /* Custom Modal Modern */
        .modal-content { border-radius: 30px; border: none; overflow: hidden; }
        .modal-header-custom { 
            background: linear-gradient(135deg, var(--primary-blue), #2563eb); 
            color: white; 
            padding: 30px; 
        }

        @media (max-width: 991px) {
            .sidebar { width: 80px; }
            .sidebar .ms-3, .sidebar .text-truncate, .sidebar span, .sidebar small, .sidebar .ms-auto { display: none; }
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
        <div class="lh-1 text-white ms-3">
            <div class="fw-bold" style="font-size: 15px; letter-spacing: 1px;">KOMINFO</div>
            <small class="opacity-50" style="font-size: 10px;">Arsip Digital</small>
        </div>
    </div>

    <a href="{{ url('/profile') }}" class="bg-white bg-opacity-10 rounded-4 p-3 d-flex align-items-center mb-4 mx-1 border border-white border-opacity-10 text-decoration-none shadow-sm transition-all" style="cursor: pointer;">
        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2 text-white fw-bold shadow-sm" style="width: 42px; height: 42px; font-size: 16px;">
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
        <li><a href="{{ url('/dashboard') }}" class="nav-link active mb-2"><i class="bi bi-grid-fill me-2"></i> Dashboard</a></li>
        <li><a href="{{ url('/pegawai/arsip') }}" class="nav-link mb-2"><i class="bi bi-folder2-open me-2"></i> Arsip Dokumen</a></li>
        <li><a href="{{ url('/pengajuan-berkas') }}" class="nav-link mb-2"><i class="bi bi-send-fill me-2"></i> Pengajuan Berkas</a></li>
    </ul>
    
    <div class="mt-auto pt-3 border-top border-secondary border-opacity-20">
        <a href="{{ url('/logout') }}" class="nav-link text-danger fw-bold">
            <i class="bi bi-box-arrow-left me-2"></i> Logout
        </a>
    </div>
</div>

<div class="main-content text-start">
    <div class="mb-5">
        <span class="page-header-label">Dashboard Arsip Dokumen Kominfo</span>
        <h1 class="fw-bold mt-2" style="font-size: 36px; letter-spacing: -1px;">Selamat Datang, <span class="text-primary">{{ Session::get('name') }}</span></h1>
        <p class="text-muted" style="font-size: 15px;">Pegawai Kominfo • Bagian Umum & Kepegawaian</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-5 rounded-4 p-3 text-start" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-3 fs-4"></i> 
                <span class="fw-bold">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-4 shadow-sm"><i class="bi bi-folder-check fs-2"></i></div>
                <div>
                    <h3 class="fw-bold mb-0" style="font-size: 28px;">{{ \App\Models\Document::where('user_id', Session::get('user_id'))->count() }}</h3>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Dokumen Tersimpan</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center">
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-4 me-4 shadow-sm"><i class="bi bi-cloud-arrow-up-fill fs-2"></i></div>
                <div>
                    <h3 class="fw-bold mb-0" style="font-size: 28px;">{{ \App\Models\Document::where('user_id', Session::get('user_id'))->whereMonth('uploaded_at', now()->month)->whereYear('uploaded_at', now()->year)->count() }}</h3>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Upload Bulan Ini</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center">
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-4 me-4 shadow-sm"><i class="bi bi-hourglass-split fs-2"></i></div>
                <div>
                    <h3 class="fw-bold mb-0" style="font-size: 28px;">0</h3>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Pengajuan Aktif</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="feature-card shadow-sm border-top border-4 border-primary">
                <div class="icon-circle bg-primary text-white shadow-sm"><i class="bi bi-file-earmark-medical"></i></div>
                <h4 class="fw-bold" style="font-size: 22px;">Arsip Dokumen Saya</h4>
                <p class="text-muted small mb-4" style="line-height: 1.6;">Kelola dokumen kepegawaian pribadi Anda mulai dari SK, Ijazah, hingga Sertifikat Pelatihan secara digital.</p>
                <a href="{{ url('/pegawai/arsip') }}" class="btn-action bg-primary text-white shadow-sm text-decoration-none d-inline-block">
                    <i class="bi bi-folder2-open me-2"></i> Buka Arsip Dokumen
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="feature-card shadow-sm border-top border-4 border-success">
                <div class="icon-circle bg-success text-white shadow-sm"><i class="bi bi-send-check"></i></div>
                <h4 class="fw-bold" style="font-size: 22px;">Pengajuan Berkas</h4>
                <p class="text-muted small mb-4" style="line-height: 1.6;">Ajukan permohonan mutasi, kenaikan pangkat, atau cuti secara digital dengan proses pemantauan real-time.</p>
                <a href="{{ url('/pengajuan-berkas') }}" class="btn-action bg-success text-white shadow-sm text-decoration-none d-inline-block">
                    <i class="bi bi-box-arrow-up-right me-2"></i> Akses Portal Pengajuan
                </a>
            </div>
        </div>
    </div>

    <div class="info-box shadow-sm mb-5">
        <div class="d-flex align-items-start">
            <i class="bi bi-info-circle-fill fs-3 text-primary me-4 mt-1"></i>
            <div>
                <h6 class="fw-bold mb-1" style="font-size: 16px;">Perbedaan Arsip & Pengajuan</h6>
                <p class="text-muted small mb-0" style="font-size: 14px; line-height: 1.6;">Arsip digunakan untuk menyimpan dan melihat dokumen pribadi yang sudah valid, sedangkan Pengajuan digunakan untuk proses verifikasi dokumen baru oleh administrator.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdateKredensial" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header-custom text-center">
                <div class="bg-white bg-opacity-20 rounded-circle p-3 d-inline-block mb-3">
                    <i class="bi bi-shield-lock-fill fs-1 text-white"></i>
                </div>
                <h4 class="fw-bold mb-1 text-white">Keamanan Akun</h4>
                <p class="opacity-75 text-white mb-0 small">Demi keamanan, silakan perbarui password default Anda</p>
            </div>
            
            <form action="{{ url('/pegawai/update-password') }}" method="POST">
                @csrf
                <div class="modal-body p-5 text-start">
                    <div class="bg-light rounded-4 p-4 mb-4 border border-dashed border-primary border-opacity-20">
                        <div class="small text-muted mb-1">Akun Terdaftar:</div>
                        <div class="text-dark fw-bold" style="font-size: 16px;">{{ Session::get('name') }}</div>
                        <div class="text-primary small fw-bold">NIP: {{ Session::get('identifier') }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-secondary" style="letter-spacing: 1px;">Password Baru *</label>
                        <input type="password" name="password_baru" class="form-control bg-light border-0 py-3 rounded-3" placeholder="Minimal 6 karakter" required>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-uppercase text-secondary" style="letter-spacing: 1px;">Konfirmasi Password *</label>
                        <input type="password" name="konfirmasi_password" class="form-control bg-light border-0 py-3 rounded-3" placeholder="Ulangi password baru" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-5 pt-0">
                    <button type="button" class="btn btn-light px-4 py-3 rounded-3 fw-bold flex-fill me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-3 fw-bold shadow rounded-3 flex-fill">
                        <i class="bi bi-check2-circle me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var isFirstLogin = "{{ Session::get('is_first_login') }}";
        console.log("Status Login Pertama: " + isFirstLogin);

        if (isFirstLogin === "1" || isFirstLogin === "true") {
            var modalElement = document.getElementById('modalUpdateKredensial');
            var myModal = new bootstrap.Modal(modalElement);
            setTimeout(function() {
                myModal.show();
            }, 500); // Sedikit delay agar transisi lebih smooth
        }
    });
</script>

</body>
</html>