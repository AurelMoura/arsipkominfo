<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Berkas - Arsip Digital</title>
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
        
        /* Sidebar */
        .sidebar { 
            width: 260px; 
            height: 100vh; 
            background: var(--sidebar-color); 
            position: fixed; 
            color: white; 
            z-index: 1000; 
            transition: all 0.3s;
        }
        .nav-link { 
            color: #8d94a3; 
            margin: 5px 15px; 
            border-radius: 12px; 
            padding: 12px; 
            text-decoration: none; 
            display: block; 
            transition: 0.3s;
        }
        .nav-link.active { 
            background: var(--primary-blue); 
            color: white !important; 
            box-shadow: 0 4px 15px rgba(58, 134, 255, 0.3);
        }
        .nav-link:hover:not(.active) { 
            background: rgba(255,255,255,0.1); 
            color: white; 
        }
        
        /* Main Content */
        .main-content { 
            margin-left: 260px; 
            padding: 40px; 
            transition: all 0.3s;
        }
        .page-header-label { 
            color: var(--primary-blue); 
            font-weight: 800; 
            font-size: 11px; 
            letter-spacing: 1.5px; 
            text-transform: uppercase; 
            margin-bottom: 8px; 
            display: block;
        }
        
        /* Content Card */
        .content-card { 
            background: white; 
            border-radius: 24px; 
            padding: 40px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.02); 
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        
        .section-title { font-size: 32px; font-weight: 800; color: #1a202c; letter-spacing: -0.5px; }
        .section-subtitle { font-size: 15px; color: #718096; margin-bottom: 30px; }
        
        /* Info Box */
        .info-box { 
            background: #f0fff4; 
            border-left: 6px solid var(--primary-green); 
            padding: 24px; 
            border-radius: 16px; 
            margin-bottom: 35px;
        }
        .info-box-title { font-weight: 700; color: #22543d; font-size: 16px; margin-bottom: 5px; }
        
        /* Link Input Group */
        .link-input-group { margin-bottom: 30px; }
        .link-label { display: block; font-weight: 700; color: #4a5568; margin-bottom: 10px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .link-input { 
            padding: 14px 20px; 
            border: 2px solid #edf2f7; 
            border-radius: 14px; 
            font-size: 15px; 
            background: #f8fafc; 
            color: #4a5568;
            font-weight: 500;
            width: 100%;
        }
        
        /* Action Button */
        .btn-link-external { 
            background: var(--primary-green); 
            color: white; 
            border: none; 
            padding: 18px 30px; 
            border-radius: 16px; 
            font-weight: 700; 
            width: 100%; 
            font-size: 16px; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 12px;
            box-shadow: 0 6px 20px rgba(6, 214, 160, 0.25);
        }
        .btn-link-external:hover { 
            background: #05b98a; 
            transform: translateY(-3px); 
            box-shadow: 0 10px 25px rgba(6, 214, 160, 0.35);
            color: white;
        }
        
        /* Instruction Section */
        .instruction-section { 
            margin-top: 50px; 
            padding-top: 30px; 
            border-top: 2px dashed #edf2f7; 
        }
        .instruction-title { font-size: 20px; font-weight: 800; color: #1a202c; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
        .instruction-item { display: flex; gap: 20px; margin-bottom: 24px; align-items: flex-start; }
        .instruction-number { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            width: 36px; 
            height: 36px; 
            background: linear-gradient(135deg, #3a86ff, #2563eb); 
            color: white; 
            border-radius: 12px; 
            font-weight: 700; 
            flex-shrink: 0; 
            box-shadow: 0 4px 10px rgba(58, 134, 255, 0.3);
        }
        .instruction-text { font-size: 15px; color: #4a5568; line-height: 1.6; }
        
        /* Important Note */
        .important-note { 
            background: linear-gradient(to right, #eff6ff, #dbeafe); 
            border: 1px solid #bfdbfe; 
            border-radius: 18px; 
            padding: 25px; 
            margin-top: 40px; 
        }
        .important-note-title { font-weight: 800; color: #1e40af; margin-bottom: 8px; font-size: 15px; }
        .important-note-text { font-size: 14px; color: #1e3a8a; opacity: 0.9; }

        /* Responsive Mobile */
        @media (max-width: 991px) {
            .sidebar { width: 80px; }
            .sidebar .text-white, .sidebar small, .sidebar .ms-auto, .sidebar .nav-link span { display: none; }
            .sidebar .nav-link { text-align: center; margin: 5px 10px; }
            .sidebar .nav-link i { margin: 0 !important; font-size: 20px; }
            .main-content { margin-left: 80px; padding: 20px; }
            .content-card { padding: 25px; }
        }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column p-3 shadow">
    <div class="d-flex align-items-center mb-5 px-2">
        <div class="d-flex align-items-center gap-2">
            <img src="{{ asset('image/pemkot.png') }}" width="40" class="rounded-circle shadow-sm">
            <img src="{{ asset('image/LOGOKOMINFO.png') }}" width="40" class="rounded-circle shadow-sm">
        </div>
        <div class="lh-1 text-white ms-3 d-none d-lg-block">
            <div class="fw-bold" style="font-size: 14px; letter-spacing: 1px;">KOMINFO</div>
            <small class="opacity-50" style="font-size: 10px;">Arsip Digital</small>
        </div>
    </div>
    
    <a href="{{ url('/profile') }}" class="bg-white bg-opacity-10 rounded-4 p-3 d-flex align-items-center mb-4 mx-1 border border-white border-opacity-10 text-decoration-none shadow-sm">
        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2 text-white fw-bold shadow-sm" style="width: 40px; height: 40px;">
            {{ strtoupper(substr(Session::get('name'), 0, 1)) }}
        </div>
        <div class="text-white overflow-hidden d-none d-lg-block" style="font-size: 12px;">
            <div class="fw-bold text-truncate">{{ Session::get('name') }}</div>
            <small class="opacity-50 text-truncate d-block">NIP: {{ Session::get('identifier') }}</small>
        </div>
        <i class="bi bi-person-circle ms-auto opacity-75 text-white d-none d-lg-block"></i>
    </a>
    
    <nav class="flex-grow-1">
        <a href="/dashboard" class="nav-link mb-2"><i class="bi bi-grid-fill me-2"></i> <span>Dashboard</span></a>
        <a href="/pegawai/arsip" class="nav-link mb-2"><i class="bi bi-folder2-open me-2"></i> <span>Arsip Dokumen</span></a>
        <a href="/pengajuan-berkas" class="nav-link active"><i class="bi bi-send-fill me-2"></i> <span>Pengajuan Berkas</span></a>
    </nav>
    
    <div class="mt-auto pt-3 border-top border-secondary border-opacity-20">
        <a href="{{ url('/logout') }}" class="nav-link text-danger fw-bold">
            <i class="bi bi-box-arrow-left me-2"></i> Logout
        </a>
    </div>
</div>

<div class="main-content">
    <div class="mb-5">
        <div class="page-header-label">Portal Pengajuan Berkas — Kominfo</div>
        <h1 class="section-title">Pengajuan Berkas</h1>
        <p class="section-subtitle">Layanan pengajuan administrasi kepegawaian secara terpadu.</p>
    </div>
    
    <div class="content-card">
        <div class="info-box">
            <div class="d-flex align-items-center">
                <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; font-size: 20px;">
                    🚀
                </div>
                <div>
                    <div class="info-box-title">Sistem Upload Dokumen Resmi</div>
                    <p class="mb-0 text-success small fw-medium">Upload dokumen melalui portal resmi Pemerintah Provinsi</p>
                </div>
            </div>
        </div>
        
        <div class="link-input-group">
            <label class="link-label">Tautan Portal Upload</label>
            <div class="position-relative">
                <input type="text" class="link-input" value="https://bkpsdmpangkat2023.carrd.co/" readonly>
                <i class="bi bi-link-45deg position-absolute end-0 top-50 translate-middle-y me-3 text-muted fs-5"></i>
            </div>
        </div>
        
        <button class="btn-link-external" onclick="window.open('https://bkpsdmpangkat2023.carrd.co/', '_blank')">
            <i class="bi bi-box-arrow-up-right fs-5"></i> Akses Portal Eksternal
        </button>
        
        <div class="instruction-section">
            <h3 class="instruction-title">
                <i class="bi bi-info-square-fill text-primary"></i> Panduan Pengajuan
            </h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="instruction-item">
                        <span class="instruction-number">01</span>
                        <span class="instruction-text">Klik tombol <strong>Akses Portal Eksternal</strong> untuk membuka sistem upload BKPSDM.</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="instruction-item">
                        <span class="instruction-number">02</span>
                        <span class="instruction-text">Gunakan <strong>NIP & Password</strong> resmi yang diberikan oleh pihak Provinsi.</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="instruction-item">
                        <span class="instruction-number">03</span>
                        <span class="instruction-text">Siapkan dokumen (KK, KTP, SK, Ijazah) dalam format <strong>PDF bersih</strong>.</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="instruction-item">
                        <span class="instruction-number">04</span>
                        <span class="instruction-text">Pastikan ukuran file di bawah <strong>1MB</strong> agar proses sinkronisasi lancar.</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="important-note shadow-sm">
            <div class="d-flex gap-3">
                <div class="bg-primary bg-opacity-10 p-2 rounded-3 h-100">
                    <i class="bi bi-exclamation-triangle-fill text-primary fs-5"></i>
                </div>
                <div>
                    <div class="important-note-title">Catatan Penting!  </div>
                    <p class="important-note-text mb-0">
                        Semua unggah dokumen dilakukan melalui sistem eksternal resmi Provinsi. Mohon diingat bahwa sistem ini   <strong>tidak terhubung otomatis</strong> dengan Arsip Digital KOMINFO
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>