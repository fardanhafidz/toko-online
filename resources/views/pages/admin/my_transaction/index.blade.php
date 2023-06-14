@extends('layouts.parent')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">My Transaction</h5>

                <table class="table table-striped datatable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name Account</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($myTransaction as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->user->name }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->phone }}</td>
                                <td>{{ $row->total_price }}</td>
                                <td>
                                    <a href="{{ route('dashboard.my-transaction.show', $row->id) }}"
                                        class="btn btn-primary">
                                        <i class="bi bi-eye"></i>
                                        Show
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Transaksi Kosong</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
