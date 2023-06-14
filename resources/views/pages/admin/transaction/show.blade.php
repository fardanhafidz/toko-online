@extends('layouts.parent')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Transaction #{{ $transaction->id }} &raquo;
                    {{ $transaction->user->name }}</h5>

                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Name</th>
                        <td>{{ $transaction->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $transaction->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $transaction->phone }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $transaction->address }}</td>
                    </tr>
                    <tr>
                        <th>Courier</th>
                        <td>{{ $transaction->courier }}</td>
                    </tr>
                    <tr>
                        <th>Total Price</th>
                        <td>Rp. {{ number_format($transaction->total_price) }}</td>
                    </tr>
                    <tr>
                        <th>Payment</th>
                        <td>{{ $transaction->payment }}</td>
                    </tr>
                    <tr>
                        <th>Payment URL</th>
                        <td><a href="http://{{ $transaction->payment_url }}">
                                {{ $transaction->payment_url }}</a>
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($transaction->status == 'PENDING')
                                <span class="badge bg-warning">PENDING</span>
                            @elseif ($transaction->status == 'SUCCESS')
                                <span class="badge bg-success">SUCCESS</span>
                            @elseif ($transaction->status == 'FAILED')
                                <span class="badge bg-danger">FAILED</span>
                            @elseif ($transaction->status == 'SHIPPING')
                                <span class="badge bg-info">SHIPPING</span>
                            @elseif ($transaction->status == 'SHIPPED')
                                <span class="badge bg-primary">SHIPPED</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created_At</th>
                        <td>{{ $transaction->created_at }}</td>
                    </tr>
                    <tr>
                        <th>Updated_At</th>
                        <td>{{ $transaction->updated_at }}</td>
                    </tr>
                </table>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('dashboard.transaction.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i>
                        Back</a>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Transaction Item
                </h5>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name Product</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->transactionItem as $row)
                            <tr>
                                <td scope="col">{{ $loop->iteration }}</td>
                                <td scope="col">{{ $row->product->name }}</td>
                                <td scope="col">{{ number_format($row->product->price) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
