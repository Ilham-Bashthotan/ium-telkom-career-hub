@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Custom Flatpickr input styles to match form-input theme */
    .flatpickr-input[readonly] {
        background-color: #fff !important;
    }
    .flatpickr-day.selected {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
    }
    .flatpickr-day.selected:hover {
        background: var(--primary-hover) !important;
        border-color: var(--primary-hover) !important;
    }

    .ts-wrapper .ts-control {
        border: 1px solid var(--line) !important;
        border-radius: 8px !important;
        padding: 0.75rem !important;
        font-family: inherit !important;
        font-size: 0.875rem !important;
        min-height: 45px;
        background: #fff !important;
    }
    .ts-wrapper.single .ts-control, .ts-wrapper.single .ts-control input {
        cursor: text;
    }
    .ts-wrapper.single .ts-control::after {
        border-color: var(--muted) transparent transparent transparent !important;
        right: 15px !important;
    }
    .ts-dropdown {
        border-radius: 8px !important;
        box-shadow: var(--shadow-lg) !important;
        border: 1px solid var(--line) !important;
        margin-top: 4px !important;
        padding: 0.5rem !important;
    }
    .ts-dropdown .active {
        background: var(--primary) !important;
        color: #fff !important;
        border-radius: 4px;
    }
    .ts-dropdown .option {
        padding: 0.5rem 0.75rem !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('select-perusahaan')) {
            new TomSelect('#select-perusahaan', {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Cari & Pilih Perusahaan..."
            });
        }

        // Salary Rupiah Formatting
        const inputGaji = document.getElementById('input-gaji');
        if (inputGaji) {
            inputGaji.addEventListener('keyup', function(e) {
                let value = this.value.replace(/[^0-9]/g, '');
                if (value !== "") {
                    this.value = formatRupiah(value, 'Rp ');
                } else {
                    this.value = "";
                }
            });

            // Initial format if value exists
            if (inputGaji.value) {
                let cleanValue = inputGaji.value.replace(/[^0-9]/g, '');
                inputGaji.value = formatRupiah(cleanValue, 'Rp ');
            }
        }

        function formatRupiah(angka, prefix) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }

        // Deadline Date Logic
        const inputDeadline = document.getElementById('tanggal_expired');
        const radioAktif = document.getElementById('status-aktif');
        const radioDraft = document.getElementById('status-draft');
        const radioNonaktif = document.getElementById('status-nonaktif');

        if (inputDeadline) {
            // Initialize Flatpickr to force the 'dd / mm / yyyy' display format while sending Y-m-d to backend
            const fpInstance = flatpickr(inputDeadline, {
                altInput: true,
                altFormat: "d / m / Y",
                dateFormat: "Y-m-d",
                placeholder: "dd / mm / yyyy",
                onChange: function(selectedDates, dateStr, instance) {
                    checkDeadline(dateStr);
                    if (typeof checkFormValidity === 'function') {
                        checkFormValidity();
                    }
                }
            });

            function checkDeadline(dateVal) {
                const val = dateVal || inputDeadline.value;
                if (!val) return;

                const selectedDate = new Date(val);
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Reset time to start of today

                if (selectedDate < today) {
                    // Date is in the past
                    radioNonaktif.checked = true;
                    radioAktif.disabled = true;
                    radioDraft.disabled = true;
                    
                    // Style disabled labels to look muted
                    radioAktif.parentElement.style.opacity = '0.5';
                    radioDraft.parentElement.style.opacity = '0.5';
                    radioAktif.parentElement.style.cursor = 'not-allowed';
                    radioDraft.parentElement.style.cursor = 'not-allowed';
                } else {
                    // Date is today or in the future
                    radioAktif.disabled = false;
                    radioDraft.disabled = false;
                    
                    radioAktif.parentElement.style.opacity = '1';
                    radioDraft.parentElement.style.opacity = '1';
                    radioAktif.parentElement.style.cursor = 'pointer';
                    radioDraft.parentElement.style.cursor = 'pointer';
                }
            }

            // Initial check
            if (inputDeadline.value) {
                checkDeadline(inputDeadline.value);
            }
        }

        // Form Validation & Submit Interception
        const form = document.querySelector('form');
        const submitBtn = form ? form.querySelector('button[type="submit"]') : null;

        if (form && submitBtn) {
            const requiredFields = [
                { el: form.querySelector('input[name="judul"]'), name: "Judul Lowongan" },
                { el: form.querySelector('select[name="perusahaan_id"]'), name: "Perusahaan" },
                { el: form.querySelector('select[name="jurusan_id"]'), name: "Jurusan Terkait" },
                { el: form.querySelector('input[name="lokasi"]'), name: "Lokasi" },
                { el: form.querySelector('select[name="tipe_pekerjaan"]'), name: "Tipe Pekerjaan" },
                { el: form.querySelector('input[name="tanggal_expired"]'), name: "Batas Pendaftaran" },
                { el: form.querySelector('input[name="link_apply"]'), name: "Link Pendaftaran (External)" }
            ];

            const descriptionTextarea = form.querySelector('textarea[name="deskripsi"]');

            // Set the submit button to always look active and premium so it's clickable for validation feedback
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            }

            form.addEventListener('submit', function(e) {
                // Force sync TinyMCE editor content to the underlying textarea
                if (typeof tinymce !== 'undefined') {
                    tinymce.triggerSave();
                }

                let errors = [];

                // 1. Check all standard required fields
                requiredFields.forEach(field => {
                    if (!field.el) return;

                    const val = field.el.value ? field.el.value.trim() : '';

                    if (val === '') {
                        errors.push(field.name);
                    }

                    // If it is a url field, validate URL format
                    if (field.el.type === 'url' && val !== '') {
                        try {
                            new URL(val);
                        } catch (_) {
                            errors.push(`${field.name} (Format URL tidak valid)`);
                        }
                    }
                });

                // 2. Check rich text description content (stripping HTML tags/entities)
                if (descriptionTextarea) {
                    const rawHtml = descriptionTextarea.value || '';
                    const cleanText = rawHtml
                        .replace(/<[^>]*>/g, '')
                        .replace(/&nbsp;/gi, ' ')
                        .replace(/&amp;/gi, '&')
                        .trim();

                    if (cleanText === '') {
                        errors.push("Deskripsi Pekerjaan");
                    }
                } else {
                    errors.push("Deskripsi Pekerjaan");
                }

                // 3. If there are validation errors, block submission and show an elegant SweetAlert2 warning modal
                if (errors.length > 0) {
                    e.preventDefault(); // Stop form submission

                    Swal.fire({
                        icon: 'warning',
                        title: 'Formulir Belum Lengkap',
                        html: `<p style="font-size: 0.95rem; color: var(--muted); margin-bottom: 1rem;">Mohon lengkapi seluruh field wajib berikut sebelum menyimpan lowongan:</p>
                               <ul style="text-align: left; max-width: 320px; margin: 0 auto; padding-left: 1.5rem; font-family: inherit;">
                                   ${errors.map(err => `<li style="margin-bottom: 0.5rem; font-weight: 600; color: #1f2937;">${err} <span style="color: var(--primary)">*</span></li>`).join('')}
                               </ul>`,
                        confirmButtonText: 'Baik, Saya Lengkapi',
                        confirmButtonColor: '#ee2d24',
                        background: '#ffffff',
                        customClass: {
                            popup: 'premium-swal-popup',
                            confirmButton: 'btn btn-primary'
                        }
                    });
                }
            });
        }
    });
</script>
@endpush
