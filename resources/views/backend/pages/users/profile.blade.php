@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">User Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="profile-personal-info">
                                <h4 class="text-primary mb-4">Personal Information &nbsp; &nbsp;
                                    <a href="{{ route('user.edit', Auth::id()) }}" title="Edit user info." class="btn btn-primary shadow btn-xs sharp mr-1">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </h4>

                                <div class="row mb-2">
                                    <div class="col-sm-3 col-5">
                                        <h5 class="f-w-500">Name <span class="pull-right">:</span>
                                        </h5>
                                    </div>
                                    <div class="col-sm-9 col-7"><span>{{ Auth::user()->name }}</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-3 col-5">
                                        <h5 class="f-w-500">Email <span class="pull-right">:</span>
                                        </h5>
                                    </div>
                                    <div class="col-sm-9 col-7"><span>{{ Auth::user()->email }}</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-3 col-5">
                                        <h5 class="f-w-500">Registration Date<span class="pull-right">:</span></h5>
                                    </div>
                                    <div class="col-sm-9 col-7"><span>{{ Auth::user()->created_at->format("F j, Y") }}</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-3 col-5">
                                        <h5 class="f-w-500">User Status <span class="pull-right">:</span>
                                        </h5>
                                    </div>
                                    <div class="col-sm-9 col-7"><span><div class="d-flex align-items-center">Active &nbsp; <i class="fa fa-circle text-success mr-1"></i> </div></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-3 col-5">
                                        <h5 class="f-w-500">User Role <span class="pull-right">:</span></h5>
                                    </div>
                                    <div class="col-sm-9 col-7"><span>Super Admin</span>
                                    </div>
                                </div>
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
    
@endsection
