@extends('template.layout')

@section('content')
<div class="col-md-6 mx-auto">

    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Add Category</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('category.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input name="price" type="number" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <button class="btn btn-primary">Save</button>
                <a href="{{ route('category.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>

</div>
@endsection
