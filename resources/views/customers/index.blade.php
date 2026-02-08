@extends('layouts.admin')

@section('title', 'Customer Information')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Manage Customers</h2>
                        </div>
                        <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
                            <a href="{{ route('customers.create') }}" class="btn btn-success">
                                <i class="material-icons">&#xE147;</i>
                                <span>Add New Customer</span>
                            </a>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>{{ $customer->phone_no }}</td>
                                <td>
                                    <a href="{{ route('customers.edit', $customer) }}" class="edit">
                                        <i class="material-icons" data-bs-toggle="tooltip" title="Edit">&#xE254;</i>
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to archive this customer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 m-0"
                                            style="background:none; border:none; box-shadow:none;">
                                            <i class="material-icons delete" data-bs-toggle="tooltip"
                                                title="Archive">&#xE872;</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="clearfix">
                    <div class="hint-text">Showing <b>{{ $customers->count() }}</b> entries</div>
                </div>
            </div>
        </div>
    </div>
@endsection