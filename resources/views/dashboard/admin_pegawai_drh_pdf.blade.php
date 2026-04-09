<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Riwayat Hidup - {{ $user->name }}</title>
    <style>
        /* Setup Dasar & Print */
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #e0e0e0;
            margin: 0;
            padding: 0;
            color: #222;
            line-height: 1.5;
        }
        .page {
            width: 21cm;
            min-height: 29.7cm;
            padding: 16mm 20mm;
            margin: 10px auto;
            background: white;
            box-shadow: 0 0 12px rgba(0,0,0,0.15);
            box-sizing: border-box;
            position: relative;
        }

        /* Kop Surat Kominfo */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px solid #111;
            margin-bottom: 18px;
        }
        .logo-cell {
            width: 15%;
            padding-bottom: 4px;
            vertical-align: middle;
        }
        .logo-cell img {
            width: 100px;
            height: auto;
        }
        .text-cell {
            width: 85%;
            text-align: center;
            padding-bottom: 4px;
            vertical-align: middle;
        }
        .text-cell h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 500;
            letter-spacing: 1px;
            line-height: 1.1;
        }
        .text-cell h1 {
            margin: 3px 0 6px;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 0.35px;
            white-space: nowrap;
            line-height: 1.05;
        }
        .address-info {
            font-size: 13px;
            margin: 1px 0 3px;
            line-height: 1.3;
        }
        .contact-info {
            font-size: 13px;
            margin: 1px 0 0;
            line-height: 1.3;
        }
        .contact-info a {
            color: #0d47a1;
            text-decoration: underline;
        }
        .document-title {
            text-align: center;
            font-family: "Times New Roman", Times, serif;
            font-weight: bold;
            font-size: 20px;
            text-transform: uppercase;
            margin: 12px 0 18px;
        }
        .document-title::after {
            content: "";
            display: block;
            width: 160px;
            height: 2px;
            background: #111;
            margin: 8px auto 0;
        }

        /* Judul Dokumen */
        .title {
            text-align: center;
            margin: 30px 0;
            font-size: 16pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            font-family: 'Times New Roman', Times, serif;
        }

        /* Seksi/Kategori */
        .section-container {
            margin-bottom: 18px;
        }
        .section-header {
            background-color: #f5f5f5;
            padding: 8px 12px;
            border-left: 5px solid #111;
            font-weight: bold;
            font-size: 11pt;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Grid Data Personalia */
        .field-grid {
            width: 100%;
            border-collapse: collapse;
            margin-left: 10px;
        }
        .field-grid td {
            padding: 6px 4px;
            font-size: 10.5pt;
            vertical-align: top;
        }
        .field-grid td.label {
            width: 30%;
            color: #555;
        }
        .field-grid td.separator {
            width: 2%;
            text-align: center;
        }
        .field-grid td.value {
            font-weight: 600;
            color: #000;
        }

        /* Tabel untuk List (Anak) */
        .subtable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .subtable th {
            background: #333;
            color: white;
            text-align: left;
            padding: 10px;
            font-size: 9pt;
            text-transform: uppercase;
        }
        .subtable td {
            border-bottom: 1px solid #ddd;
            padding: 8px 10px;
            font-size: 9.5pt;
        }
        .subtable tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Badge untuk Dokumen */
        .status-badge {
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9pt;
            font-weight: bold;
        }
        .bg-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .bg-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .note-footer {
            margin-top: 50px;
            font-size: 9pt;
            font-style: italic;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
            text-align: center;
        }

        @media print {
            body { background: white; }
            .page { 
                margin: 0; 
                box-shadow: none; 
                width: 100%;
            }
            .section-header {
                -webkit-print-color-adjust: exact;
                background-color: #f2f2f2 !important;
            }
            .subtable th {
                -webkit-print-color-adjust: exact;
                background-color: #333 !important;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <img src="{{ asset('image/pemkot.png') }}" alt="Logo Kominfo">
                </td>
                <td class="text-cell">
                    <h2>PEMERINTAH KOTA BENGKULU</h2>
                    <h1>DINAS KOMUNIKASI DAN INFORMATIKA</h1>
                    <p class="address-info">Alamat : Jl. Jati Raya No. 01 Kota Bengkulu Telp. (0736) – 21003 &nbsp; Kode Pos. 38227</p>
                    <p class="contact-info">Website: <a href="http://www.bengkulukota.go.id">www.bengkulukota.go.id</a> | email: <a href="mailto:kominfo@bengkulukota.go.id">kominfo@bengkulukota.go.id</a></p>
                </td>
            </tr>
        </table>

        @if(!$drhData)
            <div style="padding: 100px 0; text-align: center;">
                <h3 style="color: #888;">Data DRH tidak ditemukan.</h3>
            </div>
        @else
            <div class="document-title">DAFTAR RIWAYAT HIDUP</div>

            @php
                $pasangan = $drhData->data_pasangan ?? [];
                $anakList = $drhData->data_anak ?? [];
                $orangTua = $drhData->data_orang_tua ?? [];
                $mertua = $drhData->data_mertua ?? [];
                $riwayatPendidikan = $drhData->riwayat_pendidikan ?? [];
                $riwayatDiklat = $drhData->riwayat_diklat ?? [];
                $riwayatJabatan = $drhData->riwayat_jabatan ?? [];
                $riwayatPenghargaan = $drhData->riwayat_penghargaan ?? [];
                $riwayatSertifikasi = $drhData->riwayat_sertifikasi ?? [];
                $dokumenPendukung = [
                    'akta_kelahiran' => data_get($drhData, 'dokumen_pendukung.akta_kelahiran'),
                    'diklat' => data_get($drhData, 'dokumen_pendukung.diklat'),
                    'ijazah' => data_get($drhData, 'dokumen_pendukung.ijazah'),
                    'sk' => data_get($drhData, 'dokumen_pendukung.sk'),
                    'penghargaan' => data_get($drhData, 'dokumen_pendukung.penghargaan'),
                    'sertifikat' => data_get($drhData, 'dokumen_pendukung.sertifikat'),
                ];
            @endphp

            <div class="section-container">
                <div class="section-header"><span>I. Identitas Pegawai</span></div>
                <table class="field-grid">
                    <tr><td class="label">Nama Lengkap</td><td class="separator">:</td><td class="value">{{ $drhData->nama_lengkap ?? '-' }}</td></tr>
                    <tr><td class="label">NIP</td><td class="separator">:</td><td class="value">{{ $drhData->nip ?? '-' }}</td></tr>
                    <tr><td class="label">NIK</td><td class="separator">:</td><td class="value">{{ $drhData->nik ?? '-' }}</td></tr>
                    <tr><td class="label">Jabatan</td><td class="separator">:</td><td class="value">{{ $drhData->jabatan ?? '-' }}</td></tr>
                    <tr><td class="label">Golongan</td><td class="separator">:</td><td class="value">{{ $drhData->golongan ?? '-' }}</td></tr>
                    <tr><td class="label">Tempat Lahir</td><td class="separator">:</td><td class="value">{{ $drhData->tempat_lahir ?? '-' }}</td></tr>
                    <tr><td class="label">Tanggal Lahir</td><td class="separator">:</td><td class="value">{{ optional($drhData->tanggal_lahir)->format('d F Y') ?? '-' }}</td></tr>
                    <tr><td class="label">Jenis Kelamin</td><td class="separator">:</td><td class="value">{{ $drhData->jenis_kelamin ?? '-' }}</td></tr>
                    <tr><td class="label">Agama</td><td class="separator">:</td><td class="value">{{ $drhData->agama ?? '-' }}</td></tr>
                    <tr><td class="label">No. HP</td><td class="separator">:</td><td class="value">{{ $drhData->no_hp ?? '-' }}</td></tr>
                    <tr><td class="label">Email</td><td class="separator">:</td><td class="value">{{ $drhData->email ?? '-' }}</td></tr>
                    <tr><td class="label">Alamat Domisili</td><td class="separator">:</td><td class="value">{{ $drhData->alamat_domisili ?? '-' }}</td></tr>
                    <tr><td class="label">TMT Pegawai</td><td class="separator">:</td><td class="value">{{ optional($drhData->tmt)->format('d F Y') ?? '-' }}</td></tr>
                </table>
            </div>

            <div class="section-container">
                <div class="section-header"><span>II. Data Pasangan</span></div>
                @php $pasangan = $drhData->data_pasangan ?? []; @endphp
                <table class="field-grid">
                    <tr><td class="label">Nama Pasangan</td><td class="separator">:</td><td class="value">{{ $pasangan['nama'] ?? '-' }}</td></tr>
                    <tr><td class="label">NIK Pasangan</td><td class="separator">:</td><td class="value">{{ $pasangan['nik'] ?? '-' }}</td></tr>
                    <tr><td class="label">Status Pasangan</td><td class="separator">:</td><td class="value">{{ $pasangan['status'] ?? '-' }}</td></tr>
                    <tr><td class="label">Tempat Lahir</td><td class="separator">:</td><td class="value">{{ $pasangan['tempat_lahir'] ?? '-' }}</td></tr>
                    <tr><td class="label">Tanggal Lahir</td><td class="separator">:</td><td class="value">{{ !empty($pasangan['tanggal_lahir']) ? \Carbon\Carbon::parse($pasangan['tanggal_lahir'])->format('d F Y') : '-' }}</td></tr>
                    <tr><td class="label">Pekerjaan</td><td class="separator">:</td><td class="value">{{ $pasangan['pekerjaan'] ?? '-' }}</td></tr>
                    <tr><td class="label">Status Hidup</td><td class="separator">:</td><td class="value">{{ $pasangan['status_hidup'] ?? '-' }}</td></tr>
                </table>
            </div>

            <div class="section-container">
                <div class="section-header"><span>IV. Data Anak</span></div>
                @php $anakList = $drhData->data_anak ?? []; @endphp
                @if(is_array($anakList) && count($anakList) > 0)
                    <table class="subtable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>TTL</th>
                                <th>Status</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anakList as $index => $anak)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $anak['nama'] ?? '-' }}</strong></td>
                                    <td>{{ $anak['nik'] ?? '-' }}</td>
                                    <td>{{ $anak['tempat_lahir'] ?? '-' }}, {{ $anak['tanggal_lahir'] ?? '-' }}</td>
                                    <td>{{ $anak['status_anak'] ?? '-' }}</td>
                                    <td>
                                        @if(!empty($anak['file']))
                                            <a href="{{ asset('storage/'.$anak['file']) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="font-size: 10pt; color: #888; margin-left: 10px;">Tidak ada data anak yang tercatat.</p>
                @endif

                <div style="margin-top: 10px; font-size: 10pt;">
                    <strong>Dokumen Akta Kelahiran:</strong>
                    <span class="status-badge {{ $dokumenPendukung['akta_kelahiran'] ? 'bg-success' : 'bg-danger' }}">
                        {{ $dokumenPendukung['akta_kelahiran'] ? 'Tersedia' : 'Belum diunggah' }}
                    </span>
                </div>
            </div>

            <div class="section-container">
                <div class="section-header"><span>V. Orang Tua</span></div>
                <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 280px;">
                        <table class="field-grid" style="font-size: 9pt;">
                            <tr><td class="label">Ayah - Nama</td><td class="separator">:</td><td class="value">{{ $orangTua['ayah']['nama'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ayah - Tempat Lahir</td><td class="separator">:</td><td class="value">{{ $orangTua['ayah']['tempat_lahir'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ayah - Tanggal Lahir</td><td class="separator">:</td><td class="value">{{ !empty($orangTua['ayah']['tanggal_lahir']) ? \Carbon\Carbon::parse($orangTua['ayah']['tanggal_lahir'])->format('d F Y') : '-' }}</td></tr>
                            <tr><td class="label">Ayah - Status Hidup</td><td class="separator">:</td><td class="value">{{ $orangTua['ayah']['status_hidup'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ayah - Pekerjaan</td><td class="separator">:</td><td class="value">{{ $orangTua['ayah']['pekerjaan'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ayah - Alamat</td><td class="separator">:</td><td class="value">{{ $orangTua['ayah']['alamat'] ?? '-' }}</td></tr>
                        </table>
                    </div>
                    <div style="flex: 1; min-width: 280px;">
                        <table class="field-grid" style="font-size: 9pt;">
                            <tr><td class="label">Ibu - Nama</td><td class="separator">:</td><td class="value">{{ $orangTua['ibu']['nama'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ibu - Tempat Lahir</td><td class="separator">:</td><td class="value">{{ $orangTua['ibu']['tempat_lahir'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ibu - Tanggal Lahir</td><td class="separator">:</td><td class="value">{{ !empty($orangTua['ibu']['tanggal_lahir']) ? \Carbon\Carbon::parse($orangTua['ibu']['tanggal_lahir'])->format('d F Y') : '-' }}</td></tr>
                            <tr><td class="label">Ibu - Status Hidup</td><td class="separator">:</td><td class="value">{{ $orangTua['ibu']['status_hidup'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ibu - Pekerjaan</td><td class="separator">:</td><td class="value">{{ $orangTua['ibu']['pekerjaan'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ibu - Alamat</td><td class="separator">:</td><td class="value">{{ $orangTua['ibu']['alamat'] ?? '-' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="section-container">
                <div class="section-header"><span>VI. Mertua</span></div>
                <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 280px;">
                        <table class="field-grid" style="font-size: 9pt;">
                            <tr><td class="label">Ayah Mertua - Nama</td><td class="separator">:</td><td class="value">{{ $mertua['ayah']['nama'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ayah Mertua - Tempat Lahir</td><td class="separator">:</td><td class="value">{{ $mertua['ayah']['tempat_lahir'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ayah Mertua - Tanggal Lahir</td><td class="separator">:</td><td class="value">{{ !empty($mertua['ayah']['tanggal_lahir']) ? \Carbon\Carbon::parse($mertua['ayah']['tanggal_lahir'])->format('d F Y') : '-' }}</td></tr>
                            <tr><td class="label">Ayah Mertua - Status Hidup</td><td class="separator">:</td><td class="value">{{ $mertua['ayah']['status_hidup'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ayah Mertua - Pekerjaan</td><td class="separator">:</td><td class="value">{{ $mertua['ayah']['pekerjaan'] ?? '-' }}</td></tr>
                        </table>
                    </div>
                    <div style="flex: 1; min-width: 280px;">
                        <table class="field-grid" style="font-size: 9pt;">
                            <tr><td class="label">Ibu Mertua - Nama</td><td class="separator">:</td><td class="value">{{ $mertua['ibu']['nama'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ibu Mertua - Tempat Lahir</td><td class="separator">:</td><td class="value">{{ $mertua['ibu']['tempat_lahir'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ibu Mertua - Tanggal Lahir</td><td class="separator">:</td><td class="value">{{ !empty($mertua['ibu']['tanggal_lahir']) ? \Carbon\Carbon::parse($mertua['ibu']['tanggal_lahir'])->format('d F Y') : '-' }}</td></tr>
                            <tr><td class="label">Ibu Mertua - Status Hidup</td><td class="separator">:</td><td class="value">{{ $mertua['ibu']['status_hidup'] ?? '-' }}</td></tr>
                            <tr><td class="label">Ibu Mertua - Pekerjaan</td><td class="separator">:</td><td class="value">{{ $mertua['ibu']['pekerjaan'] ?? '-' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="section-container">
                <div class="section-header"><span>VII. Riwayat Pendidikan</span></div>
                @if(is_array($riwayatPendidikan) && count($riwayatPendidikan) > 0)
                    <table class="subtable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenjang</th>
                                <th>Nama Sekolah / Perguruan Tinggi</th>
                                <th>Tahun Masuk</th>
                                <th>Tahun Lulus</th>
                                <th>No. Ijazah</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatPendidikan as $index => $pendidikan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pendidikan['jenjang'] ?? '-' }}</td>
                                    <td>{{ $pendidikan['nama_sekolah'] ?? '-' }}</td>
                                    <td>{{ $pendidikan['tahun_masuk'] ?? '-' }}</td>
                                    <td>{{ $pendidikan['tahun_lulus'] ?? '-' }}</td>
                                    <td>{{ $pendidikan['nomor_ijazah'] ?? '-' }}</td>
                                    <td>
                                        @if(!empty($pendidikan['file']))
                                            <a href="{{ asset('storage/'.$pendidikan['file']) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="font-size: 10pt; color: #888; margin-left: 10px;">Tidak ada riwayat pendidikan yang tercatat.</p>
                @endif

                <div style="margin-top: 10px; font-size: 10pt;">
                    <strong>Dokumen Ijazah:</strong>
                    <span class="status-badge {{ $dokumenPendukung['ijazah'] ? 'bg-success' : 'bg-danger' }}">
                        {{ $dokumenPendukung['ijazah'] ? 'Tersedia' : 'Belum diunggah' }}
                    </span>
                </div>
            </div>

            <div class="section-container">
                <div class="section-header"><span>VIII. Riwayat Diklat</span></div>
                @if(is_array($riwayatDiklat) && count($riwayatDiklat) > 0)
                    <table class="subtable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Diklat</th>
                                <th>Penyelenggara</th>
                                <th>Tahun</th>
                                <th>No. Sertifikat</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatDiklat as $index => $diklat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $diklat['nama'] ?? '-' }}</td>
                                    <td>{{ $diklat['penyelenggara'] ?? '-' }}</td>
                                    <td>{{ $diklat['tahun'] ?? '-' }}</td>
                                    <td>{{ $diklat['nomor_sertifikat'] ?? '-' }}</td>
                                    <td>
                                        @if(!empty($diklat['file']))
                                            <a href="{{ asset('storage/'.$diklat['file']) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="font-size: 10pt; color: #888; margin-left: 10px;">Tidak ada riwayat diklat yang tercatat.</p>
                @endif
            </div>

            <div class="section-container">
                <div class="section-header"><span>IX. Riwayat Jabatan</span></div>
                @if(is_array($riwayatJabatan) && count($riwayatJabatan) > 0)
                    <table class="subtable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jabatan</th>
                                <th>Unit Kerja</th>
                                <th>Golongan</th>
                                <th>TMT</th>
                                <th>No. SK</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatJabatan as $index => $jabatan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $jabatan['jabatan'] ?? '-' }}</td>
                                    <td>{{ $jabatan['unit_kerja'] ?? '-' }}</td>
                                    <td>{{ $jabatan['golongan'] ?? '-' }}</td>
                                    <td>{{ optional($jabatan['tmt'] ? \Carbon\Carbon::parse($jabatan['tmt']) : null)->format('d F Y') ?? ($jabatan['tmt'] ?? '-') }}</td>
                                    <td>{{ $jabatan['no_sk'] ?? '-' }}</td>
                                    <td>
                                        @if(!empty($jabatan['file']))
                                            <a href="{{ asset('storage/'.$jabatan['file']) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="font-size: 10pt; color: #888; margin-left: 10px;">Tidak ada riwayat jabatan yang tercatat.</p>
                @endif
            </div>

            <div class="section-container">
                <div class="section-header"><span>X. Riwayat Penghargaan</span></div>
                @if(is_array($riwayatPenghargaan) && count($riwayatPenghargaan) > 0)
                    <table class="subtable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Penghargaan</th>
                                <th>Instansi</th>
                                <th>Tahun</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatPenghargaan as $index => $award)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $award['nama'] ?? '-' }}</td>
                                    <td>{{ $award['instansi'] ?? '-' }}</td>
                                    <td>{{ $award['tahun'] ?? '-' }}</td>
                                    <td>
                                        @if(!empty($award['file']))
                                            <a href="{{ asset('storage/'.$award['file']) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="font-size: 10pt; color: #888; margin-left: 10px;">Tidak ada riwayat penghargaan yang tercatat.</p>
                @endif
            </div>

            <div class="section-container">
                <div class="section-header"><span>XI. Riwayat Sertifikasi</span></div>
                @if(is_array($riwayatSertifikasi) && count($riwayatSertifikasi) > 0)
                    <table class="subtable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Sertifikasi</th>
                                <th>Lembaga</th>
                                <th>Tahun</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatSertifikasi as $index => $sertifikasi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $sertifikasi['nama'] ?? '-' }}</td>
                                    <td>{{ $sertifikasi['lembaga'] ?? '-' }}</td>
                                    <td>{{ $sertifikasi['tahun'] ?? '-' }}</td>
                                    <td>
                                        @if(!empty($sertifikasi['file']))
                                            <a href="{{ asset('storage/'.$sertifikasi['file']) }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat</a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="font-size: 10pt; color: #888; margin-left: 10px;">Tidak ada riwayat sertifikasi yang tercatat.</p>
                @endif
            </div>

            <div class="note-footer">
                Dokumen ini dihasilkan secara otomatis oleh Sistem Informasi Kepegawaian DINAS KOMINFO Kota Bengkulu pada {{ date('d/m/Y H:i') }}.
            </div>
        @endif
    </div>
</body>
</html>