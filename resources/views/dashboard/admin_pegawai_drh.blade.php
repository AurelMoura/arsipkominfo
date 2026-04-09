<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail DRH Pegawai - {{ $user->name }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            --sidebar-color: #0f172a; 
            --primary-blue: #3b82f6; 
            --accent-blue: #eff6ff;
            --card-border: rgba(226, 232, 240, 0.6); 
        }

        body { 
            background: #f8fafc; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            margin: 0; 
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Sidebar Modern Styling */
        .sidebar { 
            width: 280px; 
            height: 100vh; 
            background: var(--sidebar-color); 
            position: fixed; 
            color: white; 
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .nav-link { 
            color: #94a3b8; 
            margin: 8px 15px; 
            border-radius: 12px; 
            padding: 12px 15px; 
            transition: 0.2s;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .nav-link:hover, .nav-link.active { 
            background: rgba(59, 130, 246, 0.15); 
            color: #60a5fa; 
        }

        /* Layout Main Content */
        .main-content { 
            margin-left: 280px; 
            padding: 40px; 
            min-height: 100vh; 
        }

        /* Modern Glass Card */
        .glass-card {
            background: #ffffff;
            border: 1px solid var(--card-border);
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            border-radius: 24px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .glass-card:hover {
            box-shadow: 0 10px 30px -5px rgba(15, 23, 242, 0.08);
        }

        /* Custom Tab Styling */
        .nav-pills .nav-link {
            background: white;
            color: #64748b;
            border: 1px solid var(--card-border);
            margin-right: 10px;
            border-radius: 12px;
            padding: 10px 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .nav-pills .nav-link.active {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* Header Avatar & Profile */
        .avatar-avatar {
            width: 85px;
            height: 85px;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            font-weight: 800;
            color: white;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: 4px solid white;
            box-shadow: 0 10px 20px rgba(37,99,235,0.15);
        }

        .detail-header {
            background: white;
            border: 1px solid var(--card-border);
            padding: 2.5rem;
            border-radius: 28px;
            margin-bottom: 2rem;
            position: relative;
        }

        /* Tables and Info Boxes */
        .subtable {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }

        .subtable th {
            background: #f8fafc;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            padding: 18px;
            color: #64748b;
        }

        .subtable td {
            padding: 16px;
            vertical-align: middle;
        }

        .info-card-sm {
            border-radius: 18px;
            border: 1px solid #f1f5f9;
            background: #fdfdfd;
            transition: all 0.2s ease;
            padding: 20px;
        }

        .info-card-sm:hover {
            border-color: #3b82f6;
            background: #f0f7ff;
            transform: translateY(-2px);
        }

        /* Sidebar Summary - Sticky */
        .sticky-summary {
            position: sticky;
            top: 40px;
        }

        .badge-status {
            padding: 6px 14px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        /* Animation */
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media print {
            .sidebar, .no-print, .nav-pills, .sticky-summary { display: none !important; }
            .main-content { margin-left: 0 !important; padding: 0 !important; }
            .tab-content > .tab-pane { display: block !important; opacity: 1 !important; }
            .glass-card { border: none; box-shadow: none; }
        }

        /* Mobile Adjustments */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; padding: 20px; }
        }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column p-3 no-print">
    <div class="d-flex align-items-center mb-5 px-3 mt-3">
        <div class="bg-primary rounded-3 p-2 me-2 shadow-sm">
            <img src="{{ asset('image/LOGOKOMINFO.png') }}" width="25">
        </div>
        <div class="lh-1">
            <div class="fw-bold" style="font-size: 16px; letter-spacing: 0.5px; color: #fff;">KOMINFO</div>
            <small class="text-muted" style="font-size: 11px;">Arsip Digital Pegawai</small>
        </div>
    </div>
    
    <div class="nav flex-column">
        <a href="{{ url('/dashboard') }}" class="nav-link"><i class="bi bi-grid-1x2 me-3"></i> Dashboard</a>
        <a href="{{ url('/pegawai') }}" class="nav-link active"><i class="bi bi-people me-3"></i> Data Pegawai</a>
        <a href="{{ url('/admin/validasi-dokumen') }}" class="nav-link"><i class="bi bi-shield-check me-3"></i> Validasi Dokumen</a>
        <a href="#" class="nav-link"><i class="bi bi-folder2-open me-3"></i> Arsip Digital</a>
    </div>
    
    <div class="mt-auto pt-3 border-top border-secondary border-opacity-25">
        <a href="{{ url('/logout') }}" class="nav-link text-danger"><i class="bi bi-box-arrow-left me-3"></i> Logout</a>
    </div>
</div>

<div class="main-content">
    
    <div class="d-flex justify-content-between align-items-center mb-4 no-print fade-in-up">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/pegawai') }}" class="text-decoration-none">Pegawai</a></li>
                <li class="breadcrumb-item active">Detail DRH</li>
            </ol>
        </nav>
        <div class="d-flex gap-2">
            <a href="{{ url('/pegawai') }}" class="btn btn-light border px-4 rounded-3 fw-bold">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
            <a href="{{ url('/admin/pegawai/'.$user->id.'/drh/print') }}" target="_blank" class="btn btn-primary px-4 rounded-3 shadow-sm fw-bold">
                <i class="bi bi-printer me-2"></i> Print Dokumen
            </a>
        </div>
    </div>

    <div class="row g-4 fade-in-up">
        <div class="col-lg-9">
            
            <div class="detail-header shadow-sm border-0">
                <div class="row align-items-center">
                    <div class="col-md-auto text-center text-md-start mb-3 mb-md-0">
                        <div class="avatar-avatar mx-auto">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    </div>
                    <div class="col-md ms-md-3">
                        <h1 class="fw-800 mb-1 text-dark" style="font-size: 2.2rem;">{{ $user->name }}</h1>
                        <div class="d-flex flex-wrap gap-4 mt-3">
                            <div class="d-flex align-items-center text-muted">
                                <i class="bi bi-hash fs-5 me-1 text-primary"></i> 
                                <span class="fw-600">{{ $drhData->nip ?? $user->identifier }}</span>
                            </div>
                            <div class="d-flex align-items-center text-muted">
                                <i class="bi bi-briefcase fs-5 me-2 text-primary"></i> 
                                <span class="fw-600">{{ $drhData->jabatan ?? 'Jabatan Belum Diisi' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                    <i class="bi bi-patch-check-fill me-1"></i> {{ $drhData->status_pegawai ?? 'Aktif' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-pills mb-4 no-print scroll-x flex-nowrap pb-2" id="pills-tab" role="tablist" style="overflow-x: auto;">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-pribadi"><i class="bi bi-person me-2"></i> Data Pribadi</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-keluarga"><i class="bi bi-heart me-2"></i> Keluarga</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-pendidikan"><i class="bi bi-mortarboard me-2"></i> Pendidikan</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-karir"><i class="bi bi-bar-chart-steps me-2"></i> Karir & Prestasi</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-dokumen"><i class="bi bi-file-earmark-lock me-2"></i> Legalitas</button></li>
            </ul>

            <div class="tab-content">
                
                <div class="tab-pane fade show active" id="tab-pribadi">
                    <div class="glass-card p-4 p-md-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3"><i class="bi bi-person-vcard fs-4 text-primary"></i></div>
                            <h5 class="fw-bold mb-0">Identitas Diri Lengkap</h5>
                        </div>
                        <div class="row g-4">
                            @php
                                $infoFields = [
                                    ['label' => 'NIK (Nomor Induk Kependudukan)', 'value' => $drhData->nik ?? '-', 'icon' => 'card-heading'],
                                    ['label' => 'Alamat Email Instansi', 'value' => $drhData->email ?? $user->email, 'icon' => 'envelope'],
                                    ['label' => 'Nomor WhatsApp', 'value' => $drhData->no_hp ?? '-', 'icon' => 'whatsapp'],
                                    ['label' => 'Golongan / Ruang', 'value' => $drhData->golongan ?? '-', 'icon' => 'layers'],
                                    ['label' => 'Jenis ASN', 'value' => $drhData->jenis_asn ?? '-', 'icon' => 'person-gear'],
                                    ['label' => 'Tempat, Tanggal Lahir', 'value' => ($drhData->tempat_lahir ?? '-') . ', ' . (optional($drhData->tanggal_lahir)->format('d F Y') ?? '-'), 'icon' => 'calendar-event'],
                                    ['label' => 'Agama', 'value' => $drhData->agama ?? '-', 'icon' => 'moon-stars'],
                                    ['label' => 'Golongan Darah', 'value' => $drhData->golongan_darah ?? '-', 'icon' => 'droplet'],
                                    ['label' => 'Jenis Kelamin', 'value' => $drhData->jenis_kelamin ?? '-', 'icon' => 'gender-ambiguous'],
                                ];
                            @endphp
                            @foreach($infoFields as $f)
                            <div class="col-md-6 col-xl-4">
                                <div class="info-card-sm h-100">
                                    <label class="small text-muted fw-bold text-uppercase mb-2 d-block" style="font-size: 10px; letter-spacing: 1px;">{{ $f['label'] }}</label>
                                    <div class="fw-bold text-dark d-flex align-items-center">
                                        <i class="bi bi-{{ $f['icon'] }} me-2 text-primary opacity-50"></i> {{ $f['value'] }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-12 mt-4">
                                <div class="p-4 border rounded-4 bg-light bg-opacity-50">
                                    <label class="small text-muted fw-bold text-uppercase mb-2 d-block">Alamat Domisili Sesuai KTP</label>
                                    <div class="fw-bold fs-6"><i class="bi bi-geo-alt me-2 text-danger"></i> {{ $drhData->alamat_domisili ?? 'Alamat belum diinput ke dalam sistem.' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-keluarga">
                    <div class="glass-card p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0 text-danger"><i class="bi bi-heart-fill me-2"></i> Data Pasangan</h5>
                            @if(data_get($drhData, 'data_pasangan.file'))
                                <a href="{{ url('/admin/drh/legal/'.$user->id.'/pasangan/view') }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-3">Lihat Buku Nikah</a>
                            @endif
                        </div>
                        @php $pasangan = $drhData->data_pasangan ?? []; @endphp
                        @if($pasangan && ($pasangan['nama'] ?? false))
                            <div class="row bg-light rounded-4 p-4 g-3">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Nama Lengkap</small>
                                    <span class="fw-bold">{{ $pasangan['nama'] }}</span>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Pekerjaan</small>
                                    <span class="fw-bold">{{ $pasangan['pekerjaan'] ?? '-' }}</span>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">NIK Pasangan</small>
                                    <span class="fw-bold">{{ $pasangan['nik'] ?? '-' }}</span>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Tempat, Tanggal Lahir</small>
                                    <span class="fw-bold">{{ $pasangan['tempat_lahir'] }}, {{ $pasangan['tanggal_lahir'] }}</span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5 border border-dashed rounded-4">
                                <i class="bi bi-heartbreak fs-1 text-muted opacity-25"></i>
                                <p class="text-muted mt-2">Data pasangan belum tercatat.</p>
                            </div>
                        @endif
                    </div>

                    <div class="glass-card p-4">
                        <h5 class="fw-bold mb-4 text-info"><i class="bi bi-people-fill me-2"></i> Data Anak</h5>
                        @php $anakList = $drhData->data_anak ?? []; @endphp
                        @if(is_array($anakList) && count($anakList) > 0)
                            <div class="table-responsive">
                                <table class="table subtable mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <th>NIK</th>
                                            <th>Tempat, Tanggal Lahir</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($anakList as $anak)
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $anak['nama'] }}</td>
                                            <td>{{ $anak['nik'] ?? '-' }}</td>
                                            <td>{{ $anak['tempat_lahir'] }}, {{ $anak['tanggal_lahir'] }}</td>
                                            <td class="text-center">
                                                @if(!empty($anak['file']))
                                                    <a href="{{ asset('storage/'.$anak['file']) }}" target="_blank" class="btn btn-sm btn-light rounded-circle"><i class="bi bi-eye text-primary"></i></a>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">Data anak tidak ditemukan.</div>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-pendidikan">
                    <div class="glass-card p-4 mb-4">
                        <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-mortarboard-fill me-2"></i> Riwayat Pendidikan Formal</h5>
                        @php $pendidikanList = $drhData->riwayat_pendidikan ?? []; @endphp
                        <div class="table-responsive">
                            <table class="table subtable">
                                <thead>
                                    <tr>
                                        <th>Jenjang</th>
                                        <th>Nama Institusi</th>
                                        <th>Tahun Lulus</th>
                                        <th>Nomor Ijazah</th>
                                        <th class="text-center">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendidikanList as $pend)
                                    <tr>
                                        <td><span class="badge bg-primary bg-opacity-10 text-primary px-3">{{ $pend['jenjang'] }}</span></td>
                                        <td class="fw-bold">{{ $pend['nama_sekolah'] }}</td>
                                        <td>{{ $pend['tahun_lulus'] }}</td>
                                        <td class="small">{{ $pend['nomor_ijazah'] ?? '-' }}</td>
                                        <td class="text-center">
                                            @if(!empty($pend['file']))
                                                <a href="{{ asset('storage/'.$pend['file']) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-file-earmark-pdf"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-karir">
                    <div class="glass-card p-4">
                        <h5 class="fw-bold mb-4 text-warning"><i class="bi bi-briefcase-fill me-2"></i> Riwayat Jabatan & Kepangkatan</h5>
                        @php $jabatanList = $drhData->riwayat_jabatan ?? []; @endphp
                        <div class="table-responsive">
                            <table class="table subtable">
                                <thead>
                                    <tr>
                                        <th>Jabatan</th>
                                        <th>Unit Kerja</th>
                                        <th>Gol</th>
                                        <th>TMT</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jabatanList as $jab)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $jab['jabatan'] }}</td>
                                        <td>{{ $jab['unit_kerja'] }}</td>
                                        <td><span class="fw-600">{{ $jab['golongan'] ?? '-' }}</span></td>
                                        <td>{{ $jab['tmt'] }}</td>
                                        <td>
                                            @if(!empty($jab['file']))
                                                <a href="{{ asset('storage/'.$jab['file']) }}" target="_blank" class="btn btn-sm btn-light">SK</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-dokumen">
                    <div class="glass-card p-4">
                        <h5 class="fw-bold mb-4 text-success"><i class="bi bi-shield-lock-fill me-2"></i> Vault Dokumen Legalitas</h5>
                        @php
                            $vault = [
                                ['label' => 'Kartu Tanda Penduduk (KTP)', 'path' => $drhData->file_ktp ?? null, 'type' => 'ktp', 'icon' => 'card-text'],
                                ['label' => 'NPWP (Pajak)', 'path' => $drhData->file_npwp ?? null, 'type' => 'npwp', 'icon' => 'bank'],
                                ['label' => 'BPJS Kesehatan/Ketenagakerjaan', 'path' => $drhData->file_bpjs ?? null, 'type' => 'bpjs', 'icon' => 'heart-pulse'],
                                ['label' => 'Kartu Keluarga (KK)', 'path' => $drhData->file_kk ?? null, 'type' => 'kk', 'icon' => 'people'],
                                ['label' => 'Ijazah Terakhir', 'path' => data_get($drhData, 'dokumen_pendukung.ijazah'), 'type' => 'ijazah', 'icon' => 'mortarboard'],
                            ];
                        @endphp
                        <div class="row g-4">
                            @foreach($vault as $doc)
                            <div class="col-md-6">
                                <div class="p-4 border rounded-4 d-flex align-items-center justify-content-between hover-shadow transition">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light p-3 rounded-4 me-3 text-success shadow-sm"><i class="bi bi-{{ $doc['icon'] }} fs-4"></i></div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $doc['label'] }}</div>
                                            <span class="small {{ $doc['path'] ? 'text-success' : 'text-danger' }} d-flex align-items-center">
                                                <i class="bi bi-{{ $doc['path'] ? 'check-circle-fill' : 'exclamation-circle' }} me-1"></i>
                                                {{ $doc['path'] ? 'Tersedia di Server' : 'Belum Diunggah' }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($doc['path'])
                                    <div class="dropdown">
                                        <button class="btn btn-white border-0 p-2" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 rounded-3">
                                            <li><a class="dropdown-item rounded-2" href="{{ url('/admin/drh/legal/'.$user->id.'/'.$doc['type'].'/view') }}" target="_blank"><i class="bi bi-eye me-2"></i> Lihat</a></li>
                                            <li><a class="dropdown-item rounded-2" href="{{ url('/admin/drh/legal/'.$user->id.'/'.$doc['type'].'/download') }}"><i class="bi bi-download me-2"></i> Unduh</a></li>
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-3 no-print">
            <div class="sticky-summary">
                
                <div class="glass-card p-4 mb-4 bg-primary text-white border-0 shadow-lg" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6) !important;">
                    <h6 class="fw-bold mb-4 opacity-75 text-uppercase" style="font-size: 11px; letter-spacing: 1px;">Konektivitas Data</h6>
                    <div class="d-grid gap-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small">Anggota Keluarga</span>
                            <span class="fw-bold">{{ is_array($drhData->data_anak ?? []) ? count($drhData->data_anak) : 0 }} Jiwa</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small">Total Riwayat Karir</span>
                            <span class="fw-bold">{{ is_array($drhData->riwayat_jabatan ?? []) ? count($drhData->riwayat_jabatan) : 0 }} Data</span>
                        </div>
                        <hr class="my-1 border-white opacity-25">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small">Status Verifikasi</span>
                            <span class="badge bg-white text-primary rounded-pill px-3">Sudah Valid</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-4 text-center border-0 shadow-sm">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="bi bi-shield-lock text-warning fs-3"></i>
                    </div>
                    <h6 class="fw-bold">Keamanan Data</h6>
                    <p class="small text-muted mb-4">Seluruh dokumen ini bersifat rahasia dan hanya dapat diakses oleh Admin & Pegawai bersangkutan.</p>
                    <button class="btn btn-light w-100 py-2 rounded-3 fw-bold small"><i class="bi bi-info-circle me-1"></i> Log Akses Terakhir</button>
                </div>

                <div class="mt-4 px-2">
                    <p class="text-muted" style="font-size: 10px;">&copy; 2026 Kominfo Kota Bengkulu. <br>Dikembangkan oleh Aurel (Mahasiswa Informatika).</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Inisialisasi Tooltips/Tabs jika diperlukan
    document.addEventListener('DOMContentLoaded', function () {
        var triggerTabList = [].slice.call(document.querySelectorAll('#pills-tab button'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })
    });
</script>
</body>
</html>