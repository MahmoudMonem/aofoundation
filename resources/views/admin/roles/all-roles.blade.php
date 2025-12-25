@extends('admin.layout')

@section('title', 'All Roles')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">All Roles</h1>
    <a href="{{ route('roles.create') }}" class="btn btn-admin-primary">
        <i class="bi bi-plus-circle"></i> Add Role
    </a>
</div>

<div class="card card-admin">
    <div class="card-body">
        @if($roles->count())
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Edit</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>
                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->created_at ? $role->created_at->format('M j, Y') : '-' }}</td>
                        <td>{{ $role->updated_at ? $role->updated_at->format('M j, Y') : '-' }}</td>
                        <td>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this role?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $roles->links() }}
        </div>
        @else
        <div class="text-center py-4 text-muted">
            <i class="bi bi-shield fs-1 mb-2"></i>
            <p>No roles found</p>
        </div>
        @endif
    </div>
</div>
@endsection
