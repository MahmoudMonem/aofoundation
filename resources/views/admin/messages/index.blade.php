@extends('admin.layout')

@section('title', 'Messages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Messages</h1>
    <a href="{{ route('admin.messages.create') }}" class="btn btn-admin-primary">
        <i class="bi bi-plus"></i>
        Add New Message
    </a>
</div>

<!-- Filters -->
<div class="card card-admin mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.messages.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control"
                       value="{{ request('search') }}"
                       placeholder="Search by name, email or message...">
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
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Messages Table -->
<div class="card card-admin">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Messages ({{ $messages->total() }})</h5>
        <div class="text-muted">
            Showing {{ $messages->firstItem() }}-{{ $messages->lastItem() }} of {{ $messages->total() }}
        </div>
    </div>
    <div class="card-body p-0">
        @if($messages->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Created</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                    <tr>
                        <td>
                        <a href="{{ route('admin.singlemessage.index', $message->id) }}" class="btn btn-outline-primary">
                        <i class="bi bi-eye"></i>
                        </a>
                        </td>
                        <td>
                        <a href="{{ route('admin.messages.edit', $message) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil"></i>
                        </a>
                        </td>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ Str::limit($message->message, 50) }}</td>
                        <td>{{ $message->created_at->format('M j, Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">

                                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"
                                            onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
		
		
  <div class="card-footer bg-white">
    {{ $messages->links('pagination::bootstrap-4') }}
</div>


        @else
        <div class="text-center py-5">
            <i class="bi bi-chat fs-1 text-muted mb-3"></i>
            <h5 class="text-muted">No messages found</h5>
        </div>
        @endif
    </div>
</div>
@endsection
