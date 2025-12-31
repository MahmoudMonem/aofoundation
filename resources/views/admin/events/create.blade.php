@extends('admin.layout')

@section('title', 'Create Event')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Create New Event</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Events
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle text-primary"></i> Basic Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title_en" class="form-label">Title (English) <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title_en') is-invalid @enderror" 
                                   id="title_en" 
                                   name="title_en" 
                                   value="{{ old('title_en') }}" 
                                   required>
                            @error('title_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="title_ar" class="form-label">Title (Arabic)</label>
                            <input type="text" 
                                   class="form-control @error('title_ar') is-invalid @enderror" 
                                   id="title_ar" 
                                   name="title_ar" 
                                   value="{{ old('title_ar') }}" 
                                   dir="rtl">
                            @error('title_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">

                    <div class="mb-3">
    <label class="form-label">Organizer</label>
    <select name="organizer_id" class="form-select">
        @foreach($organizers as $organizer)
            <option value="{{ $organizer->id }}"
                {{ old('organizer_id', 1) == $organizer->id ? 'selected' : '' }}>
                {{ $organizer->name }}
            </option>
        @endforeach
    </select>
</div>
                        <div class="col-md-6 mb-3">
                            <label for="short_desc_en" class="form-label">Short Description (English)</label>
                            <textarea class="form-control @error('short_desc_en') is-invalid @enderror" 
                                      id="short_desc_en" 
                                      name="short_desc_en" 
                                      rows="3">{{ old('short_desc_en') }}</textarea>
                            @error('short_desc_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="short_desc_ar" class="form-label">Short Description (Arabic)</label>
                            <textarea class="form-control @error('short_desc_ar') is-invalid @enderror" 
                                      id="short_desc_ar" 
                                      name="short_desc_ar" 
                                      rows="3" 
                                      dir="rtl">{{ old('short_desc_ar') }}</textarea>
                            @error('short_desc_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="desc_en" class="form-label">Full Description (English)</label>
                            <textarea class="form-control @error('desc_en') is-invalid @enderror" 
                                      id="desc_en" 
                                      name="desc_en" 
                                      rows="5">{{ old('desc_en') }}</textarea>
                            @error('desc_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="desc_ar" class="form-label">Full Description (Arabic)</label>
                            <textarea class="form-control @error('desc_ar') is-invalid @enderror" 
                                      id="desc_ar" 
                                      name="desc_ar" 
                                      rows="5" 
                                      dir="rtl">{{ old('desc_ar') }}</textarea>
                            @error('desc_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Event Images Gallery -->
            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-images text-primary"></i> Event Gallery Images
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="event_images" class="form-label">Upload Multiple Images</label>
                        <input type="file" 
                               class="form-control @error('event_images.*') is-invalid @enderror" 
                               id="event_images" 
                               name="event_images[]" 
                               accept="image/*" 
                               multiple>
                        <div class="form-text">You can select multiple images. First image will be set as featured by default.</div>
                        @error('event_images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div id="image-preview-container" class="row g-3 mt-2"></div>
                    
                    <input type="hidden" name="featured_image_index" id="featured_image_index" value="0">
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publish Settings -->
            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-gear text-primary"></i> Settings
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="available" name="available" value="1" {{ old('available', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="available">
                                <strong>Available</strong>
                                <br><small class="text-muted">Show this event on the website</small>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">
                                <strong>Featured</strong>
                                <br><small class="text-muted">Highlight this event</small>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="organizer_id" class="form-label">Organizer ID</label>
                        <input type="number" 
                               class="form-control @error('organizer_id') is-invalid @enderror" 
                               id="organizer_id" 
                               name="organizer_id" 
                               value="{{ old('organizer_id') }}">
                        @error('organizer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Main Images -->
            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-image text-primary"></i> Main Images
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="cover" class="form-label">Cover Image</label>
                        <input type="file" 
                               class="form-control @error('cover') is-invalid @enderror" 
                               id="cover" 
                               name="cover" 
                               accept="image/*">
                        <div class="form-text">Recommended: 1920x600px</div>
                        @error('cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="cover-preview" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" 
                               class="form-control @error('logo') is-invalid @enderror" 
                               id="logo" 
                               name="logo" 
                               accept="image/*">
                        <div class="form-text">Recommended: 200x200px</div>
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="logo-preview" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        <input type="file" 
                               class="form-control @error('thumbnail') is-invalid @enderror" 
                               id="thumbnail" 
                               name="thumbnail" 
                               accept="image/*">
                        <div class="form-text">Recommended: 400x300px</div>
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="thumbnail-preview" class="mt-2"></div>
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="card card-admin">
                <div class="card-body">
                    <button type="submit" class="btn btn-admin-primary w-100 mb-2">
                        <i class="bi bi-check-circle"></i> Create Event
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary w-100">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview for single images (cover, logo, thumbnail)
    ['cover', 'logo', 'thumbnail'].forEach(function(field) {
        document.getElementById(field).addEventListener('change', function(e) {
            const preview = document.getElementById(field + '-preview');
            preview.innerHTML = '';
            
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.maxHeight = '100px';
                    preview.appendChild(img);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    
    // Preview for multiple event images
    document.getElementById('event_images').addEventListener('change', function(e) {
        const container = document.getElementById('image-preview-container');
        container.innerHTML = '';
        
        Array.from(this.files).forEach(function(file, index) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-4';
                col.innerHTML = `
                    <div class="position-relative border rounded p-2 ${index === 0 ? 'border-warning border-2' : ''}">
                        <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 100px; width: 100%; object-fit: cover;">
                        <div class="mt-2">
                            <div class="form-check">
                                <input class="form-check-input featured-radio" type="radio" name="featured_radio" id="featured_${index}" ${index === 0 ? 'checked' : ''} data-index="${index}">
                                <label class="form-check-label small" for="featured_${index}">
                                    Featured
                                </label>
                            </div>
                        </div>
                        ${index === 0 ? '<span class="badge bg-warning position-absolute top-0 end-0 m-1">Featured</span>' : ''}
                    </div>
                `;
                container.appendChild(col);
            }
            reader.readAsDataURL(file);
        });
    });
    
    // Update featured image index when radio changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('featured-radio')) {
            document.getElementById('featured_image_index').value = e.target.dataset.index;
            
            // Update visual indicators
            document.querySelectorAll('#image-preview-container .col-4 > div').forEach(function(div, idx) {
                div.classList.remove('border-warning', 'border-2');
                const badge = div.querySelector('.badge');
                if (badge) badge.remove();
            });
            
            const selectedDiv = e.target.closest('.col-4').querySelector('div');
            selectedDiv.classList.add('border-warning', 'border-2');
            const badge = document.createElement('span');
            badge.className = 'badge bg-warning position-absolute top-0 end-0 m-1';
            badge.textContent = 'Featured';
            selectedDiv.appendChild(badge);
        }
    });
});
</script>
@endpush
@endsection