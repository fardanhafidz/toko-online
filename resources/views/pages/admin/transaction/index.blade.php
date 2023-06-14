@extends('layouts.parent')

@section('content')
    <div class="container">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {!! \Session::get('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-octagon me-1"></i>
                {!! \Session::get('error') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Transaction
                </h5>

                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name Account</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Courier</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($transaction as $row)
                            <tr>
                                <td scope="col">{{ $loop->iteration }}</td>
                                <td scope="col">{{ $row->user->name }}</td>
                                <td scope="col">{{ $row->name }}</td>
                                <td scope="col">{{ $row->email }}</td>
                                <td scope="col">{{ $row->phone }}</td>
                                <td scope="col">{{ $row->courier }}</td>
                                <td scope="col">{{ number_format($row->total_price) }}</td>
                                <td scope="col">
                                    @if ($row->status == 'PENDING')
                                        <span class="badge bg-warning">PENDING</span>
                                    @elseif ($row->status == 'SUCCESS')
                                        <span class="badge bg-success">SUCCESS</span>
                                    @elseif ($row->status == 'FAILED')
                                        <span class="badge bg-danger">FAILED</span>
                                    @elseif ($row->status == 'SHIPPING')
                                        <span class="badge bg-info">SHIPPING</span>
                                    @elseif ($row->status == 'SHIPPED')
                                        <span class="badge bg-primary">SHIPPED</span>
                                    @endif
                                </td>
                                <td scope="col">
                                    <a href="{{ route('dashboard.transaction.show', $row->id) }}" class="btn btn-info">
                                        <i class="bi bi-eye"></i>
                                        Show
                                    </a>

                                    <a href="{{ route('dashboard.transaction.edit', $row->id) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i>
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Data Transaction Kosong</td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
