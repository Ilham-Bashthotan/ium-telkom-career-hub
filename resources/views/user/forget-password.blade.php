<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password — Telkom Career Hub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: radial-gradient(circle at top right, var(--primary-light), transparent), var(--bg);
        }
        .login-card {
            max-width: 440px;
            width: 100%;
            padding: 3rem;
            box-shadow: var(--shadow-lg);
            background: white;
            border-radius: var(--radius-lg);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <div style="background: var(--primary); color: white; width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 900; margin: 0 auto 1.5rem;">T</div>
            <h1 style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.025em;">Lupa Password</h1>
            <p style="color: var(--muted); font-size: 0.875rem; margin-top: 0.5rem;">Masukkan email Anda untuk menerima link reset password</p>
        </div>

        @if (session('success'))
            <div style="background: #ecfdf5; color: #047857; padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; font-size: 0.875rem;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background: #fef2f2; color: #b91c1c; padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; font-size: 0.875rem;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div style="margin-bottom: 2rem;">
                <label class="form-label" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 0.5rem;">Email</label>
                <input type="email" name="email" class="form-input" style="width: 100%; padding: 0.875rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);" placeholder="name@example.com" required value="{{ old('email') }}">
            </div>
            
            <button type="submit" class="btn btn-primary btn-block" style="padding: 0.875rem; width: 100%;">Kirim Link Reset Password</button>
        </form>

        <div style="text-align: center; margin-top: 2rem; font-size: 0.875rem; color: var(--muted);">
            Ingat password Anda? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700;">Masuk Sekarang</a>
        </div>
        
        <div style="text-align: center; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--line);">
            <a href="{{ route('home') }}" style="font-size: 0.875rem; color: var(--muted); display: flex; align-items: center; justify-content: center; gap: 0.5rem;"><i data-lucide="arrow-left" style="width: 16px; height: 16px"></i> Kembali ke Beranda</a>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
