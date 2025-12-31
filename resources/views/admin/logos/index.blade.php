@extends('admin.layout')

@section('title', 'Client Logos Management')

@push('styles')
<style>
    .logo-card {
        border: 1px solid #e2e2e2;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        background: #fff;
        transition: all 0.3s;
    }
    
    .logo-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .logo-card.inactive {
        opacity: 0.5;
        background: #f5f5f5;
    }
    
    .logo-preview {
        max-width: 120px;
        max-height: 60px;
        object-fit: contain;
        background: #c9c9c9;
        padding: 10px;
        border-radius: 4px;
    }
    
    .sortable-ghost {
        opacity: 0.4;
        background: #fff3cd;
    }
    
    .drag-handle {
        cursor: grab;
        color: #999;
    }
    
    .drag-handle:active {
        cursor: grabbing;
    }
    
    .row-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .row-title {
        color: var(--admin-primary, #ad715c);
        border-bottom: 2px solid var(--admin-primary, #ad715c);
        padding-bottom: 10px;
        margin-bottom: 20px;
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
    
    .upload-zone {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        background: #fafafa;
        transition: all 0.3s;
    }
    
    .upload-zone:hover {
        border-color: var(--admin-primary, #ad715c);
        background: #fff5f0;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Client Logos Management</h1>
        <p class="text-muted mb-0">Manage client logos displayed on the homepage carousel</p>
    </div>
    <button type="button" class="btn btn-admin-primary" data-bs-toggle="modal" data-bs-target="#addLogoModal">
        <i class="bi bi-plus-circle"></i> Add New Logo
    </button>
</div>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center p-3">
            <h4 class="mb-1">{{ $row1Logos->count() + $row2Logos->count() }}</h4>
            <small class="text-muted">Total Logos</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3">
            <h4 class="mb-1">{{ $row1Logos->count() }}</h4>
            <small class="text-muted">Row 1 Logos</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3">
            <h4 class="mb-1">{{ $row2Logos->count() }}</h4>
            <small class="text-muted">Row 2 Logos</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3">
            <h4 class="mb-1">{{ $row1Logos->where('is_active', true)->count() + $row2Logos->where('is_active', true)->count() }}</h4>
            <small class="text-muted">Active Logos</small>
        </div>
    </div>
</div>

<!-- Row 1 Logos -->
<div class="row-section">
    <h5 class="row-title">
        <i class="bi bi-1-circle me-2"></i>Row 1 - First Carousel Line
    </h5>
    
    @if($row1Logos->isEmpty())
        <div class="text-center text-muted py-4">
            <i class="bi bi-image fs-1"></i>
            <p class="mt-2">No logos in Row 1. Add your first logo!</p>
        </div>
    @else
        <div id="sortable-row1" class="row">
            @foreach($row1Logos as $logo)
                @include('admin.partials.logocard', ['logo' => $logo])
            @endforeach
        </div>
    @endif
</div>

<!-- Row 2 Logos -->
<div class="row-section">
    <h5 class="row-title">
        <i class="bi bi-2-circle me-2"></i>Row 2 - Second Carousel Line
    </h5>
    
    @if($row2Logos->isEmpty())
        <div class="text-center text-muted py-4">
            <i class="bi bi-image fs-1"></i>
            <p class="mt-2">No logos in Row 2. Add your first logo!</p>
        </div>
    @else
        <div id="sortable-row2" class="row">
            @foreach($row2Logos as $logo)
                @include('admin.partials.logocard', ['logo' => $logo])
            @endforeach
        </div>
    @endif
</div>

<!-- Add Logo Modal -->
<div class="modal fade" id="addLogoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Client Logo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.client-logos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Client Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g., Novartis">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Logo Image <span class="text-danger">*</span></label>
                        <input type="file" name="logo" class="form-control" accept="image/*" required>
                        <small class="text-muted">Recommended: PNG with transparent background, max 2MB</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Display Row <span class="text-danger">*</span></label>
                        <select name="row" class="form-select" required>
                            <option value="1">Row 1 - First Carousel Line</option>
                            <option value="2">Row 2 - Second Carousel Line</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-admin-primary">
                        <i class="bi bi-check-circle"></i> Add Logo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Logo Modal -->
<div class="modal fade" id="editLogoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Client Logo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editLogoForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img id="editLogoPreview" src="" alt="Logo Preview" class="logo-preview">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Client Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">New Logo Image (optional)</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                        <small class="text-muted">Leave empty to keep current logo</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Display Row <span class="text-danger">*</span></label>
                        <select name="row" id="editRow" class="form-select" required>
                            <option value="1">Row 1 - First Carousel Line</option>
                            <option value="2">Row 2 - Second Carousel Line</option>
                        </select>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="editActive" class="form-check-input" value="1">
                        <label class="form-check-label" for="editActive">Active (visible on website)</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-admin-primary">
                        <i class="bi bi-check-circle"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sortable for Row 1
    const row1El = document.getElementById('sortable-row1');
    if (row1El) {
        new Sortable(row1El, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                updateSortOrder('sortable-row1');
            }
        });
    }
    
    // Initialize sortable for Row 2
    const row2El = document.getElementById('sortable-row2');
    if (row2El) {
        new Sortable(row2El, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                updateSortOrder('sortable-row2');
            }
        });
    }
    
    // Update sort order via AJAX
    function updateSortOrder(containerId) {
        const container = document.getElementById(containerId);
        const items = container.querySelectorAll('.logo-card-wrapper');
        const logos = [];
        
        items.forEach((item, index) => {
            logos.push({
                id: item.dataset.id,
                sort_order: index + 1
            });
        });
        
        fetch('{{ route("admin.client-logos.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ logos: logos })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Optional: show success toast
            }
        })
        .catch(error => console.error('Error:', error));
    }
    
    // Edit logo modal
    window.editLogo = function(id, name, logo, row, isActive) {
        document.getElementById('editLogoForm').action = `/admin/client-logos/${id}`;
        document.getElementById('editName').value = name;
        document.getElementById('editLogoPreview').src = '/' + logo;
        document.getElementById('editRow').value = row;
        document.getElementById('editActive').checked = isActive;
        
        new bootstrap.Modal(document.getElementById('editLogoModal')).show();
    };
    
    // Toggle active status
    window.toggleActive = function(id) {
        fetch(`/admin/client-logos/${id}/toggle-active`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    };
});
</script>
@endpush