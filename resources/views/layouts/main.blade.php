<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data Mining</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{ asset('AdminLTE') }}/plugins/fontawesome-free/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('AdminLTE') }}/dist/css/adminlte.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    </head>
    <body class="hold-transition sidebar-mini">
        <!-- Wrapper -->
        <div class="wrapper">

            <!-- Navbar -->
            @include('layouts.navbar')
            <!-- End Navbar -->

            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- End Sidebar -->

            <!-- Content Wrapper -->
            <div class="content-wrapper">

                <!-- Content Header -->
                <div class="content-header">
                    {{-- <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Starter Page</li>
                                </ol>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <!-- End Content Header -->

                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
                <!-- End Main Content -->

            </div>
            <!-- End Content Wrapper -->

        </div>
        <!-- End Wrapper -->


        <!-- jQuery -->
        <script src="{{ asset('AdminLTE') }}/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('AdminLTE') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('AdminLTE') }}/dist/js/adminlte.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://kit.fontawesome.com/3f08182a17.js" crossorigin="anonymous"></script>
    </body>
</html>
