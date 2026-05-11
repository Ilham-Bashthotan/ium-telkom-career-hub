@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<style>
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
            function checkDeadline() {
                const selectedDate = new Date(inputDeadline.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Reset time to start of today

                if (inputDeadline.value && selectedDate < today) {
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
                    // Date is today or in the future (or empty)
                    radioAktif.disabled = false;
                    radioDraft.disabled = false;
                    
                    radioAktif.parentElement.style.opacity = '1';
                    radioDraft.parentElement.style.opacity = '1';
                    radioAktif.parentElement.style.cursor = 'pointer';
                    radioDraft.parentElement.style.cursor = 'pointer';
                }
            }

            inputDeadline.addEventListener('change', checkDeadline);
            // Initial check
            checkDeadline();
        }
    });
</script>
@endpush
