@extends('admin.index')

@section('title', 'List Question - BlogBo.net')

@section('css_new')
    <!-- Custom styles for this page -->
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/loading.css') }}" rel="stylesheet">
@endsection

@section('pagecontent')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List Question</h1>
            <a href="{{ route('admin.question.add') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Add Question</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success !</strong> {{ session('success') }} .
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Start List question --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Question List ( Does not include questions pending approval )
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>View</th>
                                <th>Date</th>
                                <th style="width: 5px">Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>View</th>
                                <th>Date</th>
                                <th style="width: 5px;">Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($listQuestions as $listQuestion)
                                <tr>
                                    <td>{{ $listQuestion->title }}</td>
                                    <td>
                                        {{ $listQuestion->category->name }}
                                    </td>
                                    <td>{{ $listQuestion->user->name }}</td>
                                    <td>{{ $listQuestion->view }}</td>
                                    <td>{{ \Carbon\Carbon::parse($listQuestion->created_at)->format('H:i d/m/Y') }}</td>
                                    <td>
                                        @if ($listQuestion->status == 1)
                                            <span class="badge bg-success text-white">Active</span>
                                        @elseif ($listQuestion->status == 0)
                                            <span class="badge bg-warning text-white">Pending</span>
                                        @else
                                            <span class="badge bg-danger text-white">Deleted</span>
                                        @endif
                                    </td>
                                    <td style="width: 100px">
                                        <a href="{{ route('admin.question.show', $listQuestion->id) }}"
                                            class="btn btn-sm btn-success btn-circle"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.question.edit', $listQuestion->id) }}"
                                            class="btn btn-sm btn-warning btn-circle"><i class="fas fa-edit"></i></a>
                                        @if ($listQuestion->status != 2)
                                            <a onclick="deleteQuestion({{ $listQuestion->id }},'{{ $listQuestion->title }}')"
                                                href="#" data-toggle="modal" data-target="#deleteQuestion   "
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
        {{-- End List question --}}

    </div>
@endsection

@include('admin.question.delete')

@section('js_new')
    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>
@endsection
