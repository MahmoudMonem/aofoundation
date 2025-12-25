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
    
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .upload-area:hover {
        border-color: var(--admin-primary);
        background-color: #fff5f0;
    }
    
    .upload-area.dragover {
        border-color: var(--admin-primary);
        background-color: #fff5f0;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Content Management</h1>
    <div>
        <button type="button" class="btn btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#previewModal">
            <i class="bi bi-eye"></i>
            Preview Changes
        </button>
        <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary">
            <i class="bi bi-globe"></i>
            View Live Site
        </a>
    </div>
</div>

<form method="POST" action="{{ route('admin.content.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    @foreach($contents as $section => $items)
    <div class="section-divider">
        <span class="section-title">{{ $section ?: 'General' }}</span>
    </div>
    
    <div class="row mb-4">
        @foreach($items as $content)
        <div class="col-md-6 mb-3">
            <div class="card card-admin h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">{{ $content->label }}</h6>
                    <span class="badge bg-secondary">{{ ucfirst($content->type) }}</span>
                </div>
                <div class="card-body">
                    @if($content->description)
                    <p class="text-muted small mb-3">{{ $content->description }}</p>
                    @endif
                    
                    @if($content->type === 'text')
                        <input type="text" class="form-control" 
                               name="contents[{{ $content->key }}]" 
                               value="{{ old('contents.' . $content->key, $content->value) }}">
                               
                    @elseif($content->type === 'textarea')
                        <textarea class="form-control" rows="4" 
                                  name="contents[{{ $content->key }}]">{{ old('contents.' . $content->key, $content->value) }}</textarea>
                                  
                    @elseif($content->type === 'email')
                        <input type="email" class="form-control" 
                               name="contents[{{ $content->key }}]" 
                               value="{{ old('contents.' . $content->key, $content->value) }}">
                               
                    @elseif($content->type === 'url')
                        <div class="input-group">
                            <input type="url" class="form-control" 
                                   name="contents[{{ $content->key }}]" 
                                   value="{{ old('contents.' . $content->key, $content->value) }}">
                            @if($content->value && file_exists(public_path($content->value)))
                            <a href="{{ $content->value }}" target="_blank" class="btn btn-outline-secondary">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                            @endif
                        </div>
                        
                    @elseif($content->type === 'image')
                        <div style="background-color:#e2e2e2;" class="image-upload-container p-3 ">
                            <!-- Current Image Preview -->
                            @if($content->value)
                            <div class="mb-2">
                                <img src="{{ $content->value }}" alt="{{ $content->label }}" 
                                     class="content-preview-img border">
                                <div class="small text-muted mt-1">Current: {{ basename($content->value) }}</div>
                            </div>
                            @endif
                            
                            <!-- Hidden input for current value -->
                            <input type="hidden" name="contents[{{ $content->key }}]" 
                                   value="{{ $content->value }}" id="hidden_{{ $content->key }}">
                            
                            <!-- Upload Area -->
                            <div class="upload-area" onclick="document.getElementById('file_{{ $content->key }}').click()">
                                <i class="bi bi-cloud-upload fs-2 text-muted"></i>
                                <p class="mb-0">Click to upload new image</p>
                                <small class="text-muted">or drag and drop</small>
                            </div>
                            
                            <!-- File Input -->
                            <input type="file" id="file_{{ $content->key }}" 
                                   class="d-none" accept="image/*" 
                                   data-key="{{ $content->key }}">
                                   
                            <!-- Progress Bar -->
                            <div class="progress mt-2 d-none" id="progress_{{ $content->key }}">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            
                            <!-- Upload Status -->
                            <div id="status_{{ $content->key }}" class="mt-2"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
    
    <div class="sticky-bottom bg-white p-3 border-top">
        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-outline-secondary" onclick="location.reload()">
                <i class="bi bi-arrow-clockwise"></i>
                Reset Changes
            </button>
            <button type="submit" class="btn btn-admin-primary">
                <i class="bi bi-check-circle"></i>
                Save All Changes
            </button>
        </div>
    </div>
</form>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Content Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach($contents as $section => $items)
                    <div class="col-md-6 mb-4">
                        <h6 class="border-bottom pb-2">{{ $section ?: 'General' }}</h6>
                        @foreach($items as $content)
                        <div class="mb-2">
                            <strong class="small">{{ $content->label }}:</strong><br>
                            @if($content->type === 'image' && $content->value)
                                <img src="{{ $content->value }}" alt="{{ $content->label }}" 
                                     class="content-preview-img">
                            @else
                                <span class="text-muted">{{ Str::limit($content->value, 100) }}</span>
                            @endif
                        </div>
                        @endforeach
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
    // Handle file uploads with AJAX
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const key = this.dataset.key;
            const file = this.files[0];
            
            if (!file) return;
            
            uploadImage(file, key);
        });
        
        // Add drag and drop functionality
        const uploadArea = input.parentElement.querySelector('.upload-area');
        
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
                uploadImage(files[0], key);
            }
        });
    });
    
    function uploadImage(file, key) {
        const formData = new FormData();
        formData.append('image', file);
        formData.append('key', key);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        
        const progressBar = document.querySelector(`#progress_${key}`);
        const statusDiv = document.querySelector(`#status_${key}`);
        const hiddenInput = document.querySelector(`#hidden_${key}`);
        
        // Show progress bar
        progressBar.classList.remove('d-none');
        statusDiv.innerHTML = '<small class="text-info">Uploading...</small>';
        
        fetch('{{ route("admin.content.upload-image") }}', {
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
                
                // Update preview image
                const container = document.querySelector(`#file_${key}`).parentElement;
                let img = container.querySelector('.content-preview-img');
                if (img) {
                    img.src = data.path;
                } else {
                    // Create new preview if none exists
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'mb-2';
                    previewDiv.innerHTML = `
                        <img src="${data.path}" alt="Preview" class="content-preview-img border">
                        <div class="small text-muted mt-1">Current: ${data.path.split('/').pop()}</div>
                    `;
                    container.insertBefore(previewDiv, container.querySelector('.upload-area'));
                }
                
                statusDiv.innerHTML = '<small class="text-success"><i class="bi bi-check-circle"></i> Upload successful!</small>';
            } else {
                statusDiv.innerHTML = `<small class="text-danger"><i class="bi bi-exclamation-circle"></i> ${data.message}</small>`;
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
            statusDiv.innerHTML = '<small class="text-danger"><i class="bi bi-exclamation-circle"></i> Upload failed!</small>';
            progressBar.classList.add('d-none');
        });
    }
});
</script>
@endpush