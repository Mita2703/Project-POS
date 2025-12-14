@extends('template.layout')

@section('content')
<div class="col-12">

    <div class="d-flex justify-content-between mb-3">
        <h4>Category List</h4>
        <a href="{{ route('category.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Category
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($categories as $c)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $c->name }}</td>
                        <td>Rp {{ number_format($c->price) }}</td>
                        <td>{{ $c->description }}</td>
                        <td>
                            <a href="{{ route('category.edit', $c->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('category.destroy', $c->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete?')" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
