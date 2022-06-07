<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/main">
        <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-building"></i></div>
        <div class="sidebar-brand-text mx-3">GECL ADMIN</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="/main">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Interface</div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#AdminUser" aria-expanded="true" aria-controls="AdminUser">
            <i class="fas fa-fw fa-address-card"></i>
            <span>Admin</span>
        </a>
        <div id="AdminUser" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Admin Setting</h6>
                <a class="collapse-item" href="/hello">Admin List</a>
                <a class="collapse-item" href="/group">Group List</a>
                <a class="collapse-item" href="/test">Admin Auth</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu" aria-expanded="true" aria-controls="menu">
            <i class="fa fa-comment-o fa-1"></i>
            <span>menu</span>
        </a>
        <div id="menu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Admin Setting</h6>
                <a class="collapse-item" href="/hello">Admin List</a>
                <a class="collapse-item" href="/group">Group List</a>
                <a class="collapse-item" href="/test">Admin Auth</a>
            </div>
        </div>
    </li>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
