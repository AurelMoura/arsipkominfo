<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Arsip Digital Kominfo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #00529C;
            --accent-blue: #003a6e;
            --bg-light: #f4f7fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        /* LEFT SIDE */
        .left-side {
            background: radial-gradient(circle at top left, #0a3d91, #002b5c);
            color: white;
            position: relative;
            overflow: hidden;
        }

        /* GRID BACKGROUND */
        .left-side::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            top: 0;
            left: 0;
        }

        /* GLASS ICON */
        .glass-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        /* BADGE */
        .badge-feature {
            background: rgba(255,255,255,0.1);
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 0.85rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.15);
        }

        /* CARD LOGIN (TIDAK DIUBAH) */
        .card-login {
            border-radius: 24px;
            border: none;
            padding: 50px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
        }

        .form-label { font-size: 0.9rem; color: #444; }

        .form-control {
            border-radius: 12px;
            padding: 14px;
            background: #fdfdfd;
            border: 1.5px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(0, 82, 156, 0.1);
            background: #fff;
        }

        .btn-primary {
            border-radius: 12px;
            padding: 14px;
            background: var(--primary-blue);
            border: none;
            font-weight: 600;
            transition: transform 0.2s;
        }

        .btn-primary:hover {
            background: var(--accent-blue);
            transform: translateY(-2px);
        }

        .btn-light {
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-kominfo {
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
        }

        @media (max-width: 768px) {
            .left-side { display: none !important; }
            .card-login { padding: 30px; width: 90% !important; }
        }
    </style>
</head>

<body>

<div class="container-fluid h-100 p-0">
    <div class="row g-0 h-100">

        <!-- LEFT SIDE (SUDAH DIPERCANTIK) -->
        <div class="col-md-6 left-side d-flex flex-column justify-content-center align-items-center text-center p-5">

            <div class="mb-4">
                <div class="glass-card">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                        <line x1="12" y1="11" x2="12" y2="17"></line>
                        <line x1="9" y1="14" x2="15" y2="14"></line>
                    </svg>
                </div>
            </div>

            <h1 class="fw-bold mb-3 display-6">Sistem Arsip Dokumen</h1>

            <p class="opacity-75 px-lg-5" style="max-width: 500px; font-size: 1.05rem; line-height: 1.7;">
                Platform digital untuk pengelolaan dan pengarsipan dokumen pegawai secara terpusat, aman, dan modern.
            </p>

            <div class="d-flex gap-3 mt-4 flex-wrap justify-content-center">
                <span class="badge-feature">🔒 Keamanan Terjamin</span>
                <span class="badge-feature">⚡ Akses Mudah</span>
                <span class="badge-feature">📊 Manajemen Terpusat</span>
            </div>

        </div>

        <!-- RIGHT SIDE (TIDAK DIUBAH) -->
        <div class="col-md-6 d-flex align-items-center justify-content-center bg-white">
            <div class="card card-login w-75">
                <div class="text-center mb-5">
                    <img src="{{ asset('image/LOGOKOMINFO.png') }}" class="logo-kominfo" width="70" alt="Logo">
                    <h3 class="mt-4 fw-bold text-dark">Selamat Datang</h3>
                    <p class="text-muted">Silakan masuk ke akun Anda</p>
                </div>

                <form action="{{ url('/login') }}" method="POST">
                    @csrf
                    @if(session('error')) 
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <small>{{ session('error') }}</small>
                        </div> 
                    @endif

                    <div id="step1" class="fade-in">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">NIP</label>
                            <input type="number" name="identifier" id="ident" class="form-control" required>
                        </div>
                        <button type="button" onclick="nextStep()" class="btn btn-primary w-100 shadow-sm">
                            Lanjutkan 
                        </button>
                    </div>

                    <div id="step2" style="display:none" class="fade-in">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kata Sandi</label>
                            <input type="password" name="password_input" class="form-control" required>
                        </div>
                        <div class="d-flex gap-3">
                            <button type="button" onclick="prevStep()" class="btn btn-light border w-25 shadow-sm text-muted">
                                ←
                            </button>
                            <button type="submit" class="btn btn-primary w-75 shadow-sm">
                                Masuk ke Sistem
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-5 text-center">
                    <p class="text-muted small">© 2026 Aurel Moura - Dinas Kominfo. All rights reserved.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function nextStep() {
    const identInput = document.getElementById('ident');
    if (identInput.value.trim() !== "") {
        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'block';
    } else {
        identInput.classList.add('is-invalid');
    }
}

function prevStep() {
    document.getElementById('step1').style.display = 'block';
    document.getElementById('step2').style.display = 'none';
}
</script>

</body>
</html>