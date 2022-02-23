@extends('admin.index')

@section('title', 'Edit Category - BlogBo.net')

@section('pagecontent')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Category</h1>
            <a href="{{ route('admin.category.list') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Fail !</strong> {{ $error }}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endforeach

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success !</strong> {{ session('success') }} .
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Warning !</strong> {{ session('error') }} .
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.category.update', $category[0]->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">{{ $category[0]->title }}</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <h4 class="small font-weight-bold">Name</h4>
                            <div class="form-group">
                                <input class="form-control form-control-user" name="name" value="{{ $category[0]->name }}"
                                    @error('name') style="border-color: rgb(207, 45, 45);" @enderror>
                            </div>
                            <h4 class="small font-weight-bold">Slug</h4>
                            <div class="form-group">
                                <input class="form-control form-control-user" name="slug" value="{{ $category[0]->slug }}"
                                    @error('slug') style="border-color: rgb(207, 45, 45);" @enderror>
                            </div>
                            <h4 class="small font-weight-bold">Status</h4>
                            @if ($category[0]->questions_count > 0)
                                Can't change the deleted status when there is a question in this category
                            @endif
                            <select class="form-control" name="status"
                                @error('status') style="border-color: rgb(207, 45, 45);" @enderror>
                                <option value="1" {{ $category[0]->status == 1 ? 'selected' : '' }}>Active</option>
                                @if ($category[0]->questions_count < 1)
                                    <option value="2" {{ $category[0]->status == 2 ? 'selected' : '' }}>Deleted</option>
                                @endif
                            </select>
                            <h4 class="small font-weight-bold">Author</h4>
                            <p>{{ $category[0]->user->name }} </p>
                            <h4 class="small font-weight-bold">Total Question</h4>
                            <p>{{ $category[0]->questions_count }} </p>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

    </div>
@endsection
