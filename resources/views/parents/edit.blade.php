@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Parent</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
        </div>
    @endif
    <form action="{{ route('parents.update', $parent->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Parent Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $parent->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Parent Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $parent->email) }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('parents.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
