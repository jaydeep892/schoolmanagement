@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📢 Announcements</h1>
    @php 
        $announcements = \App\Models\Announcement::where('announcement_type',0)->latest()->get();
    @endphp
    @if($announcements->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($announcements as $announcement)
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all duration-300 border border-gray-100">
                    <h2 class="text-xl font-semibold text-indigo-700 mb-2">
                        {{ $announcement->announcement_type_label }} Announcement
                    </h2>
                    <p class="text-gray-600 text-sm mb-4">
                        {{ $announcement->announcement }}
                    </p>
                    <div class="text-gray-400 text-xs">
                        Posted on {{ $announcement->created_at->format('d M, Y') }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded-xl text-center shadow-sm">
            No announcements available at the moment.
        </div>
    @endif
</div>
@endsection
