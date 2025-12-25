@extends('admin.layout')

@section('title', 'Edit Role')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Role</h1>
    <a href="{{ route('adminAllRoles') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="card card-admin">
    <div class="card-body">
        <form action="{{ route('roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Role Name</label>
                <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
            </div>
            <button type="submit" class="btn btn-admin-primary">
                <i class="bi bi-check-circle"></i> Update Role
            </button>
        </form>
    </div>
</div>
@endsection
