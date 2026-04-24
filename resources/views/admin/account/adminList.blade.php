@extends('admin.layouts.master')

@section('content')
 <div class="container">
                    <div class=" d-flex justify-content-between my-2">
                        <a href="{{ route('account#userList') }}"> <button class=" btn btn-sm btn-secondary  "> User List</button> </a>
                        <div class="">
                            <form action="{{ route('account#adminList') }}" method="get">
                                @csrf

                                <div class="input-group">
                                    <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                                        placeholder="Enter Search Key...">
                                    <button type="submit" class=" btn bg-dark text-white"> <i
                                            class="fa-solid fa-magnifying-glass"></i> </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table class="table table-hover shadow-sm text-center">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Created Date</th>
                                        <th> Platform</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($admin as $item)
                                    <tr>
                                        <td>
                                            <img class="img-profile img-thumbnail w-25" id="output" src="{{ $item->profile != null ? asset('profile/'.$item->profile) : asset('default/profileImage.jpg') }}">
                                        </td>
                                        <td>{{ $item->name != null ? $item->name : $item->nickname }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{!! $item->address != null ? $item->address : '<i class="fa-regular fa-circle-xmark text-danger"></i>' !!}</td>
                                        <td>{!! $item->phone != null ? $item->phone : '<i class="fa-regular fa-circle-xmark text-danger"></i>' !!}</td>
                                        <td><span class="btn btn-sm bg-danger text-white rounded shadow-sm">{{ $item->role }}</span></td>

                                        <td><small>{{ $item->created_at->format('j-F-Y') }}</small></td>
                                        <td>
                                            @if( $item->provider == 'google' )<i class="fa-brands fa-google text-primary"></i>@endif
                                            @if( $item->provider == 'github' )<i class="fa-brands fa-github text-primary"></i> @endif
                                            @if( $item->provider == 'simple')<i class="fa-solid fa-arrow-right-to-bracket text-primary"></i> @endif
                                        </td>
                                        <td>
                                            @if( $item -> role != 'superadmin')
                                               <button type="button" onclick="deleteProcess({{ $item->id }})" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>


                                    @endforeach
                                </tbody>
                            </table>

                            <span class=" d-flex justify-content-end">{{ $admin->links() }}</span>

                        </div>
                    </div>
                </div>

@endsection

@section('js-script')
    <script>
        function deleteProcess($id){
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
                    location.href = '/admin/account/admin/delete/'+$id

                }, 1000);
                }
            });
        }

    </script>

@endsection
