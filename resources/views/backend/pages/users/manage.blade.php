@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All User List </h4>
                            <div style="color: black;"> Total User ({{ $total_user }})</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-responsive-sm mb-4">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th scope="col">#SL</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Profile</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Updated At</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $key => $user)
                                            <tr>
                                                <th scope="row">{{ $users->firstItem()+$key }}</th>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td class="sorting_1">
                                                    @if (!empty($user->profile))
                                                        <img class="rounded-circle" width="70" src="{{ asset('backend/uploads/users/'.$user->profile) }}" alt="">
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $user->created_at->diffForHumans() }}
                                                </td>
                                                <td>
                                                    {{ ($user->updated_at == NULL) ? 'N/A' : $user->updated_at->diffForHumans() }}
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>

                                                        <a id="{{ route('user.delete', $user->id) }}" class="btn btn-danger delete_user shadow btn-xs sharp">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No data found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('alertScripts')

    @if (session()->has('update'))
        <script>
            $.toast({
                heading: 'Update successful',
                text: '{{ session()->get("update") }}',
                icon: 'info',
                position: 'top-right',
                hideAfter: 2500,
                showHideTransition: 'slide'
            });
        </script>
    @endif

    <script>
        $(".delete_user").click(function() {
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = $(this).attr('id');
            }
            });
        });
	</script>

    @if (session()->has('delete_user'))
        <script>
            Swal.fire(
                'Success',
                'Your file has been deleted.',
                'success'
            );
        </script>
    @endif

@endsection
