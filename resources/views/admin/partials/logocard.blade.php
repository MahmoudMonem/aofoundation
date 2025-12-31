<div class="col-md-3 col-sm-6 logo-card-wrapper" data-id="{{ $logo->id }}">
    <div class="logo-card {{ !$logo->is_active ? 'inactive' : '' }}">
        <div class="d-flex align-items-center mb-2">
            <i class="bi bi-grip-vertical drag-handle fs-5 me-2"></i>
            <img src="{{ asset($logo->logo) }}" alt="{{ $logo->name }}" class="logo-preview flex-grow-1">
        </div>
        
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong class="d-block small">{{ $logo->name }}</strong>
                <span class="badge {{ $logo->is_active ? 'bg-success' : 'bg-secondary' }} badge-sm">
                    {{ $logo->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-primary" 
                        onclick="editLogo({{ $logo->id }}, '{{ $logo->name }}', '{{ $logo->logo }}', {{ $logo->row }}, {{ $logo->is_active ? 'true' : 'false' }})"
                        title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                
                <button type="button" class="btn btn-outline-{{ $logo->is_active ? 'warning' : 'success' }}" 
                        onclick="toggleActive({{ $logo->id }})"
                        title="{{ $logo->is_active ? 'Deactivate' : 'Activate' }}">
                    <i class="bi bi-{{ $logo->is_active ? 'eye-slash' : 'eye' }}"></i>
                </button>
                
                <form action="{{ route('admin.client-logos.destroy', $logo) }}" method="POST" class="d-inline" 
                      onsubmit="return confirm('Are you sure you want to delete this logo?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>