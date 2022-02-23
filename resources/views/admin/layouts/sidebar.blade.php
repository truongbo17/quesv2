<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">BlogBo <sup>.net</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.home.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Content Management
    </div>

    <!-- Nav Item - Question Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseQuestion"
            aria-expanded="true" aria-controls="collapseQuestion">
            <i class="fas fa-fw fa-question"></i>
            <span>Questions</span>
        </a>
        <div id="collapseQuestion" class="collapse" aria-labelledby="headingQuestion"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Choose Option :</h6>
                <a class="collapse-item" href="{{ route('admin.question.list') }}">List Question</a>
                <a class="collapse-item" href="{{ route('admin.question.add') }}">Add Question</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Category Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory"
            aria-expanded="true" aria-controls="collapseCategory">
            <i class="fas fa-fw fa-th-large"></i>
            <span>Category</span>
        </a>
        <div id="collapseCategory" class="collapse" aria-labelledby="headingCategory"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Choose Option :</h6>
                <a class="collapse-item" href="{{ route('admin.category.list') }}">List Category</a>
                <a class="collapse-item" href="{{ route('admin.category.add') }}">Add Category</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Tag Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTag" aria-expanded="true"
            aria-controls="collapseTag">
            <i class="fas fa-fw fa-tag"></i>
            <span>Tag</span>
        </a>
        <div id="collapseTag" class="collapse" aria-labelledby="headingTag" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Choose Option :</h6>
                <a class="collapse-item" href="{{ route('admin.category.list') }}">List Tag</a>
                <a class="collapse-item" href="{{ route('admin.category.add') }}">Add Tag</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Heading -->
    <div class="sidebar-heading">
        User
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Heading -->
    <div class="sidebar-heading">
        System
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.file.index') }}">
            <i class="fas fa-fw fa-folder"></i>
            <span>Files</span></a>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.log.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Logs</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
