@extends('admin.index')

@section('title', 'Add Tag - BlogBo.net')

@section('pagecontent')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Tag</h1>
            <a href="{{ route('admin.tag.list') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
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

        <form action="{{ route('admin.tag.store') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Content</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <h4 class="small font-weight-bold"> Name</h4>
                            <div class="form-group">
                                <input class="form-control form-control-user" name="name"
                                    @error('name') style="border-color: rgb(207, 45, 45);" @enderror
                                    value="{{ old('name') }}" autocomplete="name" autofocus>
                            </div>
                            <h4 class="small font-weight-bold"> Slug</h4>
                            <p>De trong se tu them</p>
                            <div class="form-group">
                                <input class="form-control form-control-user" name="slug"
                                    @error('slug') style="border-color: rgb(207, 45, 45);" @enderror
                                    value="{{ old('slug') }}" autocomplete="slug" autofocus>
                            </div>
                            <h4 class="small font-weight-bold">Status</h4>
                            <select class="form-control" name="status"
                                @error('status') style="border-color: rgb(207, 45, 45);" @enderror autofocus>
                                <option value="1">Active</option>
                                <option value="2">Deleted</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

    </div>
@endsection
