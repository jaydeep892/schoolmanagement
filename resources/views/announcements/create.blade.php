@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Announcement</h2>

    <form action="{{ route('announcements.store') }}" method="POST">
        @csrf   
        <div class="mb-3">
            <label for="announcement">Announcement</label>
            <textarea name="announcement" id="announcement" class="form-control" required>{{ old('announcement') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="announcement_type">Announcement Type</label>
            <select name="announcement_type" id="announcement_type" class="form-control" required>
                <option value="">Select Type</option>    
                @if (auth()->user()->hasRole('admin'))
                    <option value="0" 'selected'>Teacher</option>
                @else
                    <option value="1" {{ old('announcement_type') == 'Students' ? 'selected' : '' }}>Students</option>
                    <option value="2" {{ old('announcement_type') == 'Parents' ? 'selected' : '' }}>Parents</option>
                    <option value="3" {{ old('announcement_type') == 'Both' ? 'selected' : '' }}>Both</option>
                @endif
            </select>
        </div>

        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection
