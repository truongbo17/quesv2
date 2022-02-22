@extends('admin.index')

@section('title', 'List Category - BlogBo.net')

@section('css_new')
    <!-- Custom styles for this page -->
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('pagecontent')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List Category</h1>
            <a href="{{ route('admin.category.add') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Add Category</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success !</strong> {{ session('success') }} .
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Danger !</strong> {{ session('error') }} .
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Start List category --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Category List ( Does not include categorys pending approval )
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Total Question</th>
                                <th style="width: 5px">Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Total Question</th>
                                <th style="width: 5px">Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($listCategories as $listCategory)
                                <tr>
                                    <td>{{ $listCategory->name }}</td>
                                    <td>{{ $listCategory->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($listCategory->created_at)->format('H:i d/m/Y') }}</td>
                                    <td>{{ $listCategory->questions_count }}</td>
                                    <td>
                                        @if ($listCategory->status == 1)
                                            <span class="badge bg-success text-white">Active</span>
                                        @else
                                            <span class="badge bg-danger text-white">Deleted</span>
                                        @endif
                                    </td>
                                    <td style="width: 100px">
                                        <a href="{{ route('admin.category.show', $listCategory->id) }}"
                                            class="btn btn-sm btn-success btn-circle"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.category.edit', $listCategory->id) }}"
                                            class="btn btn-sm btn-warning btn-circle"><i class="fas fa-edit"></i></a>
                                        @if ($listCategory->status != 2)
                                            <a onclick="deleteCategory({{ $listCategory->id }},'{{ $listCategory->name }}')"
                                                href="#" data-toggle="modal" data-target="#deleteCategory"
                                                class="btn btn-sm btn-danger btn-circle"><i class="fas fa-trash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- End List category --}}

    </div>
@endsection

@include('admin.category.delete')

@section('js_new')
    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>
@endsection
