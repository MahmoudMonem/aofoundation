@extends('admin.layout')

@section('title', 'Edit Event')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Event</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($event->title_en, 20) }}</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.events.show', $event) }}" class="btn btn-outline-info me-2">
            <i class="bi bi-eye"></i> View
        </a>
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Events
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

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

<form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
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
                                   value="{{ old('title_en', $event->title_en) }}" 
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
                                   value="{{ old('title_ar', $event->title_ar) }}" 
                                   dir="rtl">
                            @error('title_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="short_desc_en" class="form-label">Short Description (English)</label>
                            <textarea class="form-control @error('short_desc_en') is-invalid @enderror" 
                                      id="short_desc_en" 
                                      name="short_desc_en" 
                                      rows="3">{{ old('short_desc_en', $event->short_desc_en) }}</textarea>
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
                                      dir="rtl">{{ old('short_desc_ar', $event->short_desc_ar) }}</textarea>
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
                                      rows="5">{{ old('desc_en', $event->desc_en) }}</textarea>
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
                                      dir="rtl">{{ old('desc_ar', $event->desc_ar) }}</textarea>
                            @error('desc_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Current Event Images -->
            <div class="card card-admin mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-images text-primary"></i> Current Gallery Images
                    </h5>
                    <span class="badge bg-info">{{ $event->eventimages->count() }} images</span>
                </div>
                <div class="card-body">
                    @if($event->eventimages->count() > 0)
                    <div class="row g-3">
                        @foreach($event->eventimages as $image)
                        <div class="col-md-3 col-sm-4 col-6">
                            <div class="position-relative border rounded p-2 {{ $image->featured ? 'border-warning border-2' : '' }}">
                                <img src="{{ asset('events/' . $image->img) }}" 
                                     class="img-fluid rounded" 
                                     style="height: 100px; width: 100%; object-fit: cover;">
                                
                                @if($image->featured)
                                    <span class="badge bg-warning position-absolute top-0 start-0 m-1">
                                        <i class="bi bi-star-fill"></i> Featured
                                    </span>
                                @endif
                                
                                <div class="mt-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="featured_image_id" 
                                               id="featured_{{ $image->id }}" 
                                               value="{{ $image->id }}"
                                               {{ $image->featured ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="featured_{{ $image->id }}">
                                            Featured
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="delete_images[]" 
                                               id="delete_{{ $image->id }}" 
                                               value="{{ $image->id }}">
                                        <label class="form-check-label small text-danger" for="delete_{{ $image->id }}">
                                            <i class="bi bi-trash"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-text mt-2">
                        <i class="bi bi-info-circle"></i> Select radio to set featured image. Check boxes to delete images on save.
                    </div>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-images fs-1 mb-2 d-block"></i>
                        <p>No gallery images yet</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Add New Event Images -->
            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-plus-circle text-primary"></i> Add New Gallery Images
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="event_images" class="form-label">Upload Additional Images</label>
                        <input type="file" 
                               class="form-control @error('event_images.*') is-invalid @enderror" 
                               id="event_images" 
                               name="event_images[]" 
                               accept="image/*" 
                               multiple>
                        <div class="form-text">You can select multiple images to add to the gallery.</div>
                        @error('event_images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div id="new-image-preview-container" class="row g-3 mt-2"></div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Event Info -->
            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-event text-primary"></i> Event Info
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Created:</small>
                        <br>{{ $event->created_at->format('M j, Y \a\t g:i A') }}
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Last Updated:</small>
                        <br>{{ $event->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                    <div>
                        <small class="text-muted">Slug:</small>
                        <br><code>{{ $event->slug }}</code>
                    </div>
                </div>
            </div>
            
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
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="available" 
                                   name="available" 
                                   value="1" 
                                   {{ old('available', $event->available) ? 'checked' : '' }}>
                            <label class="form-check-label" for="available">
                                <strong>Available</strong>
                                <br><small class="text-muted">Show this event on the website</small>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="featured" 
                                   name="featured" 
                                   value="1" 
                                   {{ old('featured', $event->featured) ? 'checked' : '' }}>
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
                               value="{{ old('organizer_id', $event->organizer_id) }}">
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
                        @if($event->cover)
                            <div class="mb-2">
                                <img src="{{ asset('events/' . $event->cover) }}" class="img-thumbnail" style="max-height: 80px;">
                                <br><small class="text-muted">Current cover</small>
                            </div>
                        @endif
                        <input type="file" 
                               class="form-control @error('cover') is-invalid @enderror" 
                               id="cover" 
                               name="cover" 
                               accept="image/*">
                        <div class="form-text">Leave empty to keep current. Recommended: 1920x600px</div>
                        @error('cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="cover-preview" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        @if($event->logo)
                            <div class="mb-2">
                                <img src="{{ asset('events/' . $event->logo) }}" class="img-thumbnail" style="max-height: 60px;">
                                <br><small class="text-muted">Current logo</small>
                            </div>
                        @endif
                        <input type="file" 
                               class="form-control @error('logo') is-invalid @enderror" 
                               id="logo" 
                               name="logo" 
                               accept="image/*">
                        <div class="form-text">Leave empty to keep current. Recommended: 200x200px</div>
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="logo-preview" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        @if($event->thumbnail)
                            <div class="mb-2">
                                <img src="{{ asset('events/' . $event->thumbnail) }}" class="img-thumbnail" style="max-height: 60px;">
                                <br><small class="text-muted">Current thumbnail</small>
                            </div>
                        @endif
                        <input type="file" 
                               class="form-control @error('thumbnail') is-invalid @enderror" 
                               id="thumbnail" 
                               name="thumbnail" 
                               accept="image/*">
                        <div class="form-text">Leave empty to keep current. Recommended: 400x300px</div>
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
                        <i class="bi bi-check-circle"></i> Update Event
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary w-100">
                        Cancel
                    </a>
                </div>
            </div>
            
            <!-- Danger Zone -->
            <div class="card card-admin mt-4 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle"></i> Danger Zone
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Once deleted, this event and all its images cannot be recovered.</p>
                    <button type="button" 
                            class="btn btn-outline-danger w-100" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteEventModal">
                        <i class="bi bi-trash"></i> Delete Event
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Delete Event Modal -->
<div class="modal fade" id="deleteEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete "<strong>{{ $event->title_en }}</strong>"?</p>
                <p class="text-danger mb-0">
                    <i class="bi bi-exclamation-triangle"></i> 
                    This will permanently delete the event and {{ $event->eventimages->count() }} associated images.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Yes, Delete Event
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

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
                    img.style.maxHeight = '80px';
                    preview.appendChild(img);
                    
                    const label = document.createElement('small');
                    label.className = 'text-success d-block';
                    label.textContent = 'New image selected';
                    preview.appendChild(label);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    
    // Preview for new event images
    document.getElementById('event_images').addEventListener('change', function(e) {
        const container = document.getElementById('new-image-preview-container');
        container.innerHTML = '';
        
        if (this.files.length > 0) {
            const heading = document.createElement('div');
            heading.className = 'col-12';
            heading.innerHTML = '<small class="text-success"><i class="bi bi-check-circle"></i> ' + this.files.length + ' new image(s) selected:</small>';
            container.appendChild(heading);
        }
        
        Array.from(this.files).forEach(function(file, index) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-3';
                col.innerHTML = `
                    <div class="border rounded p-2">
                        <img src="${e.target.result}" class="img-fluid rounded" style="height: 60px; width: 100%; object-fit: cover;">
                    </div>
                `;
                container.appendChild(col);
            }
            reader.readAsDataURL(file);
        });
    });
});
</script>
@endpush
@endsection