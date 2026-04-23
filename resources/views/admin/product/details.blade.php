@extends('admin.layouts.master')

@section('content')

<div class="container">
        <a href="{{ route('product#list') }}" class="btn bg-dark text-white rounded shadow-sm col-1 offset-2 my-3"><i class="fa-solid fa-backward me-2"></i>Back</a>
                    <div class="row">
                        <div class="col-8 offset-2 card p-3 shadow-sm rounded">
                            <form >
                                <div class="card-body">
                                    <div class="mb-3 text-center">
                                        <img class="img-profile mb-1 w-25" id="output" src="{{ asset('productImage/'.$product->image) }}">

                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" value="{{ $product->name }}" class="form-control "
                                                    placeholder="Enter Name..." disabled>

                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label">Category Name</label>
                                                <select name="categoryId" id="" class="form-control " disabled>
                                                    @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}" @if($product->category_id == $item->id) selected @endif>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label">Price</label>
                                                <input type="text" name="price" value="{{ $product->price }}" class="form-control "
                                                    placeholder="Enter Price..." disabled>

                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label">Stock</label>
                                                <input type="text" name="stock" value="{{ $product->stock }}" class="form-control "
                                                    placeholder="Enter Stock..." disabled>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" id="" cols="30" rows="10" class="form-control "
                                            placeholder="Enter Description..." disabled>{{ $product->description }}</textarea>

                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

@endsection
