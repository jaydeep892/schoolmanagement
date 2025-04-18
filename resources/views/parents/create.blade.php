@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Parent</h2>

    <form action="{{ route('parents.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Parent Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Parent Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('parents.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
