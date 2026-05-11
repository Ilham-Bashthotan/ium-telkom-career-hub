@props([
    'type' => 'delete', // 'delete' or 'logout'
    'id' => null,
    'title' => null,
    'message' => null,
    'icon' => null,
    'confirmText' => null,
    'action' => null
])

@php
    // Default configurations based on type
    if ($type === 'logout') {
        $id = $id ?? 'modal-logout-confirm';
        $title = $title ?? 'Konfirmasi Keluar';
        $message = $message ?? 'Anda akan keluar dari sesi akun saat ini dan perlu login kembali untuk mengakses fitur tertentu.';
        $icon = $icon ?? 'log-out';
        $confirmText = $confirmText ?? 'Ya, Keluar';
        $action = $action ?? route('logout');
        $closeFn = 'closeLogoutModal';
        $confirmFn = 'confirmLogout';
    } else {
        $id = $id ?? 'modal-delete-confirm';
        $title = $title ?? 'Konfirmasi Hapus';
        $message = $message ?? 'Tindakan ini tidak dapat dibatalkan. Data yang dihapus akan hilang secara permanen dari sistem.';
        $icon = $icon ?? 'trash-2';
        $confirmText = $confirmText ?? 'Ya, Hapus';
        $closeFn = 'closeDeleteModal';
        $confirmFn = 'confirmDelete';
    }
@endphp

<div class="modal-overlay" id="{{ $id }}">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title">{{ $title }}</div>
            <div class="modal-close" onclick="{{ $closeFn }}()" style="border:none;background:none;font-size:1.25rem;cursor:pointer">✕</div>
        </div>
        <div class="modal-body" style="text-align:center">
            <div style="background:#fee2e2;color:#ef4444;width:64px;height:64px;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem">
                <i data-lucide="{{ $icon }}" style="width:32px;height:32px"></i>
            </div>
            <h3 style="margin-bottom:0.75rem;font-size:1.25rem">
                {{ $type === 'logout' ? 'Apakah Anda yakin?' : 'Hapus Data Ini?' }}
            </h3>
            <p style="color:var(--muted);font-size:0.875rem;line-height:1.6">{{ $message }}</p>
        </div>
        <div class="modal-footer" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; padding: 1.5rem; background: var(--bg);">
            <button class="btn" style="width: 100%" onclick="{{ $closeFn }}()">Batal</button>
            <form @if($type === 'delete') id="form-delete-confirm" @endif action="{{ $action }}" method="POST" style="margin: 0;">
                @csrf
                @if($type === 'delete') @method('DELETE') @endif
                <button type="submit" class="btn btn-primary" style="width: 100%; background:#ef4444; border-color:#ef4444">{{ $confirmText }}</button>
            </form>
        </div>
    </div>
</div>

<script>
    @if($type === 'logout')
        function confirmLogout(event) {
            if (event) event.preventDefault();
            const modal = document.getElementById('{{ $id }}');
            if (modal) modal.classList.add('active');
            return false;
        }

        function closeLogoutModal() {
            const modal = document.getElementById('{{ $id }}');
            if (modal) modal.classList.remove('active');
        }
    @else
        function confirmDelete(event, actionUrl) {
            if (event) event.preventDefault();
            const modal = document.getElementById('{{ $id }}');
            const form = document.getElementById('form-delete-confirm');
            if (modal && form) {
                form.action = actionUrl;
                modal.classList.add('active');
            }
            return false;
        }

        function closeDeleteModal() {
            const modal = document.getElementById('{{ $id }}');
            if (modal) modal.classList.remove('active');
        }
    @endif
</script>
