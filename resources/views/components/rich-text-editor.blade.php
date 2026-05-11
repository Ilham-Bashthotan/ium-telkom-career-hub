@props(['name', 'value' => '', 'placeholder' => ''])

@php
    $id = 'editor-' . Str::random(8);
@endphp

<div class="rich-text-container" style="border: 1px solid var(--line); border-radius: 8px; overflow: hidden; background: #fff;">
    <textarea name="{{ $name }}" id="{{ $id }}-textarea">{!! $value !!}</textarea>
</div>

@once
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
    @endpush
    
    @push('styles')
        <style>
            /* Hide the tinyMCE upgrade promo if it appears */
            .tox-promotion, .tox-statusbar__branding {
                display: none !important;
            }
            .tox-tinymce {
                border: none !important;
            }
        </style>
    @endpush
@endonce

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '#{{ $id }}-textarea',
                height: 300,
                menubar: false,
                statusbar: false,
                plugins: 'code table link',
                toolbar: 'code | blocks | bold italic strikethrough | alignleft aligncenter alignright alignjustify | table | link unlink',
                block_formats: 'Normal Text=p; Quote=blockquote; Code=pre; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6',
                content_style: "@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap'); body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 0.95rem; color: #1f2937; line-height: 1.5; padding: 10px; } h1, h2, h3, h4, h5, h6 { font-weight: 700; color: #111827; margin-top: 1rem; margin-bottom: 0.5rem; } h1 { font-size: 1.75rem; } h2 { font-size: 1.5rem; } h3 { font-size: 1.25rem; } h4 { font-size: 1.1rem; } h5 { font-size: 1rem; } h6 { font-size: 0.875rem; } p { margin-top: 0; margin-bottom: 0.5rem; }",
                placeholder: '{{ $placeholder }}',
                link_default_target: '_blank',
                link_target_list: false,
                setup: function (editor) {
                    editor.on('change', function () {
                        tinymce.triggerSave();
                    });
                }
            });
        });
    </script>
@endpush
