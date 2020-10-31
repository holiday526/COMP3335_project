<!doctype html>
<html lang="en">
<head>

    @include('partials.head')
    <title>{{ env('APP_NAME').' SIEM' }}</title>
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('partials.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('partials.topbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div id="app">
                        @yield('content')
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            @include('partials.footer')
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    @include('partials.to_top')

    <!-- Logout Modal-->
    @include('partials.logout_modal')

    @include('partials.foot_script')

</body>
</html>
