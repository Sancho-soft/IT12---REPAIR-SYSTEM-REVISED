@extends('layouts.admin')

@section('title', 'Archive History')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="border:none; box-shadow:none; background:transparent;">
                <div class="card-header d-flex justify-content-between align-items-center"
                    style="background: #353b48; color: white; border-radius: 4px 4px 0 0;">
                    <h5 class="m-0">
                        <span class="material-icons align-middle mr-2">archive</span>
                        Archive & Deleted Records
                    </h5>
                    <div class="header-actions d-flex">
                        <form method="GET" action="{{ route('archive.index') }}" class="form-inline">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <div class="input-group">
                                <input type="text" name="search" value="{{ $search }}" class="form-control form-control-sm"
                                    placeholder="Search archive...">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-light" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="filter-section p-3 bg-white border-bottom">
                    <span class="mr-2 font-weight-bold">Filter by Type:</span>
                    <div class="btn-group">
                        <a href="{{ route('archive.index', ['type' => 'all']) }}"
                            class="btn btn-sm {{ $type == 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">All</a>
                        <a href="{{ route('archive.index', ['type' => 'services']) }}"
                            class="btn btn-sm {{ $type == 'services' ? 'btn-primary' : 'btn-outline-secondary' }}">Services</a>
                        <a href="{{ route('archive.index', ['type' => 'inventory']) }}"
                            class="btn btn-sm {{ $type == 'inventory' ? 'btn-primary' : 'btn-outline-secondary' }}">Inventory</a>
                    </div>
                </div>

                <div class="table-wrapper m-0" style="border-radius: 0 0 4px 4px;">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Details</th>
                                <th>Deleted At</th>
                                <th>Deleted By</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($paginatedArchives as $item)
                                <tr>
                                    <td><span class="badge badge-info">{{ $item->type }}</span></td>
                                    <td>{{ $item->details }}</td>
                                    <td>{{ $item->deleted_at->format('M d, Y H:i') }}</td>
                                    <td>{{ $item->deleted_by ?? 'Unknown' }}</td>
                                    <td class="text-center">
                                        <form
                                            action="{{ route('archive.restore', ['type' => $item->type, 'id' => $item->id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Restore">
                                                <i class="material-icons" style="font-size: 16px;">restore</i>
                                            </button>
                                        </form>
                                        <form
                                            action="{{ route('archive.destroy', ['type' => $item->type, 'id' => $item->id]) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Permanently delete this record? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Force Delete">
                                                <i class="material-icons" style="font-size: 16px;">delete_forever</i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">No archived records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="p-3">
                        {{ $paginatedArchives->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection