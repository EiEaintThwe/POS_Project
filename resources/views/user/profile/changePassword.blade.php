@extends('user.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid fruite py-5 mt-5">
        <div class="container py-5">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="">
                    <div class="row">
                        <div class="col-8 offset-2">

                            <div class="card">
                                <div class="card-body shadow">
                                    <form action="{{ route('user#changePassword') }}" method="post" class="p-3 rounded">
                                        @csrf

                                        @if (Auth::user()->password != null)
                                          <div class="mb-3">
                                            <label class="form-label">Old Password</label>
                                            <input type="password" name="oldPassword"
                                                class="form-control @error('oldPassword') is-invalid @enderror"
                                                placeholder="Enter Old Password...">
                                            @error('oldPassword')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror

                                        </div>

                                        @endif

                                        <div class="mb-3">
                                            <label class="form-label">New Password</label>
                                            <input type="password" name="newPassword"
                                                class="form-control @error('newPassword') is-invalid @enderror "
                                                placeholder="Enter New Password...">
                                            @error('newPassword')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" name="confirmPassword"
                                                class="form-control @error('confirmPassword') is-invalid @enderror "
                                                placeholder="Enter Confirm Password...">
                                             @error('confirmPassword')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        @if (Auth::user()->password != null)
                                             <div class="">
                                            <input type="submit" value="Change" class="btn bg-dark text-white">
                                        </div>
                                        @else
                                            <div class="">
                                            <input type="submit" value="Update" class="btn bg-dark text-white">
                                        </div>


                                        @endif

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
