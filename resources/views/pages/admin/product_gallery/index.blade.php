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
                <h5 class="card-title">Product Gallery &raquo; {{ $product->name }}</h5>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('dashboard.product.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Back
                    </a>
                    <a href="{{ route('dashboard.product.gallery.create', $product->id) }}" class="btn btn-primary ms-1">
                        <i class="bi bi-plus"></i>
                        Create Product Gallery
                    </a>
                </div>

                 <!-- Table with stripped rows -->
                 <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $row)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    <img src="{{ $row->url }}" alt="" 
                                    style="width: 150px" 
                                    class="img-thumbnail">
                                </td>
                                <td>
                                    <form action="{{ route('dashboard.product.gallery.destroy', [$product->id, $row->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Data Product Gallery Kosong</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- End Table with stripped rows -->


            </div>
        </div>
    </div>
@endsection
