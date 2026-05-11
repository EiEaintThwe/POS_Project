@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <a href="{{ route('admin#saleList') }}" class=" text-black m-3"> <i class="fa-solid fa-arrow-left-long"></i> Back</a>

        <!-- DataTales Example -->


        <div class="row">
            <div class="card col-5 shadow-sm m-4 col">
                <div class="card-header bg-primary text-white">
                    Register Customer Information
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Name :</div>
                        <div class="col-7"> {{ $sale[0]->user_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Phone : </div>
                        <div class="col-7">
                            {{ $sale[0]->phone }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Addr : </div>
                        <div class="col-7">
                            {{ $sale[0]->address == null ? '...' : $sale[0]->address }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Code : </div>
                        <div class="col-7" id="orderCode">{{ $sale[0]->order_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Date :</div>
                        <div class="col-7"> {{ $sale[0]->created_at->format('j-F-Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Total Price :</div>
                        <div class="col-7">
                            {{ $paymentHistory->total_amt }}mmk<br>
                            <small class=" text-danger ms-1">( Contain Delivery Charges )</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-5 shadow-sm m-4 col">
                <div class="card-header bg-primary text-white">
                    Payment History Information
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Contact Phone :</div>
                        <div class="col-7">{{ $paymentHistory->phone }}</div>
                    </div>
                     <div class="row mb-3">
                        <div class="col-5">Address :</div>
                        <div class="col-7">{{ $paymentHistory->address }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Payment Method :</div>
                        <div class="col-7">{{ $paymentHistory->payment_type }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Purchase Date :</div>
                        <div class="col-7">{{ $paymentHistory->created_at->format('j-F-Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <img style="width: 150px" src="{{ asset('payslipImage/' . $paymentHistory->payslip_image) }}"
                            class=" img-thumbnail">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-white">Sale Product Lists</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm data-table" id="productTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="col-2">Image</th>
                                <th>Name</th>
                                <th>Count</th>
                                <th>Product Price (each)</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($sale as $item)
                                <tr>

                                    <td>
                                        <img src="{{ asset('productImage/' . $item->image) }}" class=" w-50 img-thumbnail">
                                    </td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->order_count }}  </td>
                                    <td>{{ $item->price }}mmk</td>
                                    <td>{{ $item->price * $item->order_count }} mmk</td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <div class="">

                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

