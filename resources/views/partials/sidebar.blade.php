<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-utensils"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ env('APP_NAME') }}</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @if (count(\App\Game::where('user_id', Auth::user()->id)->get()) > 0)
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    @endif

    <!-- Divider -->
{{--    <hr class="sidebar-divider">--}}

    <!-- Heading -->
{{--    <div class="sidebar-heading">--}}
{{--        Interface--}}
{{--    </div>--}}

    <li class="nav-item">
        <a class="nav-link" href="{{ url("/history") }}">
            <i class="fas fa-fw fa-history"></i>
            <span>History</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
