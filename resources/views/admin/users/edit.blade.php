@extends('admin.layout')

@section('title', 'Edit User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit User: {{ $user->name }}</h1>
    <div>
        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-info me-2">
            <i class="bi bi-eye"></i>
            View User
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Back to Users
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">User Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Leave blank to keep current password">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" 
                                       placeholder="Confirm new password">
                            </div>
                        </div>
                    </div>
                    
                    @if(Auth::user()->hasRole('Admin'))
                    <div class="mb-3">
                        <label class="form-label">Assign Roles</label>
                        <div class="row">
                            @foreach($roles as $role)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="role{{ $role->id }}" name="roles[]" value="{{ $role->id }}"
                                           {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}
                                           {{ $user->id === auth()->id() && $role->name === 'Admin' ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="role{{ $role->id }}">
                                        <strong>{{ $role->name }}</strong>
                                        @if($user->id === auth()->id() && $role->name === 'Admin')
                                        <small class="text-muted">(Cannot remove your own admin role)</small>
                                        @endif
                                        @if($role->description)
                                        <br><small class="text-muted">{{ $role->description }}</small>
                                        @endif
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @error('roles')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                        
                        <!-- Hidden input to maintain admin role for current user -->
                        @if($user->id === auth()->id() && $user->hasRole('Admin'))
                        <input type="hidden" name="roles[]" value="{{ $roles->where('name', 'Admin')->first()->id }}">
                        @endif
                    </div>
                    @endif
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="bi bi-check-circle"></i>
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card card-admin">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-person-circle"></i>
                    User Details
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>User ID:</strong> #{{ $user->id }}
                </div>
                <div class="mb-3">
                    <strong>Joined:</strong> {{ $user->created_at->format('M j, Y g:i A') }}
                </div>
                <div class="mb-3">
                    <strong>Last Updated:</strong> {{ $user->updated_at->format('M j, Y g:i A') }}
                </div>
                <div class="mb-3">
                    <strong>Email Status:</strong>
                    @if($user->email_verified_at)
                        <span class="badge bg-success">Verified</span>
                    @else
                        <span class="badge bg-warning">Unverified</span>
                    @endif
                </div>
                <div class="mb-3">
                    <strong>Current Roles:</strong><br>
                    @forelse($user->roles as $role)
                        <span class="badge bg-secondary me-1 mb-1">{{ $role->name }}</span>
                    @empty
                        <span class="text-muted">No roles assigned</span>
                    @endforelse
                </div>
            </div>
        </div>
        
        <div class="card card-admin mt-3">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i>
                    Information
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info small mb-3">
                    <i class="bi bi-lightbulb"></i>
                    <strong>Password:</strong> Leave password fields blank to keep the current password unchanged.
                </div>
                
                @if($user->id === auth()->id())
                <div class="alert alert-warning small mb-3">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Note:</strong> You are editing your own account. You cannot remove your Admin role.
                </div>
                @endif
                
                @if(Auth::user()->hasRole('Admin'))
                <div class="mb-3">
                    <h6>Available Actions:</h6>
                    <ul class="small mb-0">
                        <li>Update user information</li>
                        <li>Change password</li>
                        <li>Modify role assignments</li>
                        @if($user->id !== auth()->id())
                        <li>Delete user account</li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>
        </div>
        
        @if(Auth::user()->hasRole('Admin') && $user->id !== auth()->id())
        <div class="card card-admin mt-3 border-danger">
            <div class="card-header bg-danger bg-opacity-10">
                <h6 class="card-title mb-0 text-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    Danger Zone
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Permanently delete this user account. This action cannot be undone.</p>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                      onsubmit="return confirm('Are you sure you want to delete {{ $user->name }}? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                        Delete User
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const confirmField = document.getElementById('password_confirmation');
    
    function validatePasswords() {
        if (passwordField.value || confirmField.value) {
            if (passwordField.value !== confirmField.value) {
                confirmField.setCustomValidity('Passwords do not match');
            } else {
                confirmField.setCustomValidity('');
            }
        } else {
            confirmField.setCustomValidity('');
        }
    }
    
    passwordField.addEventListener('input', validatePasswords);
    confirmField.addEventListener('input', validatePasswords);
});
</script>
@endpush