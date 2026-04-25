@extends('admin.layouts.master')

@php
    $types = ['KBZ Pay', 'Wave Pay', 'AYA Pay', 'CB Pay', 'UAB Pay', 'Bank Transfer', 'Mobile Banking'];
@endphp

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="">
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="card">
                        <div class="card-title">
                            <a href="{{ route('payment#list') }}"
                                class="btn btn-sm bg-dark mt-2 mx-3 text-white shadow-sm rounded">Back</a>
                        </div>
                        <div class="card-body shadow">
                            <form action="{{ route('payment#update', $payment->id) }}" method="post" class="p-3 rounded">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Bank Account Number</label>
                                    <input type="text" name="bankAccountNumber"
                                        value="{{ old('bankAccountNumber', $payment->account_number) }}"
                                        class=" form-control @error('bankAccountNumber') is-invalid @enderror "
                                        placeholder="Enter Bank Account Number...">
                                    @error('bankAccountNumber')
                                        <small class=" invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Bank Account Name</label>
                                    <input type="text" name="bankAccountName"
                                        value="{{ old('bankAccountName', $payment->account_name) }}"
                                        class=" form-control @error('bankAccountName') is-invalid @enderror "
                                        placeholder="Enter Bank Account Name...">
                                    @error('bankAccountName')
                                        <small class=" invalid-feedback">{{ $message }}</small>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Bank Account Type</label>
                                    <select name="bankAccountType" id=""
                                        class="form-control @error('bankAccountType') is-invalid @enderror">
                                        <option value="">Choose Bank Account Type</option>

                                        @foreach ($types as $type)
                                            <option value="{{ $type }}"
                                                {{ trim(old('bankAccountType', $payment->type)) == trim($type) ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bankAccountType')
                                        <small class=" invalid-feedback">{{ $message }}</small>
                                    @enderror


                                </div>

                                <input type="submit" value="Update" class="btn btn-outline-primary mt-3">
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
@endsection
