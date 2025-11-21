<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'RSHP App')</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  
  @stack('css')
</head>

{{-- KUNCI: Pakai class 'layout-top-nav' biar Sidebar HILANG dan Konten FULL WIDTH --}}
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  @include('layouts.navbar')

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> @yield('title') </h1>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container">
        @yield('content')
      </div>
    </div>
  </div>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
      RSHP - Laravel
    </div>
    <strong>Copyright &copy; 2025 RSHP.</strong> All rights reserved.
  </footer>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>