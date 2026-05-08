/**
 * nav.js — Admin Panel
 * Inject sidebar ke semua halaman admin secara dinamis.
 * Penggunaan: <script src="nav.js"></script>
 *             kemudian panggil: renderAdminSidebar('dashboard')
 */

function renderAdminSidebar(activePage) {
  const sections = [
    {
      label: 'Overview', items: [
        { id: 'dashboard', label: 'Dashboard', href: 'dashboard.html', icon: 'layout-dashboard' },
      ]
    },
    {
      label: 'Konten', items: [
        { id: 'lowongan', label: 'Lowongan Kerja', href: 'lowongan.html', icon: 'briefcase' },
        { id: 'crawl', label: 'Validasi Crawling', href: 'crawl.html', icon: 'database' },
        { id: 'mitra', label: 'Mitra Industri', href: 'mitra.html', icon: 'building-2' },
        { id: 'ppdb', label: 'Info PPDB', href: 'ppdb.html', icon: 'info' },
      ]
    },
    {
      label: 'Pengguna', items: [
        { id: 'users', label: 'Data User', href: 'users.html', icon: 'users' },
      ]
    },
    {
      label: 'Portal User', items: [
        { id: 'portal', label: 'Lihat Sisi User', href: '../user/home.html', icon: 'external-link' },
      ]
    },
    {
      label: 'Akun', items: [
        { id: 'logout', label: 'Logout', href: '#', onclick: 'adminLogout()', icon: 'log-out' },
      ]
    },
  ];

  let navHtml = '';
  sections.forEach(section => {
    navHtml += `<div class="nav-label">${section.label}</div>`;
    section.items.forEach(item => {
      const cls = item.id === activePage ? 'nav-item active' : 'nav-item';
      const icon = item.icon ? `<i data-lucide="${item.icon}" style="width:14px;height:14px;margin-right:8px"></i>` : `<div class="nav-dot"></div>`;
      
      if (item.onclick) {
        navHtml += `<div class="${cls}" onclick="${item.onclick}" style="cursor:pointer">${icon}<span>${item.label}</span></div>`;
      } else {
        navHtml += `<a href="${item.href}" class="${cls}" style="text-decoration:none; color:inherit; display:flex; align-items:center;">${icon}${item.label}</a>`;
      }
    });
  });

  document.getElementById('sidebar-placeholder').innerHTML = `
    <div class="sidebar">
      <div class="sidebar-logo">
        <div class="logo-icon" style="border-radius:8px;width:34px;height:34px;font-size:11px">TCH</div>
        <div>
          <div class="logo-text">Career Hub</div>
          <div class="logo-sub">Admin Panel</div>
        </div>
      </div>
      <div class="nav-section">${navHtml}</div>
      <div class="sidebar-footer">
        <div class="user-chip">
          <div class="avatar">AD</div>
          <div class="user-info"><p>Admin</p><span>admin@smktelkom.sch.id</span></div>
        </div>
      </div>
    </div>`;
}

function renderAdminTopbar(title, showCrawlBadge) {
  const badge = showCrawlBadge
    ? `<span class="badge" onclick="window.location.href='crawl.html'" style="cursor:pointer; display:flex; align-items:center; gap:4px">
        <i data-lucide="loader" style="width:12px;height:12px"></i> 5 Crawl Pending
       </span>`
    : '';
  document.getElementById('topbar-placeholder').innerHTML = `
    <div class="topbar">
      <div class="topbar-title">${title}</div>
      <div class="topbar-right">
        ${badge}
        <span class="annotation" style="font-size:10px;border-style:solid">Senin, 05 Mei 2026</span>
        <div class="avatar" style="width:32px;height:32px;font-size:11px" title="Admin — admin@smktelkom.sch.id">AD</div>
      </div>
    </div>`;
}

function adminLogout() {
  sessionStorage.removeItem('adminLoggedIn');
  window.location.href = '../index.html';
}

// Inject Lucide
(function() {
  const script = document.createElement('script');
  script.src = 'https://unpkg.com/lucide@latest';
  script.onload = () => {
    lucide.createIcons();
    // Observe DOM changes to re-init icons if needed
    const observer = new MutationObserver(() => lucide.createIcons());
    observer.observe(document.body, { childList: true, subtree: true });
  };
  document.head.appendChild(script);
})();
