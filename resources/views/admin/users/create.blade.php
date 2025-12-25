@extends('admin.layout')

@section('title', 'Create New User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Create New User</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
        Back to Users
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">User Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Assign Roles</label>
                        <div class="row">
                            @foreach($roles as $role)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="role{{ $role->id }}" name="roles[]" value="{{ $role->id }}"
                                           {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role{{ $role->id }}">
                                        <strong>{{ $role->name }}</strong>
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
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="bi bi-person-plus"></i>
                            Create User
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
                    <i class="bi bi-info-circle"></i>
                    Information
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>Password Requirements:</h6>
                    <ul class="small text-muted mb-0">
                        <li>Minimum 8 characters</li>
                        <li>Must match confirmation</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6>Available Roles:</h6>
                    <ul class="small mb-0">
                        @foreach($roles as $role)
                        <li>
                            <strong>{{ $role->name }}</strong>
                            @if($role->description)
                            <br><span class="text-muted">{{ $role->description }}</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="alert alert-info small mb-0">
                    <i class="bi bi-lightbulb"></i>
                    <strong>Tip:</strong> Users can have multiple roles. Choose roles based on their responsibilities.
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Show/hide password
document.addEventListener('DOMContentLoaded', function() {
    // Add password strength indicator if needed
    const passwordField = document.getElementById('password');
    const confirmField = document.getElementById('password_confirmation');
    
    confirmField.addEventListener('input', function() {
        if (passwordField.value !== confirmField.value) {
            confirmField.setCustomValidity('Passwords do not match');
        } else {
            confirmField.setCustomValidity('');
        }
    });
});
</script>
@endpush