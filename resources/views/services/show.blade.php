@extends('layouts.admin')

@section('title', 'Service Details')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- Service Details Card -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Service Report #{{ $service->id }}</h5>
                    <div>
                        <a href="{{ route('services.print', $service) }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="material-icons align-middle" style="font-size:16px;">print</i> Print
                        </a>
                        <a href="{{ route('services.edit', $service) }}" class="btn btn-primary btn-sm ml-2">Edit</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Customer:</strong> <br>
                            @if($service->customer)
                                {{ $service->customer->first_name }} {{ $service->customer->last_name }} <br>
                                <small class="text-muted">{{ $service->customer->phone_no }}</small>
                            @else
                                {{ $service->customer_name }} <br>
                                <small class="text-muted">No linked profile</small>
                            @endif
                        </div>
                        <div class="col-md-6 text-md-right">
                            <strong>Date In:</strong> {{ $service->date_in->format('M d, Y') }} <br>
                            <strong>Status:</strong>
                            <span
                                class="badge {{ $service->status === 'Completed' ? 'badge-success' : ($service->status === 'Pending' ? 'badge-warning' : 'badge-secondary') }}">
                                {{ $service->status }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Appliance:</strong> {{ $service->appliance_name }}
                        </div>
                        <div class="col-md-6">
                            <strong>Brand/Model:</strong> {{ $service->brand_model ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Problem Description:</strong>
                        <div class="p-2 bg-light rounded mt-1">
                            {{ $service->problem_desc }}
                        </div>
                    </div>

                    @if($service->recommendation)
                        <div class="mb-3">
                            <strong>Diagnosis / Recommendation:</strong>
                            <div class="p-2 bg-light rounded mt-1">
                                {{ $service->recommendation }}
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12 text-right">
                            <strong>Labor Cost:</strong> ₱{{ number_format($service->labor_cost, 2) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Comments -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="m-0">Progress Log & Comments</h6>
                </div>
                <div class="card-body">
                    <div class="comments-list mb-3" style="max-height: 300px; overflow-y: auto;">
                        @forelse($service->comments as $comment)
                            <div class="media mb-3 pb-3 border-bottom">
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1 font-weight-bold">{{ $comment->user->name ?? 'Unknown' }}
                                        <small
                                            class="text-muted float-right">{{ $comment->created_at->format('M d, Y H:i') }}</small>
                                    </h6>
                                    {{ $comment->comment }}
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center">No comments yet.</p>
                        @endforelse
                    </div>

                    <form action="{{ route('services.comments.store', $service) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="comment" class="form-control"
                                placeholder="Add a status update or comment..." required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Post</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar related info -->
        <div class="col-md-4">
            <!-- Transactions / Payments -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0">Payments</h6>
                    @if($service->transactions->count() == 0)
                        <a href="{{ route('transactions.create', ['report_id' => $service->id]) }}"
                            class="btn btn-success btn-sm btn-sm-custom" style="padding: 2px 8px; font-size: 12px;">+ Add</a>
                    @endif
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($service->transactions as $transaction)
                                <tr>
                                    <td>₱{{ number_format($transaction->total_amount, 2) }}</td>
                                    <td><span
                                            class="badge {{ $transaction->payment_status == 'Paid' ? 'badge-success' : 'badge-warning' }}">{{ $transaction->payment_status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">No associated payments.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection