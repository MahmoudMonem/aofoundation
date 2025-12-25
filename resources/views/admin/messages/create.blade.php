@extends('admin.layout')

@section('title', 'Add Message')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Add New Message</h1>
    <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="card card-admin">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.messages.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" rows="5" class="form-control" required>{{ old('message') }}</textarea>
            </div>

            <button type="submit" class="btn btn-admin-primary">Save</button>
        </form>
    </div>
</div>
@endsection
