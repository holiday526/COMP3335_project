<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        @auth

        <li class="nav-item">
            <a class="nav-link" href="{{ url("/profile") }}">
                <span class="mr-2 d-lg-inline text-gray-600">
                    <i class="fas fa-fw fa-user"></i>
                </span>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-600"></i>
                <span class="text-gray-600">Logout</span>
            </a>
        </li>

        @endauth

    </ul>

</nav>
