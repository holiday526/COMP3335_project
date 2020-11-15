<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-utensils"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ env('APP_NAME') }}</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Dashboard -->
    @if (count(\App\Game::where('user_id', Auth::user()->id)->where('active', true)->get()) > 0)

    <div class="sidebar-heading">Current Game Information</div>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/patch_info') }}">
            <i class="fas fa-fw fa-check-square"></i>
            <span>Patch Information</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/thread_intelligence') }}">
            <i class="fas fa-fw fa-exclamation-triangle"></i>
            <span>Threat Intelligence</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    @endif

    <div class="sidebar-heading">Game History</div>

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
