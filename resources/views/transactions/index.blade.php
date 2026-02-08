@extends('layouts.admin')

@section('title', 'Transactions')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Manage Transactions</h2>
                        </div>
                        <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
                            <button onclick="window.print()" class="btn btn-info mr-2"
                                style="color:white; margin-right: 10px;">
                                <i class="material-icons align-middle">print</i>
                                <span>Print List</span>
                            </button>
                            <a href="{{ route('transactions.create') }}" class="btn btn-success">
                                <i class="material-icons">&#xE147;</i>
                                <span>New Transaction</span>
                            </a>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Report ID</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>
                                    @if($transaction->report_id)
                                        <a
                                            href="{{ route('services.show', $transaction->report_id) }}">#{{ $transaction->report_id }}</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>₱{{ number_format($transaction->total_amount, 2) }}</td>
                                <td>
                                    <span
                                        class="badge {{ $transaction->payment_status === 'Paid' ? 'badge-success' : 'badge-warning' }}">
                                        {{ $transaction->payment_status }}
                                    </span>
                                </td>
                                <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('transactions.show', $transaction) }}" class="view" title="View"
                                        data-bs-toggle="tooltip">
                                        <i class="material-icons text-info">&#xE8F4;</i>
                                    </a>
                                    <a href="{{ route('transactions.edit', $transaction) }}" class="edit" title="Edit"
                                        data-bs-toggle="tooltip">
                                        <i class="material-icons">&#xE254;</i>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this transaction?');">
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
                                <td colspan="6" class="text-center">No transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media print {

            #sidebar,
            .xp-menubar,
            .footer,
            .btn,
            .card-header .btn {
                display: none !important;
            }

            #content {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .main-content {
                padding: 0 !important;
            }

            .table-wrapper {
                box-shadow: none !important;
            }

            body {
                background: white !important;
            }
        }
    </style>
@endpush