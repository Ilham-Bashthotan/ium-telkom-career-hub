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
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, rgba(238, 45, 36, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(37, 99, 235, 0.1) 0px, transparent 50%);
            margin: 0;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: -1;
        }
        .login-card {
            max-width: 440px;
            width: 100%;
            padding: 3.5rem 3rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            background: white;
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
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
                <div style="position: relative;">
                    <input type="password" id="password" name="password" class="form-input" style="width: 100%; padding: 0.875rem 3rem 0.875rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);" placeholder="••••••••" required>
                    <button type="button" onclick="togglePassword()" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); display: flex; align-items: center; padding: 0;">
                        <i data-lucide="eye" id="eye-icon" style="width: 18px; height: 18px"></i>
                    </button>
                </div>
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
    <script>
        lucide.createIcons();

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>
