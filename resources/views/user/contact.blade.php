@extends('user.layouts.master')

@section('content')
    <div class="container-fluid fruite py-5 mt-5">
        <div class="container py-5">

            <div class="row">
                <div class="col-8 offset-2">

                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route('user#contactCreate') }}" method="post" class="p-3 rounded">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname) }}"
                                        placeholder="Enter Name..." disabled>
                                    @error('name')
                                        <small class=" invalid-feedback">{{ $message }}</small>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                        placeholder="Enter Title...">
                                    @error('title')
                                        <small class=" invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Message</label>
                                    <textarea name="message" id="" cols="30" rows="10" class="form-control @error('message') is-invalid @enderror"
                                        placeholder="Enter Message...">{{ old('message') }}</textarea>
                                    @error('message')
                                        <small class=" invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                 <div class="mb-3">
                                        <input type="submit" value="Submit"
                                            class=" btn btn-primary w-100 rounded shadow-sm">
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
@endsection
