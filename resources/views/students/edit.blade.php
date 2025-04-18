@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Student</h2>

    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Student Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $student->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Student Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $student->email) }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent</label>
            <select class="form-select" name="parent_id">
                <option value="">-- Select Parent --</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id', $student->parent_id) == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
