@extends('layouts.admin')

@section('title', 'Edit Staff')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="m-0">Edit Staff Member</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('staff.update', $staff) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $staff->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $staff->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>New Password (Leave blank to keep current)</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            <small class="text-muted">Only enter if you wish to change the password.</small>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="form-group mt-4 text-right">
                            <a href="{{ route('staff.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Staff</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection