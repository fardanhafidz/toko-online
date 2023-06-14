@extends('layouts.parent')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Transaction</h5>

                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Status</th>
                        <td>
                            <form action="{{ route('dashboard.transaction.update', $transaction->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="input-group mb-3">
                                    <select class="form-select" name="status" id="status">
                                        <option value="PENDING"
                                            {{ $transaction->status == 'PENDING' ? 'selected' : '' }}>
                                            PENDING</option>
                                        <option value="SUCCESS"
                                            {{ $transaction->status == 'SUCCESS' ? 'selected' : '' }}>
                                            SUCCESS</option>
                                        <option value="SHIPPING"
                                            {{ $transaction->status == 'SHIPPING' ? 'selected' : '' }}>
                                            SHIPPING</option>
                                        <option value="SHIPPED"
                                            {{ $transaction->status == 'SHIPPED' ? 'selected' : '' }}>
                                            SHIPPED</option>
                                        <option value="FAILED" {{ $transaction->status == 'FAILED' ? 'selected' : '' }}>
                                            FAILED</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
@endsection
