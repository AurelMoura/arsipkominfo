<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DUK - Daftar Urut Kepegawaian - Arsip Digital</title>
    
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

        /* Sidebar Modern (Sama dengan halaman Validasi) */
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

        /* Fancy Stat Cards */
        .stat-card { 
            border: none; 
            border-radius: 20px; 
            padding: 24px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        }

        .icon-box { 
            width: 54px; height: 54px; 
            border-radius: 14px; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 1.5rem;
        }

        /* Modern Search Bar */
        .search-container {
            background: white;
            border-radius: 15px;
            padding: 10px 20px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            border: 1px solid #f1f5f9;
        }

        /* Table Design */
        .table-container {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
            border: 1px solid #f1f5f9;
        }

        .duk-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
        .duk-table thead th { 
            background-color: transparent; 
            color: #64748b; 
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            font-weight: 700;
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        .duk-row { 
            transition: all 0.2s; 
            border-radius: 12px;
        }

        .duk-row td { 
            padding: 20px 15px; 
            background: #fff;
            border-top: 1px solid #f8fafc;
            border-bottom: 1px solid #f8fafc;
        }

        .duk-row td:first-child { border-left: 1px solid #f8fafc; border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
        .duk-row td:last-child { border-right: 1px solid #f8fafc; border-top-right-radius: 12px; border-bottom-right-radius: 12px; }

        .duk-row:hover td {
            background-color: #fcfdfe;
            border-color: #e2e8f0;
            transform: scale(1.002);
        }

        .no-urut { font-weight: 700; color: var(--primary-blue); }

        .btn-detail {
            background: #f0f7ff;
            color: var(--primary-blue);
            border: none;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            transition: 0.3s;
        }

        .btn-detail:hover {
            background: var(--primary-blue);
            color: white;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }

        .badge-nip {
            background: #f1f5f9;
            color: #475569;
            padding: 6px 12px;
            border-radius: 8px;
            font-family: 'Courier New', Courier, monospace;
            font-weight: 600;
        }
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
                    <li class="breadcrumb-item active fw-bold text-primary">Daftar Urut Kepegawaian</li>
                </ol>
            </nav>
            <h2 class="fw-bold text-dark mb-1">Database DUK</h2>
            <p class="text-muted mb-0">Manajemen urutan kepegawaian berdasarkan standarisasi NIP.</p>
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
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-3 fs-4"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card stat-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary me-4">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0 text-dark">{{ $total_pegawai ?? 0 }}</h3>
                        <p class="text-muted mb-0 fw-medium">Total Pegawai Terdaftar</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stat-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-success bg-opacity-10 text-success me-4">
                        <i class="bi bi-file-earmark-check-fill"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0 text-dark">{{ $total_pegawai ?? 0 }}</h3>
                        <p class="text-muted mb-0 fw-medium">Data Terverifikasi DUK</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="search-container mb-4">
        <div class="input-group">
            <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search fs-5"></i></span>
            <input type="text" class="form-control border-0 shadow-none py-2" id="searchDUK" placeholder="Ketik nama, NIP, atau jabatan pegawai untuk memfilter data secara instan...">
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="duk-table">
                <thead>
                    <tr>
                        <th width="80" class="text-center">No.</th>
                        <th>NIP Pegawai</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan Terakhir</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dukTableBody">
                    @foreach($pegawai as $nomor => $p)
                    <tr class="duk-row">
                        <td class="text-center no-urut">{{ $nomor + 1 }}</td>
                        <td><span class="badge-nip">{{ $p->identifier }}</span></td>
                        <td>
                            <div class="fw-bold text-dark">{{ $p->name }}</div>
                            <small class="text-muted" style="font-size: 11px;">Status: Aktif</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-briefcase me-2 text-muted"></i>
                                <span class="text-secondary fw-medium">{{ $p->jabatan ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ url('/admin/pegawai/'.$p->id.'/drh') }}" class="btn-detail text-decoration-none d-inline-block">
                                <i class="bi bi-person-lines-fill me-1"></i> Profil
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(count($pegawai) === 0)
        <div class="text-center py-5">
            <img src="https://illustrations.popsy.co/gray/data-report.svg" style="width: 180px;" class="mb-4">
            <h5 class="fw-bold text-dark">Data Belum Tersedia</h5>
            <p class="text-muted small">Silakan tambahkan data pegawai baru melalui menu Data Pegawai.</p>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Logic pencarian tetap sama namun dengan performa yang terjaga
    document.getElementById('searchDUK')?.addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('.duk-row');
        
        rows.forEach(row => {
            const nip = row.querySelector('.badge-nip').textContent.toLowerCase();
            const nama = row.querySelector('.text-dark').textContent.toLowerCase();
            const jabatan = row.querySelector('.text-secondary').textContent.toLowerCase();
            
            if (nip.includes(searchValue) || nama.includes(searchValue) || jabatan.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>