@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>👨‍🏫 Announcements List</h2>
        <a href="{{ route('announcements.create') }}" class="btn btn-success">Add Announcement</a>
    </div>

    <table id="announcements-table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Announcement</th>
                <th>Type</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
  $(function () {
    var table = $('#announcements-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('announcements.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'announcement', name: 'announcement'},
            {data: 'announcement_type_label', name: 'announcement_type_label'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $(document).on('click', '.delete-btn', function () {
        var id = $(this).data('id');
        if (confirm("Are you sure you want to delete this teacher?")) {
            $.ajax({
                url: '/announcements/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('#announcements-table').DataTable().ajax.reload();
                },
                error: function (xhr) {
                    alert('Delete failed');
                }
            });
        }
    });

  });
</script>
@endsection
