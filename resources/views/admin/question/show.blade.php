@extends('admin.index')

@section('title', 'View Detail Question - BlogBo.net')

@section('pagecontent')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">View Detail Question</h1>
            <a href="{{ route('admin.question.list') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>

        <div class="row">

            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $question[0]->title }}</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <h4 class="small font-weight-bold">View</h4>
                        <p>{{ $question[0]->view }} </p>
                        <h4 class="small font-weight-bold">Status</h4>
                        <p>
                            @if ($question[0]->status == 1)
                                Active
                            @elseif ($question[0]->status == 2)
                                Deleted
                            @else
                                Pending
                            @endif
                        </p>
                        <h4 class="small font-weight-bold">Created at</h4>
                        <p>{{ \Carbon\Carbon::parse($question[0]->created_at)->format('H:i d/m/Y') }} </p>
                        <h4 class="small font-weight-bold">Updated at</h4>
                        <p>{{ \Carbon\Carbon::parse($question[0]->updated_at)->format('H:i d/m/Y') }} </p>
                        <h4 class="small font-weight-bold">Author</h4>
                        <p>{{ $question[0]->user->name }} </p>
                        <h4 class="small font-weight-bold">Category</h4>
                        <p>{{ $question[0]->category->name }} </p>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Image</h6>

                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <img src="{{ $question[0]->image }}" style="width:100%;height:auto;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
