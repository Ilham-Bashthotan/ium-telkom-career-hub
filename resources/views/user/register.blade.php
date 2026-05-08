<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Telkom Career Hub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: radial-gradient(circle at bottom left, var(--primary-light), transparent), var(--bg);
            padding: 2rem;
        }
        .reg-card {
            max-width: 500px;
            width: 100%;
            padding: 3rem;
            box-shadow: var(--shadow-lg);
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--line);
        }
    </style>
</head>
<body>
    <div class="reg-card">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.025em; margin-bottom: 0.5rem;">Daftar Akun</h1>
            <p style="color: var(--muted); font-size: 0.875rem;">Lengkapi data diri Anda untuk memulai</p>
        </div>

        @if($errors->any())
            <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; font-size: 0.875rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.25rem;">
                <label class="form-label" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 0.5rem;">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-input" style="width: 100%; padding: 0.875rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);" placeholder="Nama sesuai ijazah" required value="{{ old('nama_lengkap') }}">
            </div>
            <div style="margin-bottom: 1.25rem;">
                <label class="form-label" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 0.5rem;">Email Pribadi</label>
                <input type="email" name="email" class="form-input" style="width: 100%; padding: 0.875rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);" placeholder="email@example.com" required value="{{ old('email') }}">
            </div>
            <div style="margin-bottom: 1.25rem;">
                <label class="form-label" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 0.5rem;">Password</label>
                <input type="password" name="password" class="form-input" style="width: 100%; padding: 0.875rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);" placeholder="Minimal 8 karakter" required>
            </div>
            <div style="margin-bottom: 1.25rem;">
                <label class="form-label" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 0.5rem;">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-input" style="width: 100%; padding: 0.875rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);" placeholder="Ulangi password" required>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_alumni" value="1">
                    <span style="font-size: 0.875rem; color: var(--text);">Saya adalah alumni SMK Telkom Bandung</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="padding: 0.875rem; width: 100%;">Daftar Sekarang</button>
        </form>

        <div style="text-align: center; margin-top: 2rem; font-size: 0.875rem; color: var(--muted);">
            Sudah punya akun? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700;">Masuk di sini</a>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons();</script>
</body>
</html>
