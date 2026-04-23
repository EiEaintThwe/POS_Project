@extends('admin.layouts.master')

@section('content')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="">
                        <div class="row">
                            <div class="col-4 offset-4">
                                <div class="card">
                                    <div class="card-title">
                                        <a href="{{ route('category#list') }}" class="btn btn-sm bg-dark mt-2 mx-3 text-white shadow-sm rounded">Back</a>
                                    </div>
                                    <div class="card-body shadow">
                                        <form action="{{ route('category#update' , $category->id) }}" method="post" class="p-3 rounded">
                                            @csrf

                                            <input type="text" name="categoryName" value="{{ old('categoryName',$category->name) }}"
                                                class=" form-control @error('categoryName') is-invalid @enderror "
                                                placeholder="Category Name...">
                                            @error('categoryName')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror

                                            <input type="submit" value="Update" class="btn btn-outline-primary mt-3">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

@endsection
