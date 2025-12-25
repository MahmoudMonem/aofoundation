@extends('admin.layout')

@section('title', 'View Event')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">{{ $event->title_en }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                <li class="breadcrumb-item active">View</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-admin-primary me-2">
            <i class="bi bi-pencil"></i> Edit Event
        </a>
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Events
        </a>
    </div>
</div>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Cover Image -->
        @if($event->cover)
        <div class="card card-admin mb-4">
            <img src="{{ asset('events/' . $event->cover) }}" class="card-img-top" alt="Cover" style="max-height: 300px; object-fit: cover;">
        </div>
        @endif
        
        <!-- Event Details -->
        <div class="card card-admin mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle text-primary"></i> Event Details
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-1">Title (English)</h6>
                        <p class="mb-3">{{ $event->title_en }}</p>
                        
                        <h6 class="text-muted mb-1">Short Description (English)</h6>
                        <p class="mb-3">{{ $event->short_desc_en ?: 'Not set' }}</p>
                        
                        <h6 class="text-muted mb-1">Full Description (English)</h6>
                        <p class="mb-0">{{ $event->desc_en ?: 'Not set' }}</p>
                    </div>
                    <div class="col-md-6" dir="rtl">
                        <h6 class="text-muted mb-1">Title (Arabic)</h6>
                        <p class="mb-3">{{ $event->title_ar ?: 'Not set' }}</p>
                        
                        <h6 class="text-muted mb-1">Short Description (Arabic)</h6>
                        <p class="mb-3">{{ $event->short_desc_ar ?: 'Not set' }}</p>
                        
                        <h6 class="text-muted mb-1">Full Description (Arabic)</h6>
                        <p class="mb-0">{{ $event->desc_ar ?: 'Not set' }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Event Gallery -->
        <div class="card card-admin mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-images text-primary"></i> Event Gallery
                </h5>
                <span class="badge bg-info">{{ $event->eventimages->count() }} images</span>
            </div>
            <div class="card-body">
                @if($event->eventimages->count() > 0)
                    @php
                        $featuredImage = $event->eventimages->where('featured', 1)->first();
                        $nonFeaturedImages = $event->eventimages->where('featured', '!=', 1);
                    @endphp
                    
                    <!-- Featured Image -->
                    @if($featuredImage)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">
                            <i class="bi bi-star-fill text-warning"></i> Featured Image
                        </h6>
                        <div class="position-relative d-inline-block">
                            <img src="{{ asset('events/' . $featuredImage->img) }}" 
                                 class="img-fluid rounded shadow" 
                                 alt="Featured Image"
                                 style="max-height: 300px;">
                            <span class="badge bg-warning position-absolute top-0 start-0 m-2">Featured</span>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Other Images -->
                    @if($nonFeaturedImages->count() > 0)
                    <h6 class="text-muted mb-2">Other Images</h6>
                    <div class="row g-3">
                        @foreach($nonFeaturedImages as $image)
                        <div class="col-md-3 col-sm-4 col-6">
                            <a href="{{ asset('events/' . $image->img) }}" target="_blank">
                                <img src="{{ asset('events/' . $image->img) }}" 
                                     class="img-fluid rounded shadow-sm" 
                                     alt="Event Image"
                                     style="height: 120px; width: 100%; object-fit: cover;">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                @else
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-images fs-1 mb-2 d-block"></i>
                    <p>No gallery images</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Preview Carousel (as it appears on frontend) -->
        @if($event->eventimages->count() > 0)
        <div class="card card-admin mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-phone text-primary"></i> Frontend Preview
                </h5>
            </div>
            <div class="card-body">
                <div id="carousel-preview" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @php
                            $featuredImage = $event->eventimages->where('featured', 1)->first();
                            $nonFeaturedImages = $event->eventimages->where('featured', '!=', 1);
                        @endphp
                        
                        @if($featuredImage)
                        <div class="carousel-item active">
                            <img src="{{ asset('events/' . $featuredImage->img) }}" class="d-block w-100" style="max-height: 250px; object-fit: cover;">
                        </div>
                        @endif
                        
                        @foreach($nonFeaturedImages as $index => $image)
                        <div class="carousel-item {{ !$featuredImage && $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('events/' . $image->img) }}" class="d-block w-100" style="max-height: 250px; object-fit: cover;">
                        </div>
                        @endforeach
                    </div>
                    
                    @if($event->eventimages->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-preview" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-preview" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
                    </button>
                    @endif
                </div>
                <div class="text-center mt-3">
                    <p class="fw-bold mb-1">{{ $event->title_en }}</p>
                    <p class="text-muted small">{{ $event->short_desc_en }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Status Card -->
        <div class="card card-admin mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-toggle-on text-primary"></i> Status
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Availability:</span>
                    @if($event->available)
                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> Active</span>
                    @else
                        <span class="badge bg-secondary"><i class="bi bi-x-circle"></i> Inactive</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Featured:</span>
                    @if($event->featured)
                        <span class="badge bg-warning"><i class="bi bi-star-fill"></i> Featured</span>
                    @else
                        <span class="badge bg-secondary"><i class="bi bi-star"></i> Not Featured</span>
                    @endif
                </div>
                <hr>
                <div class="d-flex gap-2">
                    <form action="{{ route('admin.events.toggle-available', $event) }}" method="POST" class="flex-grow-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $event->available ? 'btn-outline-secondary' : 'btn-success' }} w-100">
                            {{ $event->available ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.events.toggle-featured', $event) }}" method="POST" class="flex-grow-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $event->featured ? 'btn-outline-secondary' : 'btn-warning' }} w-100">
                            {{ $event->featured ? 'Unfeature' : 'Feature' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Info Card -->
        <div class="card card-admin mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle text-primary"></i> Information
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted">ID:</td>
                        <td>{{ $event->id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Slug:</td>
                        <td><code>{{ $event->slug }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Organizer ID:</td>
                        <td>{{ $event->organizer_id ?: 'Not set' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Created:</td>
                        <td>{{ $event->created_at->format('M j, Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Updated:</td>
                        <td>{{ $event->updated_at->format('M j, Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Images:</td>
                        <td>{{ $event->eventimages->count() }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Main Images Card -->
        <div class="card card-admin mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-image text-primary"></i> Main Images
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <h6 class="text-muted small">Logo</h6>
                        @if($event->logo)
                            <img src="{{ asset('events/' . $event->logo) }}" class="img-thumbnail" style="max-height: 80px;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-6">
                        <h6 class="text-muted small">Thumbnail</h6>
                        @if($event->thumbnail)
                            <img src="{{ asset('events/' . $event->thumbnail) }}" class="img-thumbnail" style="max-height: 80px;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions Card -->
        <div class="card card-admin">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning text-primary"></i> Actions
                </h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-admin-primary w-100 mb-2">
                    <i class="bi bi-pencil"></i> Edit Event
                </a>
                <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash"></i> Delete Event
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
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
@endsection