@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Payment Method</h1>
        </div>

        <div class="">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route('payment#create') }}" method="post" class="p-3 rounded">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Bank Account Number</label>
                                    <input type="text" name="bankAccountNumber" value="" class=" form-control "
                                        placeholder="Enter Bank Account Number...">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Bank Account Name</label>
                                    <input type="text" name="bankAccountName" value="" class=" form-control "
                                        placeholder="Enter Bank Account Name...">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Bank Account Type</label>
                                    <select name="bankAccountType" id="" class="form-control">
                                        <option value="">Choose Bank Account Type</option>
                                        <option value="KBZ Pay">KBZ Pay</option>
                                        <option value="Wave Pay">Wave Pay</option>
                                        <option value="AYA Pay">AYA Pay</option>
                                        <option value="CB Pay">CB Pay</option>
                                        <option value="UAB Pay">UAB Pay</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Mobile Banking">Mobile Banking</option>
                                    </select>


                                </div>

                                <input type="submit" value="Create" class="btn btn-outline-primary mt-3">
                            </form>
                        </div>
                    </div>
                </div>



                <div class="col ">
                    <div class="d-flex justify-content-end mb-2">
                        <form action="{{ route('payment#list') }}" method="get">

                            <div class="input-group">
                                <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                                    class=" form-control" placeholder="Enter Search Key...">
                                <button type="submit" class=" btn bg-dark text-white"> <i
                                        class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <table class="table table-hover shadow-sm ">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Bank Account Number</th>
                                <th>Bank Account Name</th>
                                <th>Bank Account Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($payments as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->account_number }}</td>
                                    <td>{{ $item->account_name }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>
                                        <a href="{{ route('payment#edit', $item->id) }}" class="btn btn-sm btn-outline-secondary"> <i
                                                class="fa-solid fa-pen-to-square"></i> </a>
                                        <button type="button" onclick="deleteProcess({{ $item->id }})"
                                            class="btn btn-sm btn-outline-danger"> <i class="fa-solid fa-trash"></i>
                                            </a>
                                    </td>
                                </tr>
                            @endforeach



                        </tbody>
                    </table>

                    <span class=" d-flex justify-content-end">{{ $payments->links() }}</span>

                </div>
            </div>
        </div>

    </div>
@endsection

@section('js-script')
    <script>
        function deleteProcess($id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });

                    setInterval(() => {
                        location.href = '/admin/payment/delete/' + $id

                    }, 1000);
                }
            });
        }
    </script>
@endsection
