@push('styles')
<style>
    .upload-zone {
        border: 2px dashed var(--line);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #fdfdfd;
        min-height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .upload-zone:hover, .upload-zone.drag-over {
        border-color: var(--primary);
        background: #fff5f5;
    }
    .upload-zone i {
        transition: transform 0.2s;
    }
    .upload-zone:hover i {
        transform: translateY(-5px);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('drop-zone');
        const logoInput = document.getElementById('logo-input');
        const uploadContent = document.getElementById('upload-content');
        const previewContainer = document.getElementById('preview-container');
        const logoPreview = document.getElementById('logo-preview');
        const filenameDisplay = document.getElementById('filename-display');
        const removeBtn = document.getElementById('remove-logo');

        if (dropZone) {
            // Drag and drop handlers
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.add('drag-over'), false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.remove('drag-over'), false);
            });

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                logoInput.files = files;
                handleFiles(files);
            }

            logoInput.addEventListener('change', function() {
                handleFiles(this.files);
            });

            function handleFiles(files) {
                if (files.length > 0) {
                    const file = files[0];
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            logoPreview.src = e.target.result;
                            filenameDisplay.textContent = file.name;
                            uploadContent.style.display = 'none';
                            previewContainer.style.display = 'flex';
                        }
                        reader.readAsDataURL(file);
                    }
                }
            }

            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                logoInput.value = '';
                uploadContent.style.display = 'block';
                previewContainer.style.display = 'none';
            });
        }
    });
</script>
@endpush
