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
                <a class="collapse-item" href="/member">Member List</a>
                <a class="collapse-item" href="/group">Group List</a>
            </div>
        </div>
    </li>
    @foreach($menu_list as $item)
        <li class="nav-item">
            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#menu_{{$item->m_idx}}" aria-expanded="true" aria-controls="menu_{{$item->m_idx}}" onclick="subMenuList('menu_{{$item->m_idx}}',{{$item->m_idx}})">
                <i class="fa fa-comment-o fa-1"></i>
                <span>{{$item->title}}</span>
            </a>
            <div id="menu_{{$item->m_idx}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">

            </div>
        </li>
    @endforeach

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

<script type="text/javascript">
    function subMenuList(obj,num) {

        $.ajax({
            type:'POST',
            url:'/menu/list',
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType : 'json',
            data: {
                obj : obj,
                num : num,
            },
            success : function (data) {
                if(data.result=='ok') {
                    $('#'+obj).html(data.html)
                }
            }
        });
    }
</script>
