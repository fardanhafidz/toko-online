@extends('layouts.parent')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Create Product Gallery &raquo; {{ $product->name }}</h5>

                <form action="{{ route('dashboard.product.gallery.store', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Gallery Product</label>
                        <input type="file" class="form-control" id="inputNanme4" multiple name="files[]">
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
