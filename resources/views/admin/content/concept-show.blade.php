@extends('admin.layout')

@section('title', 'Concept Show Page - Content Management')

@push('styles')
<style>
    .section-divider {
        border-top: 2px solid var(--admin-primary);
        margin: 2rem 0 1rem 0;
        position: relative;
    }
    
    .section-title {
        background: var(--admin-light);
        color: var(--admin-primary);
        padding: 0 1rem;
        position: absolute;
        top: -0.75rem;
        left: 1rem;
        font-weight: 600;
    }
    
    .content-preview-img {
        max-width: 100px;
        max-height: 60px;
        object-fit: cover;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
        min-height: 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .upload-area:hover {
        border-color: var(--admin-primary);
        background-color: #fff5f0;
    }
    
    .upload-area.dragover {
        border-color: var(--admin-primary);
        background-color: #fff5f0;
    }
    
    .code-preview {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 8px;
        font-family: 'Monaco', 'Courier New', monospace;
        font-size: 11px;
        color: #666;
        max-height: 80px;
        overflow-y: auto;
        white-space: pre-wrap;
    }
    
    .section-reset-btn {
        position: absolute;
        top: -0.75rem;
        right: 1rem;
        background: var(--admin-secondary);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 2px 8px;
        font-size: 11px;
        cursor: pointer;
    }

    .setting-card {
        transition: all 0.3s;
        border: 1px solid #e9ecef;
    }

    .setting-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .setting-key {
        font-family: 'Monaco', 'Courier New', monospace;
        font-size: 10px;
        color: #6c757d;
        background: #f8f9fa;
        padding: 2px 6px;
        border-radius: 3px;
        display: inline-block;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .stats-section {
        background: linear-gradient(135deg, var(--admin-primary), #f0861a);
        color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .stat-item {
        text-align: center;
        padding: 10px;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        display: block;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-layout-text-window-reverse"></i>
        Concept Show Page Settings
    </h1>
    <div class="btn-group">
        <button type="button" class="btn btn-outline-success btn-sm" onclick="exportSettings()">
            <i class="bi bi-download"></i>
            Export
        </button>
        <button type="button" class="btn btn-outline-info btn-sm" 
                data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="bi bi-upload"></i>
            Import
        </button>
        <button type="button" class="btn btn-outline-warning btn-sm" 
                data-bs-toggle="modal" data-bs-target="#resetAllModal">
            <i class="bi bi-arrow-clockwise"></i>
            Reset All
        </button>
        <a href="{{ route('welcomePage') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-globe"></i>
            View Site
        </a>
    </div>
</div>

<!-- Stats Section -->
<div class="stats-section">
    <div class="row" id="statsContainer">
        <div class="col-md-3 stat-item">
            <span class="stat-number" id="totalSettings">{{ $contents->flatten()->count() }}</span>
            <span class="stat-label">Total Settings</span>
        </div>
        <div class="col-md-3 stat-item">
            <span class="stat-number" id="totalSections">{{ $contents->count() }}</span>
            <span class="stat-label">Sections</span>
        </div>
        <div class="col-md-3 stat-item">
            <span class="stat-number" id="imageSettings">{{ $contents->flatten()->where('type', 'image')->count() }}</span>
            <span class="stat-label">Image Settings</span>
        </div>
        <div class="col-md-3 stat-item">
            <span class="stat-number" id="textSettings">{{ $contents->flatten()->whereIn('type', ['text', 'textarea'])->count() }}</span>
            <span class="stat-label">Text Settings</span>
        </div>
    </div>
</div>

<div class="alert alert-info border-0">
    <i class="bi bi-info-circle me-2"></i>
    <strong>Concept Show Page Configuration</strong><br>
    These settings control the appearance and behavior of individual concept detail pages. Changes apply to all concept pages site-wide.
</div>

<form method="POST" action="{{ route('admin.concept-show.update') }}" id="conceptForm">
    @csrf
    @method('PUT')
    
    @foreach($contents as $section => $items)
    <div class="section-divider">
        <span class="section-title">{{ $section ?: 'General Settings' }}</span>
        <button type="button" class="section-reset-btn" 
                onclick="resetSection('{{ $section }}')">
            Reset
        </button>
    </div>
    
    <div class="row mb-4">
        @foreach($items as $content)
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card setting-card h-100">
                <div class="card-header bg-white py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0 text-truncate">{{ $content->label }}</h6>
                        <div>
                            <span class="badge bg-{{ $content->type === 'image' ? 'success' : ($content->type === 'textarea' ? 'info' : 'secondary') }} me-1">
                                {{ ucfirst($content->type) }}
                            </span>
                            <span class="badge bg-light text-dark">{{ $content->sort_order }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body py-2">
                    @if($content->description)
                    <p class="text-muted small mb-2">
                        <i class="bi bi-info-circle me-1"></i>
                        {{ $content->description }}
                    </p>
                    @endif
                    
                    @if($content->type === 'text')
                        <input type="text" 
                               class="form-control form-control-sm" 
                               name="contents[{{ $content->key }}]" 
                               value="{{ old('contents.' . $content->key, $content->value) }}"
                               placeholder="Enter {{ strtolower($content->label) }}">
                               
                    @elseif($content->type === 'textarea')
                        <textarea class="form-control form-control-sm" 
                                  rows="2" 
                                  name="contents[{{ $content->key }}]" 
                                  placeholder="Enter {{ strtolower($content->label) }}">{{ old('contents.' . $content->key, $content->value) }}</textarea>
                        
                        @if(strlen($content->value) > 50)
                        <div class="code-preview mt-2">{{ $content->value }}</div>
                        @endif
                               
                    @elseif($content->type === 'email')
                        <input type="email" 
                               class="form-control form-control-sm" 
                               name="contents[{{ $content->key }}]" 
                               value="{{ old('contents.' . $content->key, $content->value) }}"
                               placeholder="Enter email address">
                               
                    @elseif($content->type === 'url')
                        <div class="input-group input-group-sm">
                            <input type="text" 
                                   class="form-control" 
                                   name="contents[{{ $content->key }}]" 
                                   value="{{ old('contents.' . $content->key, $content->value) }}"
                                   placeholder="Enter path or URL">
                            @if($content->value)
                            <button type="button" 
                                    class="btn btn-outline-secondary" 
                                    onclick="copyToClipboard('{{ $content->value }}')">
                                <i class="bi bi-clipboard"></i>
                            </button>
                            @endif
                        </div>
                        
                    @elseif($content->type === 'image')
                        <div class="image-upload-container">
                            @if($content->value)
                            <div class="text-center mb-2">
                                <img src="{{ $content->value }}" 
                                     alt="{{ $content->label }}" 
                                     class="content-preview-img border"
                                     onclick="showImageModal('{{ $content->value }}', '{{ $content->label }}')">
                                <div class="small text-muted mt-1">{{ basename($content->value) }}</div>
                                <button type="button" 
                                        class="btn btn-outline-danger btn-sm mt-1" 
                                        onclick="deleteImage('{{ $content->key }}', '{{ $content->value }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            @endif
                            
                            <input type="hidden" 
                                   name="contents[{{ $content->key }}]" 
                                   value="{{ $content->value }}" 
                                   id="hidden_{{ $content->key }}">
                            
                            <div class="upload-area" 
                                 onclick="document.getElementById('file_{{ $content->key }}').click()">
                                <i class="bi bi-cloud-upload fs-5 text-muted"></i>
                                <p class="mb-0 small">Click or drag to upload</p>
                            </div>
                            
                            <input type="file" 
                                   id="file_{{ $content->key }}" 
                                   class="d-none" 
                                   accept="image/*" 
                                   data-key="{{ $content->key }}">
                                   
                            <div class="progress mt-2 d-none" id="progress_{{ $content->key }}">
                                <div class="progress-bar" role="progressbar"></div>
                            </div>
                            
                            <div id="status_{{ $content->key }}" class="mt-2"></div>
                        </div>
                    @endif
                    
                    @if($content->type !== 'image')
                    <div class="text-muted mt-2">
                        <small><strong>Current:</strong> {{ Str::limit($content->value, 25) }}</small>
                    </div>
                    @endif
                </div>
                
                <div class="card-footer bg-light py-1">
                    <div class="setting-key">{{ $content->key }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
    
    <div class="sticky-bottom bg-white p-3 border-top shadow">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <button type="button" class="btn btn-outline-info" onclick="previewChanges()">
                    <i class="bi bi-eye"></i>
                    Preview Changes
                </button>
            </div>
            <div>
                <button type="button" class="btn btn-outline-secondary me-2" onclick="location.reload()">
                    <i class="bi bi-arrow-clockwise"></i>
                    Discard
                </button>
                <button type="submit" class="btn btn-admin-primary">
                    <i class="bi bi-check-circle"></i>
                    Save All Settings
                </button>
            </div>
        </div>
    </div>
</form>

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewTitle">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="imagePreviewImg" src="" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Import Settings Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-upload"></i>
                    Import Settings
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.concept-show.import-settings') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select Settings File</label>
                        <input type="file" class="form-control" name="settings_file" accept=".json" required>
                        <div class="form-text">Upload a JSON file previously exported from this system.</div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-admin-primary">Import Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reset All Modal -->
<div class="modal fade" id="resetAllModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    Reset All Settings
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>This will reset <strong>ALL</strong> concept show settings to their default values.</p>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Warning:</strong> This action cannot be undone. Consider exporting your current settings first.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('admin.concept-show.reset-defaults') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset All Settings
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeFileUploads();
    loadStats();
});

function initializeFileUploads() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const key = this.dataset.key;
            const file = this.files[0];
            if (file) uploadImage(file, key);
        });
        
        // Drag and drop
        const uploadArea = input.parentElement.querySelector('.upload-area');
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        uploadArea.addEventListener('dragover', () => uploadArea.classList.add('dragover'));
        uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('dragover'));
        uploadArea.addEventListener('drop', function(e) {
            this.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                uploadImage(files[0], input.dataset.key);
            }
        });
    });
}

function uploadImage(file, key) {
    const formData = new FormData();
    formData.append('image', file);
    formData.append('key', key);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    
    const progressBar = document.querySelector(`#progress_${key}`);
    const statusDiv = document.querySelector(`#status_${key}`);
    const hiddenInput = document.querySelector(`#hidden_${key}`);
    
    progressBar.classList.remove('d-none');
    statusDiv.innerHTML = '<small class="text-info"><i class="bi bi-upload"></i> Uploading...</small>';
    
    fetch('{{ route("admin.concept-show.upload-image") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            hiddenInput.value = data.path;
            updateImagePreview(key, data.path, data.filename);
            statusDiv.innerHTML = '<small class="text-success"><i class="bi bi-check-circle"></i> Upload successful!</small>';
        } else {
            statusDiv.innerHTML = `<small class="text-danger"><i class="bi bi-exclamation-circle"></i> ${data.message}</small>`;
        }
        
        progressBar.classList.add('d-none');
        setTimeout(() => statusDiv.innerHTML = '', 3000);
    })
    .catch(error => {
        console.error('Upload error:', error);
        statusDiv.innerHTML = '<small class="text-danger"><i class="bi bi-exclamation-circle"></i> Upload failed!</small>';
        progressBar.classList.add('d-none');
    });
}

function updateImagePreview(key, path, filename) {
    const container = document.querySelector(`#file_${key}`).parentElement;
    let previewDiv = container.querySelector('.text-center');
    
    if (previewDiv) {
        previewDiv.querySelector('img').src = path;
        previewDiv.querySelector('.text-muted').textContent = filename;
    } else {
        const newPreview = document.createElement('div');
        newPreview.className = 'text-center mb-2';
        newPreview.innerHTML = `
            <img src="${path}" alt="Preview" class="content-preview-img border" onclick="showImageModal('${path}', 'Preview')">
            <div class="small text-muted mt-1">${filename}</div>
            <button type="button" class="btn btn-outline-danger btn-sm mt-1" onclick="deleteImage('${key}', '${path}')">
                <i class="bi bi-trash"></i>
            </button>
        `;
        container.insertBefore(newPreview, container.querySelector('.upload-area'));
    }
}

function deleteImage(key, path) {
    if (confirm('Are you sure you want to delete this image?')) {
        fetch('{{ route("admin.concept-show.delete-image") }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ key: key, path: path })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`#hidden_${key}`).value = '';
                const previewDiv = document.querySelector(`#file_${key}`).parentElement.querySelector('.text-center');
                if (previewDiv) previewDiv.remove();
                showToast('success', 'Image deleted successfully!');
            } else {
                showToast('error', data.message);
            }
        })
        .catch(error => showToast('error', 'Failed to delete image'));
    }
}

function showImageModal(src, title) {
    document.getElementById('imagePreviewImg').src = src;
    document.getElementById('imagePreviewTitle').textContent = title;
    new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
}

function resetSection(sectionName) {
    if (confirm(`Reset all settings in the "${sectionName}" section to defaults?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.concept-show.reset-defaults") }}';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
        
        const sectionInput = document.createElement('input');
        sectionInput.type = 'hidden';
        sectionInput.name = 'section';
        sectionInput.value = sectionName;
        
        form.appendChild(csrfInput);
        form.appendChild(sectionInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function exportSettings() {
    window.location.href = '{{ route("admin.concept-show.export-settings") }}';
}

function previewChanges() {
    const formData = new FormData(document.getElementById('conceptForm'));
    const contents = {};
    
    for (let [key, value] of formData.entries()) {
        if (key.startsWith('contents[')) {
            const cleanKey = key.replace('contents[', '').replace(']', '');
            contents[cleanKey] = value;
        }
    }
    
    fetch('{{ route("admin.concept-show.preview-changes") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ contents: contents })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let previewHtml = `<h6>Changes Preview (${data.changes_count} changes)</h6><div class="row">`;
            
            Object.values(data.preview).forEach(item => {
                if (item.changed) {
                    previewHtml += `
                        <div class="col-md-6 mb-2">
                            <strong>${item.label}:</strong><br>
                            <small class="text-muted">From: ${item.current_value || 'Empty'}</small><br>
                            <small class="text-success">To: ${item.new_value || 'Empty'}</small>
                        </div>
                    `;
                }
            });
            
            previewHtml += '</div>';
            showModal('Preview Changes', previewHtml);
        }
    })
    .catch(error => showToast('error', 'Failed to preview changes'));
}

function loadStats() {
    fetch('{{ route("admin.concept-show.get-stats") }}')
    .then(response => response.json())
    .then(data => {
        document.getElementById('totalSettings').textContent = data.total_concept_settings || 0;
        document.getElementById('totalSections').textContent = data.sections || 0;
        document.getElementById('imageSettings').textContent = data.media_settings || 0;
        document.getElementById('textSettings').textContent = data.layout_settings || 0;
    })
    .catch(error => console.error('Failed to load stats:', error));
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('success', 'Copied to clipboard!');
    });
}

function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    toast.style = 'top: 20px; right: 20px; z-index: 9999;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (document.body.contains(toast)) {
            document.body.removeChild(toast);
        }
    }, 3000);
}

function showModal(title, content) {
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.innerHTML = `
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">${title}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">${content}</div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
    
    modal.addEventListener('hidden.bs.modal', () => {
        document.body.removeChild(modal);
    });
}
</script>
@endpush