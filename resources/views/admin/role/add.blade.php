@extends('admin.index')

@section('title', 'Add Role - BlogBo.net')

@section('pagecontent')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Role</h1>
            <a href="{{ route('admin.role.list') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
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

        <form action="{{ route('admin.role.store') }}" method="POST" enctype="multipart/form-data">
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
                            <h4 class="small font-weight-bold">Name</h4>
                            <div class="form-group">
                                <input class="form-control form-control-user" name="name"
                                    @error('name') style="border-color: rgb(207, 45, 45);" @enderror
                                    value="{{ old('name') }}" autocomplete="name" autofocus>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="small font-weight-bold">Display Name</h4>
                            <div class="form-group">
                                <input class="form-control form-control-user" name="display_name"
                                    @error('display_name') style="border-color: rgb(207, 45, 45);" @enderror
                                    value="{{ old('display_name') }}" autocomplete="display_name" autofocus>
                            </div>
                        </div>

                        <hr />
                        @foreach ($permissionsParent as $permissionParent)
                            <div class="card-body">
                                <h5>Module
                                    {{ $permissionParent->name }}</h5>
                                <div class="form-group">
                                    <div class="row">
                                        @foreach ($permissionParent->permissionsChild as $permissionsChild)
                                            <div class="col-md-3">
                                                <label><input name="permission_id[]" id="checkboxChild" type="checkbox"
                                                        value="{{ $permissionsChild->id }}">{{ $permissionsChild->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <hr />
                        @endforeach
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

    </div>
@endsection
