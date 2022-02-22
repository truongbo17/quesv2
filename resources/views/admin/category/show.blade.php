@extends('admin.index')

@section('title', 'View Detail Category - BlogBo.net')

@section('pagecontent')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">View Detail Category</h1>
            <a href="{{ route('admin.category.list') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>

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
                        <p>{{ $category[0]->name }}</p>
                        <h4 class="small font-weight-bold">Status</h4>
                        <p>
                            @if ($category[0]->status == 1)
                                Active
                            @else
                                Deleted
                            @endif
                        </p>
                        <h4 class="small font-weight-bold">Created at</h4>
                        <p>{{ \Carbon\Carbon::parse($category[0]->created_at)->format('H:i d/m/Y') }} </p>
                        <h4 class="small font-weight-bold">Updated at</h4>
                        <p>{{ \Carbon\Carbon::parse($category[0]->updated_at)->format('H:i d/m/Y') }} </p>
                        <h4 class="small font-weight-bold">Author</h4>
                        <p>{{ $category[0]->user->name }} </p>
                        <h4 class="small font-weight-bold">Total Question</h4>
                        <p>{{ $category[0]->questions_count }} </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
