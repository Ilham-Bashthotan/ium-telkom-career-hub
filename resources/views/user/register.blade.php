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
        background: var(--surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--line);
    }
    .reg-step { display: none; }
    .reg-step.active { display: block; animation: fadeIn 0.3s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateX(10px); } to { opacity: 1; transform: translateX(0); } }
    
    .step-indicator { display: flex; justify-content: center; gap: 1rem; margin-bottom: 2.5rem; }
    .step-dot { width: 40px; height: 8px; border-radius: 4px; background: var(--line); transition: all 0.3s ease; }
    .step-dot.active { background: var(--primary); width: 60px; }
  </style>
</head>
<body>
  
  <div class="reg-card">
    <div style="text-align: center; margin-bottom: 2rem;">
      <h1 style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.025em; margin-bottom: 0.5rem;">Daftar Akun</h1>
      <p id="step-title" style="color: var(--muted); font-size: 0.875rem;">Lengkapi data diri Anda (Langkah 1/3)</p>
    </div>



    <div class="step-indicator">
      <div class="step-dot active" id="dot-1"></div>
      <div class="step-dot" id="dot-2"></div>
      <div class="step-dot" id="dot-3"></div>
    </div>

    <form id="reg-form" action="{{ route('register.post') }}" method="POST">
      @csrf
      <!-- Step 1: Data Utama -->
      <div class="reg-step active" id="step-1">
        <div style="margin-bottom: 1.25rem;">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="nama_lengkap" class="form-input" placeholder="Nama lengkap sesuai ijazah" required value="{{ old('nama_lengkap') }}">
        </div>
        <div style="margin-bottom: 1.25rem;">
          <label class="form-label">Email Pribadi</label>
          <input type="email" name="email" class="form-input" placeholder="email@example.com" required value="{{ old('email') }}">
        </div>
        <div style="margin-bottom: 1.25rem;">
          <label class="form-label">No. HP / WhatsApp</label>
          <input type="text" name="no_hp" class="form-input" placeholder="08xxxxxxxxxx" required value="{{ old('no_hp') }}">
        </div>
      </div>

      <!-- Step 2: Status Alumni -->
      <div class="reg-step" id="step-2">
        <div style="margin-bottom: 1.25rem;">
          <label class="form-label">Alumni SMK Telkom Bandung?</label>
          <select name="is_alumni" class="form-select">
            <option value="1" {{ old('is_alumni') == '1' ? 'selected' : '' }}>Ya, Alumni</option>
            <option value="0" {{ old('is_alumni') == '0' ? 'selected' : '' }}>Bukan Alumni (Umum/Siswa Aktif)</option>
          </select>
        </div>
        <div style="margin-bottom: 1.25rem;">
          <label class="form-label">Status Pekerjaan Saat Ini</label>
          <select name="status_pekerjaan" class="form-select">
            <option value="belum_bekerja" {{ old('status_pekerjaan') == 'belum_bekerja' ? 'selected' : '' }}>Belum Bekerja / Mencari Kerja</option>
            <option value="sedang_bekerja" {{ old('status_pekerjaan') == 'sedang_bekerja' ? 'selected' : '' }}>Sudah Bekerja</option>
            <option value="wirausaha" {{ old('status_pekerjaan') == 'wirausaha' ? 'selected' : '' }}>Wirausaha</option>
          </select>
        </div>
        <div style="margin-bottom: 1.25rem;">
          <label class="form-label">Tempat Kerja / Instansi</label>
          <input type="text" name="tempat_kerja" class="form-input" placeholder="Contoh: PT Telkom Indonesia" value="{{ old('tempat_kerja') }}">
        </div>
      </div>

      <!-- Step 3: Akun Login -->
      <div class="reg-step" id="step-3">
        <div style="margin-bottom: 1.25rem;">
          <label class="form-label">Buat Password</label>
          <div style="position: relative;">
            <input type="password" name="password" id="reg-password" class="form-input" style="padding-right: 3rem;" placeholder="Minimal 8 karakter" required>
            <button type="button" onclick="togglePasswordVisibility('reg-password', 'eye-reg')" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); display: flex; align-items: center; padding: 0;">
                <i data-lucide="eye" id="eye-reg" style="width: 18px; height: 18px"></i>
            </button>
          </div>
        </div>
        <div style="margin-bottom: 1.5rem;">
          <label class="form-label">Konfirmasi Password</label>
          <div style="position: relative;">
            <input type="password" name="password_confirmation" id="reg-password-confirm" class="form-input" style="padding-right: 3rem;" placeholder="Ulangi password" required>
            <button type="button" onclick="togglePasswordVisibility('reg-password-confirm', 'eye-confirm')" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); display: flex; align-items: center; padding: 0;">
                <i data-lucide="eye" id="eye-confirm" style="width: 18px; height: 18px"></i>
            </button>
          </div>
        </div>
        <p style="font-size: 0.75rem; color: var(--muted); line-height: 1.5;">
          Dengan mendaftar, Anda menyetujui <a href="#" style="color: var(--primary); font-weight: 600;">Syarat & Ketentuan</a> serta <a href="#" style="color: var(--primary); font-weight: 600;">Kebijakan Privasi</a> Telkom Career Hub.
        </p>
      </div>
      
      <div style="display:flex; gap:1rem; margin-top: 2.5rem;">
        <button type="button" id="btn-prev" class="btn" style="display:none; flex:1" onclick="changeStep(-1)">Kembali</button>
        <button type="button" id="btn-next" class="btn btn-primary" style="flex:2; padding: 0.875rem;" onclick="changeStep(1)">Lanjutkan</button>
      </div>
    </form>

    <div style="text-align:center; margin-top: 2rem; font-size: 0.875rem; color: var(--muted);">
      Sudah punya akun? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700;">Masuk di sini</a>
    </div>
  </div>

  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    lucide.createIcons();
    let currentStep = 1;
    const titles = [
      "Lengkapi data diri Anda (Langkah 1/3)",
      "Status Alumni & Pekerjaan (Langkah 2/3)",
      "Buat Akun Keamanan (Langkah 3/3)"
    ];

    async function changeStep(dir) {
      if (dir === -1) {
        moveStep(-1);
        return;
      }

      // FE Basic Validation
      const currentStepEl = document.getElementById('step-' + currentStep);
      const requiredInputs = currentStepEl.querySelectorAll('[required]');
      let feValid = true;
      
      clearErrors();

      requiredInputs.forEach(input => {
        if (!input.value.trim()) {
            showError(input, 'Field ini wajib diisi');
            feValid = false;
        }
      });

      if (!feValid) return;

      // BE Validation via AJAX
      const formData = new FormData(document.getElementById('reg-form'));
      formData.append('step', currentStep);

      // Disable button during loading
      const btnNext = document.getElementById('btn-next');
      const originalText = btnNext.textContent;
      btnNext.disabled = true;
      btnNext.textContent = 'Memvalidasi...';

      try {
        const response = await fetch('{{ route("register.validate") }}', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          },
          body: formData
        });

        const result = await response.json();

        if (!response.ok) {
          if (result.errors) {
            Object.keys(result.errors).forEach(key => {
              const input = document.querySelector(`[name="${key}"]`);
              if (input) showError(input, result.errors[key][0]);
            });
          }
          btnNext.disabled = false;
          btnNext.textContent = originalText;
          return;
        }

        // If step 3 and valid, submit final form
        if (currentStep === 3) {
          document.getElementById('reg-form').submit();
          return;
        }

        // If valid, move to next step
        moveStep(1);
      } catch (error) {
        console.error('Validation error:', error);
        alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
      } finally {
        btnNext.disabled = false;
        btnNext.textContent = originalText;
      }
    }

    function moveStep(dir) {
      // Hide current
      document.getElementById('step-' + currentStep).classList.remove('active');
      document.getElementById('dot-' + currentStep).classList.remove('active');

      currentStep += dir;

      // Show new
      document.getElementById('step-' + currentStep).classList.add('active');
      document.getElementById('dot-' + currentStep).classList.add('active');
      document.getElementById('step-title').textContent = titles[currentStep - 1];

      // Update buttons
      document.getElementById('btn-prev').style.display = currentStep > 1 ? 'block' : 'none';
      document.getElementById('btn-next').textContent = currentStep === 3 ? 'Daftar Sekarang' : 'Lanjutkan';
    }

    function showError(input, message) {
      input.style.borderColor = 'var(--primary)';
      const errorEl = document.createElement('div');
      errorEl.className = 'error-msg';
      errorEl.style.color = 'var(--primary)';
      errorEl.style.fontSize = '0.75rem';
      errorEl.style.marginTop = '0.25rem';
      errorEl.style.fontWeight = '500';
      errorEl.textContent = message;
      input.parentNode.appendChild(errorEl);
    }

    function clearErrors() {
      document.querySelectorAll('.error-msg').forEach(el => el.remove());
      document.querySelectorAll('.form-input, .form-select').forEach(el => {
        el.style.borderColor = 'var(--line)';
      });
    }

    function togglePasswordVisibility(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      
      if (input.type === 'password') {
        input.type = 'text';
        icon.setAttribute('data-lucide', 'eye-off');
      } else {
        input.type = 'password';
        icon.setAttribute('data-lucide', 'eye');
      }
      lucide.createIcons();
    }
  </script>
</body>
</html>
