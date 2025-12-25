@extends('admin.layout')

@section('title', 'Users Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Users Management</h1>
    @if(Auth::user()->hasRole('Admin'))
    <a href="{{ route('admin.users.create') }}" class="btn btn-admin-primary">
        <i class="bi bi-person-plus"></i>
        Add New User
    </a>
    @endif
</div>

<!-- Filters -->
<div class="card card-admin mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" 
                       value="{{ request('search') }}" 
                       placeholder="Search by name or email...">
            </div>
            <div class="col-md-3">
                <label class="form-label">Filter by Role</label>
                <select name="role" class="form-select">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" 
                            {{ request('role') === $role->name ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card card-admin">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Users ({{ $users->total() }})</h5>
        <div class="text-muted">
            Showing {{ $users->firstItem() }}-{{ $users->lastItem() }} of {{ $users->total() }}
        </div>
    </div>
    <div class="card-body p-0">
        @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-3" 
                                     style="width: 40px; height: 40px;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                    <small class="text-primary">(You)</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @forelse($user->roles as $role)
                                <span class="badge bg-secondary me-1">{{ $role->name }}</span>
                                @if(Auth::user()->hasRole('Admin') && $user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.remove-role', [$user, $role]) }}" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger ms-1"
                                            onclick="return confirm('Remove {{ $role->name }} role from {{ $user->name }}?')"
                                            title="Remove role">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </form>
                                @endif
                            @empty
                                <span class="text-muted">No roles assigned</span>
                            @endforelse
                            
                            @if(Auth::user()->hasRole('Admin') && $user->id !== auth()->id())
                            <!-- Add Role Button -->
                            <button type="button" class="btn btn-sm btn-outline-success ms-2" 
                                    data-bs-toggle="modal" data-bs-target="#assignRoleModal{{ $user->id }}">
                                <i class="bi bi-plus"></i>
                            </button>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M j, Y') }}</td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">

                                
                                @if(Auth::user()->hasRole('Admin','Operations Manager'))
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif
                                
                                @if(Auth::user()->hasRole('Admin') && $user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete"
                                            onclick="return confirm('Are you sure you want to delete {{ $user->name }}?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Assign Role Modal -->
                    @if(Auth::user()->hasRole('Admin') && $user->id !== auth()->id())
                    <div class="modal fade" id="assignRoleModal{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Assign Role to {{ $user->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('admin.users.assign-role', $user) }}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Select Role</label>
                                            <select name="role_id" class="form-select" required>
                                                <option value="">Choose a role...</option>
                                                @foreach($roles as $role)
                                                    @if(!$user->roles->contains($role))
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-admin-primary">
                                            Assign Role
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
        <div class="card-footer bg-white">
            {{ $users->links() }}
        </div>
        @endif
        
        @else
        <div class="text-center py-5">
            <i class="bi bi-people fs-1 text-muted mb-3"></i>
            <h5 class="text-muted">No users found</h5>
            <p class="text-muted">Try adjusting your search criteria.</p>
        </div>
        @endif
    </div>
</div>

@endsection