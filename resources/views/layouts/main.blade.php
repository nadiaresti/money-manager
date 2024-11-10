<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NR | Money Manager</title>

  <!-- Google Font: Source Sans Pro -->
  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
</head>
<style>
  .toast {
    margin-top: 10px; /* Adjust top margin */
    margin-right: 10px; /* Adjust right margin */
  }
</style>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    @include('layouts.navbar')
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    @include('layouts.sidebar')
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      @include('layouts.breadcrumb')
    </div>

    <section class="content">
      @yield('content')
    </section>
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
{{-- <script>
  $.widget.bridge('uibutton', $.ui.button)
</script> --}}
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('js/general-helper.js') }}"></script>

<script>
  $(document).ready(function() {
    @if (session()->has('success'))
      toastr.success(`{!! session()->get('success') !!}`, 'Success');
    @elseif (session()->has('error'))
      $(document).Toasts('create', {
        class: 'bg-danger',
        icon: 'fas fa-exclamation-circle',
        title: 'Failed!',
        body: `{!! session()->get('error') !!}`,
        autohide: true,
        delay: 5000,
      })
    @endif
  })
</script>

@yield('scripts')
</body>
</html>
