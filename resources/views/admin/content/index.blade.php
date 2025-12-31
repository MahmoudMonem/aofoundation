@extends('admin.layout')

@section('title', 'Content Management')

@push('styles')
<style>
    .content-preview-img {
        max-width: 100px;
        max-height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .content-preview-video {
        max-width: 150px;
        max-height: 80px;
        border-radius: 4px;
    }
    
    .section-divider {
        border-top: 2px solid var(--admin-primary, #ad715c);
        margin: 2rem 0 1rem 0;
        position: relative;
    }
    
    .section-title {
        background: var(--admin-light, #f8f9fa);
        color: var(--admin-primary, #ad715c);
        padding: 0 1rem;
        position: absolute;
        top: -0.75rem;
        left: 1rem;
        font-weight: 600;
    }
    
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .upload-area:hover {
        border-color: var(--admin-primary, #ad715c);
        background-color: #fff5f0;
    }
    
    .upload-area.dragover {
        border-color: var(--admin-primary, #ad715c);
        background-color: #fff5f0;
    }
    
    .card-admin {
        border: 1px solid #e2e2e2;
        border-radius: 8px;
        transition: box-shadow 0.3s;
    }
    
    .card-admin:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .btn-admin-primary {
        background-color: var(--admin-primary, #ad715c);
        border-color: var(--admin-primary, #ad715c);
        color: white;
    }
    
    .btn-admin-primary:hover {
        background-color: #8a5a4a;
        border-color: #8a5a4a;
        color: white;
    }
    
    .sticky-bottom {
        position: sticky;
        bottom: 0;
        z-index: 100;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    }
    
    .content-card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e2e2e2;
    }
    
    .badge-type {
        font-size: 0.7rem;
        padding: 0.3em 0.6em;
    }
    
    .search-box {
        max-width: 300px;
    }
    
    .collapse-section {
        cursor: pointer;
    }
    
    .collapse-section:hover {
        background-color: #f0f0f0;
    }
    
    .collapse-icon {
        transition: transform 0.3s;
    }
    
    .collapsed .collapse-icon {
        transform: rotate(-90deg);
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Content Management</h1>
        <p class="text-muted mb-0">Manage website content for AO Foundation</p>
    </div>
    <div class="d-flex gap-2">
        <div class="search-box">
            <input type="text" class="form-control" id="contentSearch" placeholder="Search content...">
        </div>
        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#previewModal">
            <i class="bi bi-eye"></i>
            Preview
        </button>
        <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary">
            <i class="bi bi-globe"></i>
            View Site
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card card-admin text-center p-3">
            <h4 class="mb-1" id="stat-total">{{ $contents->flatten()->count() }}</h4>
            <small class="text-muted">Total Items</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card card-admin text-center p-3">
            <h4 class="mb-1">{{ $contents->count() }}</h4>
            <small class="text-muted">Sections</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card card-admin text-center p-3">
            <h4 class="mb-1">{{ $contents->flatten()->where('type', 'image')->count() }}</h4>
            <small class="text-muted">Images</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card card-admin text-center p-3">
            <h4 class="mb-1">{{ $contents->flatten()->where('type', 'video')->count() }}</h4>
            <small class="text-muted">Videos</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card card-admin text-center p-3">
            <h4 class="mb-1">{{ $contents->flatten()->whereIn('type', ['text', 'textarea'])->count() }}</h4>
            <small class="text-muted">Text Items</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card card-admin text-center p-3">
            <h4 class="mb-1">{{ $contents->flatten()->where('updated_at', '>=', now()->subDays(7))->count() }}</h4>
            <small class="text-muted">Recent Updates</small>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('admin.content.update') }}" enctype="multipart/form-data" id="contentForm">
    @csrf
    @method('PUT')
    
    @foreach($contents as $section => $items)
    <div class="section-wrapper mb-4" data-section="{{ $section }}">
        <div class="section-divider">
            <span class="section-title collapse-section d-flex align-items-center" 
                  data-bs-toggle="collapse" 
                  data-bs-target="#section-{{ Str::slug($section ?: 'general') }}"
                  aria-expanded="true">
                <i class="bi bi-chevron-down collapse-icon me-2"></i>
                {{ $section ?: 'General' }}
                <span class="badge bg-secondary ms-2">{{ $items->count() }}</span>
            </span>
        </div>
        
        <div class="collapse show" id="section-{{ Str::slug($section ?: 'general') }}">
            <div class="row">
                @foreach($items as $content)
                <div class="col-md-6 mb-3 content-item" data-label="{{ strtolower($content->label) }}" data-key="{{ strtolower($content->key) }}">
                    <div class="card card-admin h-100">
                        <div class="card-header content-card-header d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">{{ $content->label }}</h6>
                            <span class="badge bg-{{ $content->type === 'image' ? 'success' : ($content->type === 'video' ? 'primary' : ($content->type === 'textarea' ? 'info' : 'secondary')) }} badge-type">
                                {{ ucfirst($content->type) }}
                            </span>
                        </div>
                        <div class="card-body">
                            @if($content->description)
                            <p class="text-muted small mb-3">
                                <i class="bi bi-info-circle me-1"></i>
                                {{ $content->description }}
                            </p>
                            @endif
                            
                            @if($content->type === 'text')
                                <input type="text" class="form-control content-input" 
                                       name="contents[{{ $content->key }}]" 
                                       value="{{ old('contents.' . $content->key, $content->value) }}"
                                       data-original="{{ $content->value }}">
                                       
                            @elseif($content->type === 'textarea')
                                <textarea class="form-control content-input" rows="4" 
                                          name="contents[{{ $content->key }}]"
                                          data-original="{{ $content->value }}">{{ old('contents.' . $content->key, $content->value) }}</textarea>
                                          
                            @elseif($content->type === 'email')
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control content-input" 
                                           name="contents[{{ $content->key }}]" 
                                           value="{{ old('contents.' . $content->key, $content->value) }}"
                                           data-original="{{ $content->value }}">
                                </div>
                                       
                            @elseif($content->type === 'url')
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                    <input type="url" class="form-control content-input" 
                                           name="contents[{{ $content->key }}]" 
                                           value="{{ old('contents.' . $content->key, $content->value) }}"
                                           data-original="{{ $content->value }}">
                                    @if($content->value)
                                    <a href="{{ $content->value }}" target="_blank" class="btn btn-outline-secondary">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                    @endif
                                </div>
                                
                            @elseif($content->type === 'number')
                                <input type="number" class="form-control content-input" 
                                       name="contents[{{ $content->key }}]" 
                                       value="{{ old('contents.' . $content->key, $content->value) }}"
                                       data-original="{{ $content->value }}">
                                    
                            @elseif($content->type === 'image')
                                <div style="background-color:#f5f5f5;" class="image-upload-container p-3 rounded">
                                    <!-- Current Image Preview -->
                                    @if($content->value)
                                    <div class="mb-2 text-center">
                                        <img src="{{ $content->value }}" alt="{{ $content->label }}" 
                                             class="content-preview-img border shadow-sm">
                                        <div class="small text-muted mt-1">
                                            <i class="bi bi-image me-1"></i>
                                            {{ basename($content->value) }}
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- Hidden input for current value -->
                                    <input type="hidden" name="contents[{{ $content->key }}]" 
                                           value="{{ $content->value }}" id="hidden_{{ $content->key }}">
                                    
                                    <!-- Upload Area -->
                                    <div class="upload-area" onclick="document.getElementById('file_{{ $content->key }}').click()">
                                        <i class="bi bi-cloud-upload fs-2 text-muted"></i>
                                        <p class="mb-0">Click to upload new image</p>
                                        <small class="text-muted">or drag and drop (max 5MB)</small>
                                    </div>
                                    
                                    <!-- File Input -->
                                    <input type="file" id="file_{{ $content->key }}" 
                                           class="d-none image-file-input" accept="image/*" 
                                           data-key="{{ $content->key }}">
                                           
                                    <!-- Progress Bar -->
                                    <div class="progress mt-2 d-none" id="progress_{{ $content->key }}" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    
                                    <!-- Upload Status -->
                                    <div id="status_{{ $content->key }}" class="mt-2"></div>
                                </div>
                                
                            @elseif($content->type === 'video')
                                <div style="background-color:#f5f5f5;" class="video-upload-container p-3 rounded">
                                    <!-- Current Video Preview -->
                                    @if($content->value)
                                    <div class="mb-2 text-center">
                                        <video class="content-preview-video border shadow-sm" controls>
                                            <source src="{{ $content->value }}" type="video/mp4">
                                        </video>
                                        <div class="small text-muted mt-1">
                                            <i class="bi bi-camera-video me-1"></i>
                                            {{ basename($content->value) }}
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- Hidden input for current value -->
                                    <input type="hidden" name="contents[{{ $content->key }}]" 
                                           value="{{ $content->value }}" id="hidden_{{ $content->key }}">
                                    
                                    <!-- Upload Area -->
                                    <div class="upload-area" onclick="document.getElementById('video_{{ $content->key }}').click()">
                                        <i class="bi bi-camera-video fs-2 text-muted"></i>
                                        <p class="mb-0">Click to upload new video</p>
                                        <small class="text-muted">MP4, WebM, OGG (max 50MB)</small>
                                    </div>
                                    
                                    <!-- File Input -->
                                    <input type="file" id="video_{{ $content->key }}" 
                                           class="d-none video-file-input" accept="video/mp4,video/webm,video/ogg" 
                                           data-key="{{ $content->key }}">
                                           
                                    <!-- Progress Bar -->
                                    <div class="progress mt-2 d-none" id="progress_{{ $content->key }}" style="height: 6px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    
                                    <!-- Upload Status -->
                                    <div id="status_{{ $content->key }}" class="mt-2"></div>
                                </div>
                            @endif
                            
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-key me-1"></i>
                                Key: <code>{{ $content->key }}</code>
                            </small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
    
    <div class="sticky-bottom bg-white p-3 border-top">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="text-muted" id="changesCount">No changes</span>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary" onclick="resetAllChanges()">
                    <i class="bi bi-arrow-clockwise"></i>
                    Reset Changes
                </button>
                <button type="submit" class="btn btn-admin-primary" id="saveBtn">
                    <i class="bi bi-check-circle"></i>
                    Save All Changes
                </button>
            </div>
        </div>
    </div>
</form>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-eye me-2"></i>
                    Content Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach($contents as $section => $items)
                    <div class="col-12 mb-4">
                        <h5 class="border-bottom pb-2 text-primary">
                            <i class="bi bi-folder me-2"></i>
                            {{ $section ?: 'General' }}
                        </h5>
                        <div class="row">
                            @foreach($items as $content)
                            <div class="col-md-6 mb-3">
                                <div class="p-2 bg-light rounded">
                                    <strong class="small d-block text-muted">{{ $content->label }}</strong>
                                    @if($content->type === 'image' && $content->value)
                                        <img src="{{ $content->value }}" alt="{{ $content->label }}" 
                                             class="content-preview-img mt-1">
                                    @elseif($content->type === 'video' && $content->value)
                                        <video class="content-preview-video mt-1" controls>
                                            <source src="{{ $content->value }}" type="video/mp4">
                                        </video>
                                    @else
                                        <span class="text-dark">{{ Str::limit($content->value, 150) ?: '(empty)' }}</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Track changes
    let changedInputs = new Set();
    
    // Monitor text input changes
    document.querySelectorAll('.content-input').forEach(input => {
        input.addEventListener('input', function() {
            const original = this.dataset.original || '';
            if (this.value !== original) {
                changedInputs.add(this.name);
                this.classList.add('border-warning');
            } else {
                changedInputs.delete(this.name);
                this.classList.remove('border-warning');
            }
            updateChangesCount();
        });
    });
    
    function updateChangesCount() {
        const count = changedInputs.size;
        const countEl = document.getElementById('changesCount');
        if (count === 0) {
            countEl.textContent = 'No changes';
            countEl.classList.remove('text-warning', 'fw-bold');
        } else {
            countEl.textContent = `${count} unsaved change${count > 1 ? 's' : ''}`;
            countEl.classList.add('text-warning', 'fw-bold');
        }
    }
    
    // Search functionality
    document.getElementById('contentSearch').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.content-item').forEach(item => {
            const label = item.dataset.label;
            const key = item.dataset.key;
            if (label.includes(searchTerm) || key.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
    
    // Handle image uploads with AJAX
    const imageInputs = document.querySelectorAll('.image-file-input');
    
    imageInputs.forEach(input => {
        input.addEventListener('change', function() {
            const key = this.dataset.key;
            const file = this.files[0];
            
            if (!file) return;
            
            uploadFile(file, key, 'image');
        });
        
        // Add drag and drop functionality
        const uploadArea = input.parentElement.querySelector('.upload-area');
        
        if (uploadArea) {
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });
            
            uploadArea.addEventListener('dragleave', function() {
                this.classList.remove('dragover');
            });
            
            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const key = input.dataset.key;
                    uploadFile(files[0], key, 'image');
                }
            });
        }
    });
    
    // Handle video uploads with AJAX
    const videoInputs = document.querySelectorAll('.video-file-input');
    
    videoInputs.forEach(input => {
        input.addEventListener('change', function() {
            const key = this.dataset.key;
            const file = this.files[0];
            
            if (!file) return;
            
            uploadFile(file, key, 'video');
        });
        
        // Add drag and drop functionality
        const uploadArea = input.parentElement.querySelector('.upload-area');
        
        if (uploadArea) {
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });
            
            uploadArea.addEventListener('dragleave', function() {
                this.classList.remove('dragover');
            });
            
            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const key = input.dataset.key;
                    uploadFile(files[0], key, 'video');
                }
            });
        }
    });
    
    function uploadFile(file, key, type) {
        const formData = new FormData();
        formData.append(type, file);
        formData.append('key', key);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        
        const progressBar = document.querySelector(`#progress_${key}`);
        const statusDiv = document.querySelector(`#status_${key}`);
        const hiddenInput = document.querySelector(`#hidden_${key}`);
        
        // Show progress bar
        progressBar.classList.remove('d-none');
        statusDiv.innerHTML = '<small class="text-info"><i class="bi bi-hourglass-split me-1"></i>Uploading...</small>';
        
        const uploadUrl = type === 'image' 
            ? '{{ route("admin.content.upload-image") }}'
            : '{{ route("admin.content.upload-video") }}';
        
        fetch(uploadUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update hidden input with new path
                hiddenInput.value = data.path;
                
                // Update preview
                const container = document.querySelector(`#${type === 'image' ? 'file' : 'video'}_${key}`).parentElement;
                
                if (type === 'image') {
                    let img = container.querySelector('.content-preview-img');
                    if (img) {
                        img.src = data.path;
                    } else {
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'mb-2 text-center';
                        previewDiv.innerHTML = `
                            <img src="${data.path}" alt="Preview" class="content-preview-img border shadow-sm">
                            <div class="small text-muted mt-1">
                                <i class="bi bi-image me-1"></i>
                                ${data.filename}
                            </div>
                        `;
                        container.insertBefore(previewDiv, container.querySelector('.upload-area'));
                    }
                } else {
                    let video = container.querySelector('.content-preview-video');
                    if (video) {
                        video.querySelector('source').src = data.path;
                        video.load();
                    } else {
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'mb-2 text-center';
                        previewDiv.innerHTML = `
                            <video class="content-preview-video border shadow-sm" controls>
                                <source src="${data.path}" type="video/mp4">
                            </video>
                            <div class="small text-muted mt-1">
                                <i class="bi bi-camera-video me-1"></i>
                                ${data.filename}
                            </div>
                        `;
                        container.insertBefore(previewDiv, container.querySelector('.upload-area'));
                    }
                }
                
                statusDiv.innerHTML = '<small class="text-success"><i class="bi bi-check-circle me-1"></i>Upload successful!</small>';
            } else {
                statusDiv.innerHTML = `<small class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>${data.message}</small>`;
            }
            
            // Hide progress bar
            progressBar.classList.add('d-none');
            
            // Clear status after 3 seconds
            setTimeout(() => {
                statusDiv.innerHTML = '';
            }, 3000);
        })
        .catch(error => {
            console.error('Upload error:', error);
            statusDiv.innerHTML = '<small class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>Upload failed!</small>';
            progressBar.classList.add('d-none');
        });
    }
    
    // Warn before leaving with unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (changedInputs.size > 0) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
    
    // Reset changes
    window.resetAllChanges = function() {
        if (confirm('Are you sure you want to reset all changes? This cannot be undone.')) {
            document.querySelectorAll('.content-input').forEach(input => {
                if (input.dataset.original !== undefined) {
                    input.value = input.dataset.original;
                    input.classList.remove('border-warning');
                }
            });
            changedInputs.clear();
            updateChangesCount();
        }
    };
    
    // Form submission - clear beforeunload
    document.getElementById('contentForm').addEventListener('submit', function() {
        changedInputs.clear();
    });
});
</script>
@endpush