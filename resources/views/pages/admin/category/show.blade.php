@extends('layouts.parent')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Show Category</h5>

                <div class="col-12">
                    <label for="inputNanme4" class="form-label">Name Category</label>
                    <input type="text" class="form-control" id="inputNanme4" name="name" value="{{ $category->name }}" disabled>
                </div>
                <div class="text-end mt-2">
                    <a href="{{ route('dashboard.category.index') }}" 
                        class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i>
                        Back
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
