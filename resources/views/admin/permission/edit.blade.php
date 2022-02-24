@extends('admin.index')

@section('title', 'Edit Permission - BlogBo.net')

@section('pagecontent')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Permission</h1>
            <a href="{{ route('admin.permission.list') }}"
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

        <form method="POST" action="{{ route('admin.permission.update', $permission[0]->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">{{ $permission[0]->name }}</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <h4 class="small font-weight-bold">Name</h4>
                            <div class="form-group">
                                <input class="form-control form-control-user" name="name"
                                    value="{{ $permission[0]->name }}"
                                    @error('name') style="border-color: rgb(207, 45, 45);" @enderror>
                            </div>

                            <h4 class="small font-weight-bold">Display Name</h4>
                            <div class="form-group">
                                <input class="form-control form-control-user" name="display_name"
                                    value="{{ $permission[0]->display_name }}"
                                    @error('display_name') style="border-color: rgb(207, 45, 45);" @enderror>
                            </div>

                            <h4 class="small font-weight-bold">Parent</h4>
                            <div class="form-group">
                                <select name="parent_id" class="form-control"
                                    @error('parent_id') style="border-color: rgb(207, 45, 45);" @enderror>
                                    <option value="0">Don't Parent</option>
                                    @foreach ($listPermission as $listpermission)
                                        <option {{ $permission->contains('parent_id', $listpermission->id) ? 'selected' : '' }} value="{{ $listpermission->id }}">{{ $listpermission->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <h4 class="small font-weight-bold">Key code</h4>
                            <div class="form-group">
                                <input class="form-control form-control-user" value="{{ $permission[0]->key_code }}"
                                    name="key_code" value=""
                                    @error('key_code') style="border-color: rgb(207, 45, 45);" @enderror>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

    </div>
@endsection
