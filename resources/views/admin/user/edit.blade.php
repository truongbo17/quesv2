@extends('admin.index')

@section('title', 'Edit User - BlogBo.net')

@section('pagecontent')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">User Question</h1>
            <a href="{{ route('admin.user.list') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
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

        <form method="POST" action="{{ route('admin.user.update', $user[0]->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">{{ $user[0]->name }}</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <h4 class="small font-weight-bold">Name</h4>
                            <div class="form-group">
                                <input class="form-control form-control-user" name="name" value="{{ $user[0]->name }}"
                                    @error('name') style="border-color: rgb(207, 45, 45);" @enderror>
                            </div>

                            <h4 class="small font-weight-bold">Email</h4>
                            <div class="form-group">
                                <input class="form-control form-control-user" name="email" value="{{ $user[0]->email }}"
                                    @error('email') style="border-color: rgb(207, 45, 45);" @enderror>
                            </div>

                            <h4 class="small font-weight-bold">Status</h4>
                            <select class="form-control" name="status"
                                @error('status') style="border-color: rgb(207, 45, 45);" @enderror>
                                <option value="1" {{ $user[0]->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="2" {{ $user[0]->status == 2 ? 'selected' : '' }}>Deleted</option>
                            </select>
                            <h4 class="small font-weight-bold">Roles</h4>
                            <select class="form-control"
                                @error('role_id') style="border-color: rgb(207, 45, 45);" @enderror multiple
                                name="role_id[]" multiple aria-label="multiple select example">
                                @foreach ($listRole as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $user[0]->roles->contains('id', $role->id) ? 'selected' : '' }}>
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Image</h6>
                            <label for="fileimage">
                                <i class="fas fa-plus fa-lg text-primary" role='button'></i>
                                <input name="avatar" class="float-right" type="file" accept="image/*" id="fileimage"
                                    onchange="loadFile(event)" hidden />
                                <script>
                                    var loadFile = function(event) {
                                        var output = document.getElementById('output');
                                        output.src = URL.createObjectURL(event.target.files[0]);
                                        output.onload = function() {
                                            URL.revokeObjectURL(output.src) // free memory
                                        }
                                    };
                                </script>
                            </label>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <img id="output" src="{{ asset('storage/' . $user[0]->avatar) }}"
                                    style="width:100%;height:auto;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

    </div>
@endsection
