@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>👨‍🏫 Parents List</h2>
        @if(auth()->user()->hasRole('teacher'))
            <a href="{{ route('parents.create') }}" class="btn btn-success">Add Parent</a>
        @endif
    </div>

    <table id="parents-table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
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
    var table = $('#parents-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('parents.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $(document).on('click', '.delete-btn', function () {
        var id = $(this).data('id');
        if (confirm("Are you sure you want to delete this teacher?")) {
            $.ajax({
                url: '/parents/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('#teachers-table').DataTable().ajax.reload();
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
