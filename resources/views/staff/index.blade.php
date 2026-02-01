@extends('layouts.admin')

@section('title', 'Manage Staff')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Manage Staff Members</h2>
                        </div>
                        <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
                            <a href="{{ route('staff.create') }}" class="btn btn-success">
                                <i class="material-icons">&#xE147;</i>
                                <span>Add New Staff</span>
                            </a>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $member)
                            <tr>
                                <td>{{ $member->id }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td><span
                                        class="badge {{ $member->usertype == 'admin' ? 'badge-primary' : 'badge-secondary' }}">{{ ucfirst($member->usertype ?? 'Staff') }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('staff.edit', $member) }}" class="edit" title="Edit"
                                        data-bs-toggle="tooltip">
                                        <i class="material-icons">&#xE254;</i>
                                    </a>
                                    <form action="{{ route('staff.destroy', $member) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this staff member?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 m-0"
                                            style="background:none; border:none; box-shadow:none;">
                                            <i class="material-icons delete" data-bs-toggle="tooltip"
                                                title="Delete">&#xE872;</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No staff found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection