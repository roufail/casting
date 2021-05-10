<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>{{ env('APP_NAME') }}</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('admin-files/css/font-awesome.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin-files/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

  <!-- bootstrap rtl -->
  <link rel="stylesheet" href="{{ asset('admin-files/css/bootstrap-rtl.min.css') }}">
  <!-- template rtl version -->
  <link rel="stylesheet" href="{{ asset('admin-files/css/custom-style.css') }}">
  <link rel="stylesheet" href="{{ asset('admin-files/css/toastr.min.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @stack('css-files')

  @yield("extra-css")

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <ul class="navbar-nav mr-auto">


      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown notifications-menu">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-warning navbar-badge count-pupple">0</span>
        </a>
 
        

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left notifications-dropdown-menu" style="left: 0px; right: inherit;">
          <span class="dropdown-item dropdown-header"><span class="count-pupple">0</span> نوتیفیکیشن</span>
        
        
        </div>



      </li>


      

      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-warning navbar-badge count-pupple">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left" style="left: 0px; right: inherit;">
          <span class="dropdown-item dropdown-header"><span class="count-pupple">0</span> نوتیفیکیشن</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-envelope ml-2"></i> 4 پیام جدید
            <span class="float-left text-muted text-sm">3 دقیقه</span>
          </a>
          <div class="dropdown-divider"></div>
        </div>
      </li> --}}



      
    </ul>
  </nav>
  <!-- /.navbar -->

  @include('admin.layout.partials.sidebar')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">صفحه سریع</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="#">خانه</a></li>
              <li class="breadcrumb-item active">صفحه سریع</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            @yield('content')
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    {{-- <div class="float-right d-none d-sm-inline">
      Anything you want
    </div> --}}
    <!-- Default to the left -->
    <strong>CopyRight &copy; {{ date('Y')}} <a target="_blank" href="https://oneappit.com">OneAppIt</a>.</strong>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('admin-files/js/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('admin-files/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin-files/js/adminlte.min.js') }}"></script>

<script src="{{ asset('js/app.js') }}"></script>
<!-- jQuery 2.1.4 -->
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<!-- Bootstrap 3.3.4 -->
<!-- AdminLTE App -->
<script src="{{ asset('admin-files/js/toastr.min.js') }}"></script>

<script>


  Echo.private("admin.{{auth()->user()->id}}")
      .notification((notification) => {
          toastr.success(notification.notification)
          let count = parseInt($('.notifications-menu .count-pupple').text()) + 1;
          $('.notifications-menu .count-pupple').text(count);
          $('.notifications-menu .count').text(count);
          $('.notifications-dropdown-menu').append($('<a>').text(notification.notification));
      });

</script>


@stack('js-files')
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
@yield('extra-js')
@include('sweetalert::alert')

</body>
</html>
