<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="/assets/images/driver-bg-white.png">
  <title>Driver | Halaman Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/css/all.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/css/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/assets/css/icheck-bootstrap.min.css">
  <link href="/assets/css/custom.css" rel="stylesheet">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/css/adminlte.min.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;500;600&display=swap" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href="/assets/css/toastr.min.css">
</head>
<body class="hold-transition login-page" style="background-color: white">
  {{-- <div class="loading" style="display: none; z-index: 10000 !important">
    <div class="position-fixed d-flex w-100 h-100 align-items-center justify-content-center" style="z-index: 10000 !important">
      <img src="https://storage.googleapis.com/assets-warungsegar/animations/loading.gif" width="80" style="border-radius: 40px; z-index: 20">
      <div class="bg-dark position-fixed d-flex w-100 h-100" style="opacity: 0.6"></div>
    </div>
  </div> --}}
<div class="login-box bf-success mw-custom">
  <div class="login-logo">
    <img src="https://storage.googleapis.com/assets-warungsegar/icons/logo%20warungsegar.png" width="150" height="150">
    <p class="h5"><a href="/assets/index2.html"><b>Aplikasi Driver</b> WarungSegar</a></p>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login Untuk Masuk </p>
      <form action="/login/proses" method="post" class="form-login">
        @csrf
        <div class="input-group mb-3"> 
          <input type="email" class="form-control" placeholder="Email" name="email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <i class="far fa-envelope"></i>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Log in</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>

<!-- jQuery -->
<script src="/assets/js/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/js/adminlte.min.js"></script>

<script src="/assets/js/toastr.min.js"></script>

@if (session('fail'))
    <script>
      toastr.error("{{session('fail')}}")
    </script>
    @elseif(session('success'))
    <script>
      toastr.success("{{ session('success') }}")
    </script>
@endif

<script>
  $(document).ready(function(){
      window.focus();
  });

  $('.form-login').submit(function(){
    $('.loading').show()
  })
</script>

</body>
</html>
