@extends('template.layout')

@section('content')
<div class="col-md-6 mx-auto">

    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Edit Category</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('category.update', $category->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input name="name" class="form-control" value="{{ $category->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input name="price" type="number" class="form-control" value="{{ $category->price }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control">{{ $category->description }}</textarea>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('category.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>

</div>
@endsection
