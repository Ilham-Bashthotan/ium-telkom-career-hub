<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Telkom Career Hub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: radial-gradient(circle at top right, var(--primary-light), transparent), var(--bg);
            margin: 0;
        }
        .login-card {
            max-width: 440px;
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
    <div class="login-card">
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <div style="background: var(--primary); color: white; width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 900; margin: 0 auto 1.5rem;">A</div>
            <h1 style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.025em; color: var(--text);">Admin Portal</h1>
            <p style="color: var(--muted); font-size: 0.875rem; margin-top: 0.5rem;">Silakan masuk untuk mengelola sistem</p>
        </div>

        @if($errors->any())
            <div style="background: #fff1f0; border: 1px solid #ffa39e; padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; display: flex; gap: 0.75rem; align-items: flex-start;">
                <i data-lucide="alert-circle" style="width: 18px; height: 18px; color: var(--primary); flex-shrink: 0;"></i>
                <div style="font-size: 0.875rem; color: #cf1322; font-weight: 500;">{{ $errors->first() }}</div>
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 0.5rem;">Email Admin</label>
                <input type="email" name="email" class="form-input" style="width: 100%; padding: 0.875rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);" placeholder="admin@smktelkom.sch.id" required value="{{ old('email') }}">
            </div>
            <div style="margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <label class="form-label" style="font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 0;">Password</label>
                    <a href="#" style="font-size: 0.75rem; color: var(--primary); font-weight: 600;">Lupa password?</a>
                </div>
                <input type="password" name="password" class="form-input" style="width: 100%; padding: 0.875rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block" style="padding: 0.875rem; width: 100%; font-size: 1rem;">
                Masuk Ke Dashboard <i data-lucide="arrow-right" style="width: 18px; height: 18px"></i>
            </button>
        </form>

        <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--line);">
            <a href="{{ route('login') }}" style="font-size: 0.875rem; color: var(--muted); font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <i data-lucide="user" style="width: 16px; height: 16px"></i> Bukan Admin? Masuk sebagai User
            </a>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons();</script>
</body>
</html>
