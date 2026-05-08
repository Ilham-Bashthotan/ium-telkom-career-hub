/**
 * nav.js — User Portal
 * Inject navbar dan footer ke semua halaman user secara dinamis.
 */

function renderUserNav(activePage) {
  const pages = [
    { id: 'home', label: 'Beranda', href: 'index.html', icon: 'home' },
    { id: 'lowongan', label: 'Lowongan', href: 'lowongan.html', guard: true, icon: 'briefcase' },
    { id: 'mitra', label: 'Mitra Industri', href: 'mitra.html', icon: 'building-2' },
  ];

  if (isLoggedIn()) {
    pages.push({ id: 'profil', label: 'Profil Saya', href: 'profil.html', icon: 'user' });
  }

  const links = pages.map(p => {
    const cls = p.id === activePage ? 'nav-link active' : 'nav-link';
    const guard = p.guard ? `onclick="return guardNav(event,'${p.href}')"` : '';
    const icon = p.icon ? `<i data-lucide="${p.icon}" style="width:16px;height:16px;margin-right:8px"></i>` : '';
    return `<a class="${cls}" href="${p.href}" ${guard} style="display:flex;align-items:center">${icon}${p.label}</a>`;
  }).join('\n      ');

  const logoutBtn = isLoggedIn()
    ? `<div class="nav-link" onclick="logoutUser()" style="cursor:pointer;display:flex;align-items:center;color:var(--primary)"><i data-lucide="log-out" style="width:16px;height:16px;margin-right:8px"></i>Keluar</div>`
    : `<a class="btn btn-primary" href="login.html" style="display:flex;align-items:center;padding: 0.5rem 1.25rem"><i data-lucide="log-in" style="width:16px;height:16px;margin-right:8px"></i>Masuk</a>`;

  const navPlaceholder = document.getElementById('navbar-placeholder');
  if (navPlaceholder) {
    navPlaceholder.innerHTML = `
      <div class="navbar">
        <div class="navbar-brand">
          <div style="background:var(--primary);color:white;width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:900">T</div>
          <span>Telkom Career Hub</span>
        </div>
        <div class="navbar-nav">
          ${links}
          <div style="width:1px;height:24px;background:var(--line);margin:0 0.5rem"></div>
          ${logoutBtn}
        </div>
      </div>
      
      <!-- Login Required Modal -->
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
            <p style="color:var(--muted);font-size:0.875rem;line-height:1.6">Silakan masuk ke akun Anda atau daftar baru untuk mendapatkan akses penuh ke fitur lowongan dan profil.</p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-block" onclick="closeAuthModal()">Nanti Saja</button>
            <a href="login.html" class="btn btn-primary btn-block">Masuk / Daftar</a>
          </div>
        </div>
      </div>`;
  }
}

function renderUserFooter() {
  const el = document.getElementById('footer-placeholder');
  if (!el) return;
  el.innerHTML = `
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
            <li><a href="index.html">Beranda</a></li>
            <li><a href="lowongan.html">Lowongan Kerja</a></li>
            <li><a href="mitra.html">Mitra Industri</a></li>
            <li><a href="#">Tentang Kami</a></li>
          </ul>
        </div>
        <div class="footer-map-section">
          <div class="footer-col-title">Lokasi Kampus</div>
          <div style="border-radius:12px; overflow:hidden; border:1px solid #334155; height:180px">
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.558356134375!2d107.628469314773!3d-6.943261994983584!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e860959074d7%3A0xc3b839600e16807e!2sSMK%20Telkom%20Bandung!5e0!3m2!1sid!2sid!4v1651756543210!5m2!1sid!2sid" 
              width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
        </div>
      </div>
      <div class="footer-copyright">Copyright &copy; 2026 SMK Telkom Bandung. Made with &hearts; for students.</div>
    </footer>`;
}

// ---- Auth helpers ----
function isLoggedIn() {
  return !!sessionStorage.getItem('userLoggedIn');
}

function logoutUser() {
  sessionStorage.removeItem('userLoggedIn');
  window.location.href = 'index.html';
}

function guardNav(event, url, element) {
  if (!isLoggedIn()) {
    if (event) event.preventDefault();
    const modal = document.getElementById('modal-auth-required');
    if (modal) modal.classList.add('active');
    return false;
  }
  if (url) {
    const el = element || (event ? event.currentTarget : null);
    const isAnchor = el && el.tagName === 'A';
    if (!isAnchor) {
      window.location.href = url;
      return false;
    }
  }
  return true;
}

function closeAuthModal() {
  document.getElementById('modal-auth-required').classList.remove('active');
}

// Inject Lucide
(function() {
  const script = document.createElement('script');
  script.src = 'https://unpkg.com/lucide@latest';
  script.onload = () => {
    lucide.createIcons();
    const observer = new MutationObserver(() => lucide.createIcons());
    observer.observe(document.body, { childList: true, subtree: true });
  };
  document.head.appendChild(script);
})();
