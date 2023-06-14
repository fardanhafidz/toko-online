@extends('layouts.parent')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Role user</h5>

                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Status</th>
                        <td>
                            <form action="{{ route('dashboard.user.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="input-group mb-3">
                                    <select class="form-select" name="roles" id="role">
                                        <option value="USER" >
                                            USER</option>
                                        <option value="ADMIN" >
                                            ADMIN</option>
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
