@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Announcement</h2>

    <form action="{{ route('announcements.update', $announcement->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="announcement">Announcement</label>
            <textarea name="announcement" id="announcement" class="form-control" required>{{ old('announcement', $announcement->announcement) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="announcement_type">Announcement Type</label>
            <select name="announcement_type" id="announcement_type" class="form-control" required>
                @if (auth()->user()->hasRole('admin'))
                    <option value="0" 'selected'>Teacher</option>
                @else
                    <option value="1" {{ $announcement->announcement_type == 'Students' ? 'selected' : '' }}>Students</option>
                    <option value="2" {{ $announcement->announcement_type == 'Parents' ? 'selected' : '' }}>Parents</option>
                    <option value="3" {{ $announcement->announcement_type == 'Both' ? 'selected' : '' }}>Both</option>
                @endif
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
