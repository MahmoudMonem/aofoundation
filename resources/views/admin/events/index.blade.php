@extends('admin.layout')

@section('title', 'All Events')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Events Management</h1>
    <a href="{{ route('admin.events.create') }}" class="btn btn-admin-primary">
        <i class="bi bi-plus-circle"></i> Create New Event
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card card-admin" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Total Events</h5>
                        <h2 class="mb-0">{{ $events->total() }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="bi bi-calendar-event fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card card-admin" style="background: linear-gradient(135deg, #198754, #20c997); color: white;">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Available</h5>
                        <h2 class="mb-0">{{ $events->where('available', 1)->count() }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="bi bi-check-circle fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card card-admin" style="background: linear-gradient(135deg, #f59e0b, #fbbf24); color: white;">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Featured</h5>
                        <h2 class="mb-0">{{ $events->where('featured', 1)->count() }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="bi bi-star fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card card-admin" style="background: linear-gradient(135deg, #6f42c1, #8b5cf6); color: white;">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Total Images</h5>
                        <h2 class="mb-0">{{ $events->sum(fn($e) => $e->eventimages->count()) }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="bi bi-images fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Events Table -->
<div class="card card-admin">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">All Events</h5>
        <span class="badge bg-primary">{{ $events->total() }} events</span>
    </div>
    <div class="card-body">
        @if($events->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th style="width: 80px;">Image</th>
                        <th>Title (EN)</th>
                        <th>Title (AR)</th>
                        <th style="width: 100px;">Images</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 100px;">Featured</th>
                        <th style="width: 120px;">Created</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr>
                        <td>{{ $event->id }}</td>
                        <td>
                            @php
                                $featuredImage = $event->eventimages->where('featured', 1)->first();
                            @endphp
                            @if($featuredImage)
                                <img src="{{ asset('events/' . $featuredImage->img) }}" 
                                     alt="{{ $event->title_en }}" 
                                     class="rounded" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            @elseif($event->thumbnail)
                                <img src="{{ asset('events/' . $event->thumbnail) }}" 
                                     alt="{{ $event->title_en }}" 
                                     class="rounded" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="bi bi-image text-white"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ Str::limit($event->title_en, 30) }}</strong>
                            @if($event->short_desc_en)
                                <br><small class="text-muted">{{ Str::limit($event->short_desc_en, 40) }}</small>
                            @endif
                        </td>
                        <td dir="rtl">{{ Str::limit($event->title_ar, 30) ?? '-' }}</td>
                        <td>
                            <span class="badge bg-info">{{ $event->eventimages->count() }} images</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.events.toggle-available', $event) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $event->available ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $event->available ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.events.toggle-featured', $event) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $event->featured ? 'btn-warning' : 'btn-outline-warning' }}">
                                    <i class="bi bi-star{{ $event->featured ? '-fill' : '' }}"></i>
                                </button>
                            </form>
                        </td>
                        <td>{{ $event->created_at->format('M j, Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.events.show', $event) }}" 
                                   class="btn btn-sm btn-outline-info" 
                                   title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.events.edit', $event) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $event->id }}"
                                        title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $event->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete "<strong>{{ $event->title_en }}</strong>"?
                                            <br><br>
                                            <small class="text-danger">This will also delete {{ $event->eventimages->count() }} associated images.</small>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete Event</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $events->links() }}
        </div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-calendar-x fs-1 mb-3 d-block"></i>
            <h5>No Events Found</h5>
            <p>Get started by creating your first event.</p>
            <a href="{{ route('admin.events.create') }}" class="btn btn-admin-primary">
                <i class="bi bi-plus-circle"></i> Create Event
            </a>
        </div>
        @endif
    </div>
</div>
@endsection