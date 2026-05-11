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

                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <span><strong><i class="fa-solid fa-triangle-exclamation text-warning mr-3"></i></strong>You can
                                click order code to see order details....</span>
                        </div>
                    </div>
                </div>

                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Date</th>
                            <th>Code</th>
                            <th>User Name</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($saleList as $item)
                            <tr>

                                <td>{{ $item->created_at->format('j-F-Y') }}</td>
                                <td><a class="orderCode"
                                        href="{{ route('admin#saleDetails', $item->order_code) }}">{{ $item->order_code }}</a>
                                </td>
                                <td>{{ $item->user_name }}</td>
                                <td>  <span class="text-success">Success</span></td>
                                <td>
                                   <i class="fa-solid fa-check text-success"></i>
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

