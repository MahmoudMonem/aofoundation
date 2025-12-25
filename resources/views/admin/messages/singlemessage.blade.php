@extends('admin.layout')

@section('title', 'View Message')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Message Details</h1>
    <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="card card-admin">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9">{{ $message->name }}</dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $message->email }}</dd>

            <dt class="col-sm-3">Message</dt>
            <dd class="col-sm-9">{{ $message->message }}</dd>

            <dt class="col-sm-3">Created At</dt>
            <dd class="col-sm-9">
                {{ \Carbon\Carbon::parse($message->created_at)->format('F j, Y g:i A') }}
                <small class="text-muted">({{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }})</small>
            </dd>
        </dl>
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('admin.messages.edit', $message->id) }}" class="btn btn-admin-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger" 
                    onclick="return confirm('Are you sure you want to delete this message?')">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    </div>
</div>
@endsection
