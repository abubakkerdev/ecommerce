@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update User Information</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <div class="form-group mb-4 col-md-12">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $user_info->name }}" id="name">

                                                @error('name')
                                                    <div class="alert mt-3 alert-warning solid alert-dismissible fade show">
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                        <strong>Warning!</strong> {{ $message }}
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group mb-4 col-md-12">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" name="email" value="{{ old('email') ? old('email') : $user_info->email }}" id="email">

                                                @error('email')
                                                    <div class="alert mt-3 alert-warning solid alert-dismissible fade show">
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                        <strong>Warning!</strong> {{ $message }}
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group mb-4 col-md-12">
                                                <label for="old_password">Old Password</label>
                                                <input type="text" class="form-control" name="old_password" value="{{ old('old_password') }}" id="old_password">

                                                @error('old_password')
                                                    <div class="alert mt-3 alert-warning solid alert-dismissible fade show">
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                        <strong>Warning!</strong> {{ $message }}
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                    </div>
                                                @enderror

                                                @if (session()->has('old_password'))
                                                    <div class="alert mt-3 alert-warning solid alert-dismissible fade show">
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                        <strong>Warning!</strong> {{ session()->get('old_password') }}
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>


                                        <input type="hidden" name="user_id" value="{{ $user_info->id }}">

                                        <button type="submit" class="mt-1 btn btn-primary btn-sm">Update User</button>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <div class="form-group mb-4 col-md-12">
                                                <label class="text-label">Password</label>
                                                <div class="input-group transparent-append">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                                    </div>
                                                    <input type="password" class="form-control" id="dz-password" name="password" placeholder="Choose your new password..">
                                                    <div class="input-group-append show-pass ">
                                                        <span class="input-group-text ">
                                                            <i class="fa fa-eye-slash"></i>
                                                            <i class="fa fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                @error('password')
                                                    <div class="alert mt-3 alert-warning solid alert-dismissible fade show">
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                        <strong>Warning!</strong> {{ $message }}
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                    </div>
                                                @enderror

                                                @if (session()->has('pass_notUpdate'))
                                                    <div class="alert mt-3 alert-warning solid alert-dismissible fade show">
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                        <strong>Warning!</strong> {{ session()->get('pass_notUpdate') }}
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group mb-4 col-md-12">
                                                <label for="con_password">Confirm Password</label>
                                                <input type="password" class="form-control" name="con_password" value="{{ old('con_password') }}" id="con_password">

                                                @error('con_password')
                                                    <div class="alert mt-3 alert-warning solid alert-dismissible fade show">
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                        <strong>Warning!</strong> {{ $message }}
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                    </div>
                                                @enderror

                                                @if (session()->has('pass_error'))
                                                    <div class="alert mt-3 alert-warning solid alert-dismissible fade show">
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                        <strong>Warning!</strong> {{ session()->get('pass_error') }}
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="mb-1 ml-1 col-md-12">
                                                @if (!empty($user_info->profile))
                                                    <img src="{{ asset('backend/uploads/users/'.$user_info->profile) }}" width="100" class="mb-3" alt="">
                                                @endif
                                            </div>
                                            <div class="input-group mb-4 col-md-12">


                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" name="user_img" class="custom-file-input">
                                                    <label class="custom-file-label">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Browse</span>
                                                </div>

                                                @error('user_img')
                                                    <div class="alert mt-3 alert-warning solid alert-dismissible fade show">
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                        <strong>Warning!</strong> {{ $message }}
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('alertScripts')
    <script>
        jQuery(document).ready(function(){

            jQuery('.show-pass').on('click',function(){
                jQuery(this).toggleClass('active');
                if(jQuery('#dz-password').attr('type') == 'password'){
                    jQuery('#dz-password').attr('type','text');
                }else if(jQuery('#dz-password').attr('type') == 'text'){
                    jQuery('#dz-password').attr('type','password');
                }
            });
        });
    </script>
@endsection

