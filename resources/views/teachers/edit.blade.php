@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Teacher</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
        </div>
    @endif

    <form action="{{ route('teachers.update', $teacher) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $teacher->name }}" class="form-control" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $teacher->email }}" class="form-control" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary"> Cancel </a>

    </form>
</div>
@endsection
