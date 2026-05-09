<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Telkom Career Hub')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
</head>
<body>
    <div id="user-app" style="display:flex;flex-direction:column;min-height:100vh;width:100%">
        <!-- Navbar -->
        <div class="navbar">
            <div class="navbar-brand">
                <div style="background:var(--primary);color:white;width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:900">T</div>
                <span>Telkom Career Hub</span>
            </div>
            <div class="navbar-nav">
                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}" style="display:flex;align-items:center"><i data-lucide="home" style="width:16px;height:16px;margin-right:8px"></i>Beranda</a>
                
                @auth
                    <a class="nav-link {{ request()->is('user/lowongan*') ? 'active' : '' }}" href="{{ route('user.lowongan.index') }}" style="display:flex;align-items:center"><i data-lucide="briefcase" style="width:16px;height:16px;margin-right:8px"></i>Lowongan</a>
                @else
                    <a class="nav-link {{ request()->is('user/lowongan*') ? 'active' : '' }}" href="{{ route('user.lowongan.index') }}" onclick="return guardNav(event, '{{ route('user.lowongan.index') }}')" style="display:flex;align-items:center"><i data-lucide="briefcase" style="width:16px;height:16px;margin-right:8px"></i>Lowongan</a>
                @endauth

                <a class="nav-link {{ request()->is('user/mitra*') ? 'active' : '' }}" href="{{ route('user.mitra.index') }}" style="display:flex;align-items:center"><i data-lucide="building-2" style="width:16px;height:16px;margin-right:8px"></i>Mitra Industri</a>
                
                <div style="width:1px;height:24px;background:var(--line);margin:0 0.5rem"></div>
                
                @auth
                    <a class="nav-link {{ request()->is('user/profil*') ? 'active' : '' }}" href="{{ route('user.profil.index') }}" style="display:flex;align-items:center"><i data-lucide="user" style="width:16px;height:16px;margin-right:8px"></i>{{ Auth::user()->nama_lengkap }}</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;" onsubmit="return confirmLogout(event)">
                        @csrf
                        <button type="submit" class="nav-link" style="border:none;background:none;cursor:pointer;display:flex;align-items:center;color:var(--primary)"><i data-lucide="log-out" style="width:16px;height:16px;margin-right:8px"></i>Keluar</button>
                    </form>
                @else
                    <a class="btn btn-primary" href="{{ route('login') }}" style="display:flex;align-items:center;padding: 0.5rem 1.25rem"><i data-lucide="log-in" style="width:16px;height:16px;margin-right:8px"></i>Masuk</a>
                @endauth
            </div>
        </div>

        <main class="public-content">
            @yield('content')
        </main>

        <!-- Auth Required Modal -->
        <div class="modal-overlay" id="modal-auth-required">
            <div class="modal-box">
                <div class="modal-header">
                    <div class="modal-title">Akses Terbatas</div>
                    <div class="modal-close" onclick="closeAuthModal()" style="border:none;background:none;font-size:1.25rem;cursor:pointer">✕</div>
                </div>
                <div class="modal-body" style="text-align:center">
                    <div style="background:var(--primary-light);color:var(--primary);width:64px;height:64px;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem">
                        <i data-lucide="lock" style="width:32px;height:32px"></i>
                    </div>
                    <h3 style="margin-bottom:0.75rem;font-size:1.25rem">Login Diperlukan</h3>
                    <p style="color:var(--muted);font-size:0.875rem;line-height:1.6">Silakan masuk ke akun Anda untuk melihat daftar lowongan kerja secara lengkap dan mendapatkan akses ke fitur unggulan lainnya.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-block" style="flex: 1" onclick="closeAuthModal()">Nanti Saja</button>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-block" style="flex: 1">Masuk / Daftar</a>
                </div>
            </div>
        </div>

        <div class="modal-overlay" id="modal-logout-confirm">
            <div class="modal-box">
                <div class="modal-header">
                    <div class="modal-title">Konfirmasi Keluar</div>
                    <div class="modal-close" onclick="closeLogoutModal()" style="border:none;background:none;font-size:1.25rem;cursor:pointer">✕</div>
                </div>
                <div class="modal-body" style="text-align:center">
                    <div style="background:#fee2e2;color:#ef4444;width:64px;height:64px;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem">
                        <i data-lucide="log-out" style="width:32px;height:32px"></i>
                    </div>
                    <h3 style="margin-bottom:0.75rem;font-size:1.25rem">Apakah Anda yakin?</h3>
                    <p style="color:var(--muted);font-size:0.875rem;line-height:1.6">Anda akan keluar dari sesi akun saat ini dan perlu login kembali untuk mengakses fitur tertentu.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-block" style="flex: 1" onclick="closeLogoutModal()">Batal</button>
                    <form action="{{ route('logout') }}" method="POST" style="flex: 1">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block" style="background:#ef4444;border-color:#ef4444">Ya, Keluar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="footer-container">
                <div class="footer-logo-section">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:1.5rem">
                        <div style="background:var(--primary);color:white;width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:900">T</div>
                        <div>
                            <div style="color:white;font-weight:800;font-size:1.125rem;letter-spacing:-0.025em">Telkom Career Hub</div>
                            <div style="font-size:0.75rem;color:var(--secondary)">SMK Telkom Bandung</div>
                        </div>
                    </div>
                    <div style="font-size:0.875rem;color:#94a3b8;line-height:1.8">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:0.5rem"><i data-lucide="map-pin" style="width:16px;height:16px"></i> Jl. Radio Palasari No.1, Bandung</div>
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:0.5rem"><i data-lucide="phone" style="width:16px;height:16px"></i> (022) 7300888</div>
                        <div style="display:flex;align-items:center;gap:10px"><i data-lucide="mail" style="width:16px;height:16px"></i> info@smktelkom.sch.id</div>
                    </div>
                </div>
                <div class="footer-links-section">
                    <div class="footer-col-title">Tautan Cepat</div>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('user.lowongan.index') }}" onclick="return guardNav(event, '{{ route('user.lowongan.index') }}')">Lowongan Kerja</a></li>
                        <li><a href="{{ route('user.mitra.index') }}">Mitra Industri</a></li>
                    </ul>
                </div>
                <div class="footer-map-section">
                    <div class="footer-col-title">Lokasi Kampus</div>
                    <div style="border-radius:12px; overflow:hidden; border:1px solid #334155; height:180px; position:relative; background:#1e293b">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.558356134375!2d107.628469314773!3d-6.943261994983584!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e860959074d7%3A0xc3b839600e16807e!2sSMK%20Telkom%20Bandung!5e0!3m2!1sid!2sid!4v1651756543210!5m2!1sid!2sid" 
                            width="100%" height="100%" style="border:0; position:absolute; top:0; left:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                        <div style="position:absolute; bottom:10px; right:10px;">
                            <a href="https://maps.app.goo.gl/hG2o2R2YvK2x7K5t7" target="_blank" class="btn btn-sm" style="font-size:10px; padding:4px 8px; background:rgba(255,255,255,0.9); border:none; box-shadow:var(--shadow-sm)">Buka di Maps</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">Copyright &copy; 2026 SMK Telkom Bandung. Made with &hearts; for students.</div>
        </footer>

        <!-- WhatsApp Widget -->
        <a href="https://wa.me/6281234567890" target="_blank" style="position: fixed; bottom: 2rem; right: 2rem; width: 60px; height: 60px; background: #25d366; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-lg); z-index: 100; transition: transform 0.2s ease;">
            <i data-lucide="message-circle" style="width: 32px; height: 32px"></i>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // SweetAlert2 Toast configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Show flash messages
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        @if(session('info'))
            Toast.fire({
                icon: 'info',
                title: '{{ session('info') }}'
            });
        @endif

        @if(session('warning'))
            Toast.fire({
                icon: 'warning',
                title: '{{ session('warning') }}'
            });
        @endif

        @if($errors->any())
            Toast.fire({
                icon: 'error',
                title: '{{ $errors->first() }}'
            });
        @endif


        
        // Debounced observer to prevent lag from frequent DOM changes
        let timeout;
        const observer = new MutationObserver(() => {
            clearTimeout(timeout);
            timeout = setTimeout(() => lucide.createIcons(), 100);
        });
        observer.observe(document.body, { childList: true, subtree: true });

        // Auth Guard Helper
        function guardNav(event, url) {
            @guest
                if (event) event.preventDefault();
                const modal = document.getElementById('modal-auth-required');
                if (modal) modal.classList.add('active');
                return false;
            @endguest
            return true;
        }

        function closeAuthModal() {
            const modal = document.getElementById('modal-auth-required');
            if (modal) modal.classList.remove('active');
        }

        function confirmLogout(event) {
            if (event) event.preventDefault();
            const modal = document.getElementById('modal-logout-confirm');
            if (modal) modal.classList.add('active');
            return false;
        }

        function closeLogoutModal() {
            const modal = document.getElementById('modal-logout-confirm');
            if (modal) modal.classList.remove('active');
        }
    </script>
    @yield('scripts')
</body>
</html>
