@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div class=""></div>
            <div class="">
                <form action="" method="get">

                    <div class="input-group">
                        <input type="text" name="searchKey" value="" class=" form-control"
                            placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col-6">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <span><strong><i class="fa-solid fa-triangle-exclamation text-warning me-3"></i></strong>You can click order code to see order details....</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>

                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Date</th>
                            <th>Order Code</th>
                            <th>User Name</th>
                            <th>Order Status</th>
                            <th>Action</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($orderList as $item)
                            <tr>

                                <td>{{ $item->created_at->format('j-F-Y') }}</td>
                                <td><a href="{{ route('admin#orderDetails') }}">{{ $item->order_code }}</a></td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <select name="" id="" class=" form-select">
                                        <option value="" @if ($item->status == 0) selected @endif>Pending
                                        </option>
                                        <option value="" @if ($item->status == 1) selected @endif>Success
                                        </option>
                                        <option value="" @if ($item->status == 2) selected @endif>Reject
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    @if ($item->status == 0)
                                        <i class="fa-solid fa-spinner text-warning"></i>
                                    @elseif($item->status == 1)
                                        <i class="fa-solid fa-check text-success"></i>
                                    @else
                                        <i class="fa-solid fa-xmark text-danger"></i>
                                    @endif
                                </td>

                                <td>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>


            </div>
        </div>
    </div>
@endsection
