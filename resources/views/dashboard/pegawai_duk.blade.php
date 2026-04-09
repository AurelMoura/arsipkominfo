<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai - Arsip Digital</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            --sidebar-color: #0f172a; 
            --primary-blue: #4361ee; 
            --accent-color: #4cc9f0;
            --bg-body: #f8fafc;
        }

        body { 
            background-color: var(--bg-body); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #1e293b;
            margin: 0;
        }

        /* Sidebar Modern (Identik dengan halaman Validasi) */
        .sidebar { 
            width: 280px; 
            height: 100vh; 
            background: var(--sidebar-color); 
            position: fixed; 
            color: white; 
            z-index: 100;
            box-shadow: 10px 0 30px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .nav-link { 
            color: #94a3b8; 
            margin: 8px 15px; 
            border-radius: 12px; 
            transition: 0.3s all cubic-bezier(0.4, 0, 0.2, 1); 
            padding: 12px 15px;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .nav-link i { font-size: 1.2rem; }

        .nav-link.active { 
            background: linear-gradient(135deg, var(--primary-blue), #3b82f6); 
            color: white; 
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .nav-link:hover:not(.active) { 
            background: rgba(255,255,255,0.05); 
            color: white; 
            transform: translateX(5px);
        }

        .user-profile-nav {
            background: rgba(255,255,255,0.05);
            border-radius: 15px;
            padding: 12px;
            margin: 0 15px 30px 15px;
        }

        /* Main Content */
        .main-content { margin-left: 280px; padding: 40px; min-height: 100vh; }

        /* Stat Cards */
        .stat-card { 
            border: none; 
            border-radius: 20px; 
            padding: 24px;
            background: white;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        .stat-card:hover { transform: translateY(-5px); }

        /* Pegawai Cards Grid */
        .pegawai-card { 
            border: none; 
            border-radius: 24px; 
            background: white; 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .pegawai-card:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04) !important; 
        }

        .avatar-box { 
            width: 56px; 
            height: 56px; 
            border-radius: 16px; 
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-color));
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-weight: 700; 
            font-size: 22px;
            color: white;
            box-shadow: 0 8px 15px rgba(67, 97, 238, 0.2);
        }

        /* Search & Actions Area */
        .action-bar {
            background: white;
            padding: 15px;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            border: 1px solid #f1f5f9;
        }

        .btn-detail { 
            border-radius: 12px; 
            background: #f1f5f9; 
            color: var(--primary-blue); 
            font-weight: 600;
            padding: 10px; 
            transition: 0.3s; 
            width: 100%; 
            text-align: center; 
            text-decoration: none; 
            display: inline-block;
            border: 1px solid transparent;
        }

        .btn-detail:hover { 
            background: var(--primary-blue); 
            color: white; 
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }

        .btn-primary {
            background: var(--primary-blue);
            border: none;
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #3651d1;
            transform: scale(1.02);
            box-shadow: 0 10px 15px -3px rgba(67, 97, 238, 0.3);
        }

        /* Modal Customization */
        .modal-content { border-radius: 28px; border: none; overflow: hidden; }
        .modal-header { background: var(--sidebar-color) !important; padding: 25px; }
        .form-control { border-radius: 12px; padding: 12px; border: 1px solid #e2e8f0; }
        .form-control:focus { box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1); border-color: var(--primary-blue); }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column p-3">
    <div class="d-flex align-items-center mb-4 px-3 mt-2">
        <div class="bg-primary p-2 rounded-3 me-3">
            <img src="{{ asset('image/LOGOKOMINFO.png') }}" width="24">
        </div>
        <div class="lh-1">
            <div class="fw-bold text-white" style="font-size: 16px; letter-spacing: 0.5px;">KOMINFO</div>
            <small class="text-muted" style="font-size: 11px;">Arsip Digital v2.0</small>
        </div>
    </div>

    <div class="user-profile-nav">
        <div class="d-flex align-items-center">
            <div class="avatar me-3 bg-info rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; background: linear-gradient(135deg, #4cc9f0, #4361ee) !important;">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="overflow-hidden">
                <div class="fw-bold text-white text-truncate" style="font-size: 14px;">{{ Session::get('name') }}</div>
                <small class="text-muted" style="font-size: 11px;">Administrator</small>
            </div>
        </div>
    </div>

    <small class="text-muted ms-3 mb-3 text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 1.5px;">Menu Utama</small>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2 me-3"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ url('/pegawai') }}" class="nav-link {{ Request::is('pegawai') ? 'active' : '' }}">
                <i class="bi bi-person-badge me-3"></i> Data Pegawai
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/duk') }}" class="nav-link {{ Request::is('admin/duk') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-list me-3"></i> DUK - Urut NIP
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/validasi-dokumen') }}" class="nav-link {{ Request::is('admin/validasi-dokumen') ? 'active' : '' }}">
                <i class="bi bi-shield-check me-3"></i> Validasi Dokumen
            </a>
        </li>
    </ul>

    <div class="mt-auto pt-3 mx-2">
        <a href="{{ url('/logout') }}" class="nav-link text-danger fw-600">
            <i class="bi bi-power me-3"></i> Keluar Sistem
        </a>
    </div>
</div>

<div class="main-content">
    
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1" style="font-size: 12px;">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Portal</a></li>
                    <li class="breadcrumb-item active fw-bold text-primary">Database Pegawai</li>
                </ol>
            </nav>
            <h2 class="fw-bold text-dark mb-1">Manajemen Pegawai</h2>
            <p class="text-muted mb-0">Kelola dan pantau kelengkapan arsip digital setiap pegawai.</p>
        </div>
        <div class="d-none d-md-flex align-items-center bg-white p-2 rounded-4 shadow-sm border">
            <div class="bg-light p-2 rounded-3 me-3 text-primary"><i class="bi bi-calendar3"></i></div>
            <div class="me-3">
                <small class="text-muted d-block" style="font-size: 10px;">Hari ini</small>
                <span class="fw-bold small">{{ date('d M Y') }}</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center p-3" role="alert">
            <i class="bi bi-check-circle-fill me-3 fs-4 text-success"></i>
            <div class="fw-medium">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card stat-card d-flex flex-row align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-4"><i class="bi bi-people-fill fs-3"></i></div>
                <div>
                    <h2 class="fw-bold mb-0 text-dark">{{ $total_pegawai ?? 0 }}</h2>
                    <p class="text-muted mb-0 fw-medium">Total Pegawai Terdaftar</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stat-card d-flex flex-row align-items-center" style="border-right: 5px solid #06d6a0;">
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-4 me-4"><i class="bi bi-file-earmark-check-fill fs-3"></i></div>
                <div>
                    <h2 class="fw-bold mb-0 text-dark">20</h2>
                    <p class="text-muted mb-0 fw-medium">Total Dokumen Arsip</p>
                </div>
            </div>
        </div>
    </div>

    <div class="action-bar mb-5">
        <div class="row g-3 align-items-center">
            <div class="col-md-8">
                <div class="input-group bg-light rounded-3 px-2">
                    <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control bg-transparent border-0 py-2 shadow-none" placeholder="Cari berdasarkan nama, NIP, atau jabatan...">
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary w-100 py-2 d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-person-plus-fill me-2 fs-5"></i> Registrasi Pegawai
                </button>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @foreach($pegawai as $p)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card pegawai-card p-4 h-100 shadow-sm">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar-box me-3">
                        {{ strtoupper(substr($p->name, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <h6 class="fw-bold mb-1 text-dark text-truncate">{{ $p->name }}</h6>
                        <span class="badge bg-light text-primary border border-primary border-opacity-10 px-2 py-1" style="font-size: 11px; letter-spacing: 0.5px;">{{ $p->identifier }}</span>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex align-items-center text-muted mb-2 small fw-medium">
                        <i class="bi bi-briefcase me-2"></i>
                        <span class="text-truncate">ASN Kominfo</span>
                    </div>
                    <div class="d-flex align-items-center text-muted mb-2 small fw-medium">
                        <i class="bi bi-geo-alt me-2 text-danger"></i>
                        <span class="text-truncate">Bagian Umum</span>
                    </div>
                    <div class="d-flex align-items-center text-muted small fw-medium">
                        <i class="bi bi-file-earmark-text me-2 text-success"></i>
                        <span>0 Dokumen Tervalidasi</span>
                    </div>
                </div>

                <div class="mt-auto">
                    <a href="{{ url('/admin/pegawai/'.$p->id.'/drh') }}" class="btn-detail">
                        <i class="bi bi-arrow-right-circle-fill me-2"></i> Kelola Arsip
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold text-white"><i class="bi bi-person-plus-fill me-2"></i>Tambah Pegawai Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/pegawai/store') }}" method="POST">
                @csrf 
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Nomor Induk Pegawai (Username)</label>
                        <input type="number" name="nip" class="form-control" placeholder="Contoh: 19881231..." required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Nama Lengkap Sesuai SK</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap..." required>
                    </div>
                    <div class="p-3 rounded-4 bg-info bg-opacity-10 border border-info border-opacity-20">
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill text-info fs-5 me-3"></i>
                            <p class="mb-0 small text-dark opacity-75">Password akun akan otomatis diatur sesuai <strong>NIP</strong>. Pegawai disarankan segera melakukan pembaruan keamanan setelah akses pertama.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 py-2 fw-semibold" data-bs-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">Daftarkan Pegawai</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>