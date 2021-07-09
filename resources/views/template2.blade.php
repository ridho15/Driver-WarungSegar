<!doctype html>
  <head>
    <meta charset="UTF-8" />
    <meta name='viewport' 
     content='width=device-width, initial-scale=1.0, maximum-scale=1.0, 
     user-scalable=0' >
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/fontawesome-free/css/all.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" integrity="sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <script src="https://use.fontawesome.com/b97889cf08.js"></script>
    <link rel="icon" href="/assets/images/driver-bg-white.png">
    <title>{{ $title }}</title>
    @yield('css')
  </head>
  <body>  
    <div class="loading" style="display: none; z-index: 10000 !important">
      <div class="position-fixed d-flex w-100 h-100 align-items-center justify-content-center" style="z-index: 10000 !important">
        <img src="https://storage.googleapis.com/assets-warungsegar/animations/loading.gif" width="80" style="border-radius: 40px; z-index: 20">
        <div class="bg-dark position-fixed d-flex w-100 h-100" style="opacity: 0.6"></div>
      </div>
    </div>
    <div class="container mw-custom border-left border-right py-0">
      <div class="row bg-success text-white align-items-center fixed-top px-3" style="height: 50px;">
        <div class="col-2">
          <a href="{{ $backPage }}" class="text-white btn-back">
            <i class="fas fa-arrow-left"></i>
          </a>
        </div>
        <div class="col">
          <span class="h6">
            {{ $active }}
          </span>
        </div>
        <div class="col-3">
          <img src="https://storage.googleapis.com/assets-warungsegar/icons/logo%20warungsegar.png" alt="Logo WarungSegar" class="rounded float-right" width="40" height="40">
        </div>
      </div>
      <div class="row bg-success" style="height: 50px">
        <div class="col">

        </div>
      </div>
      @yield('content')
      <div class="row" style="height: 50px">
        <div class="col">

        </div>
      </div>
    </div>
  </body>
  <script src="/assets/js/jquery-3.6.0.min.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>
  <script src="/assets/js/jquery.validate.min.js"></script>
  <script src="/assets/js/function.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script>
    $(".btn-home").click(function(e){
        e.preventDefault()
        window.ReactNativeWebView.postMessage("goToHome")
    })

    $('.btn-back').click(function(e){
      e.preventDefault()
      location.href = document.referrer;
    })

    $('body').on('click', 'a', function(e) { 
        e.preventDefault(); 
        const url = $(this).attr('href');
        const target = $(this).attr('target')
        if(target == '_blank'){
          window.open(url)
          return false;
        }
        const n = url.includes("#");
        const pdf = url.includes(".pdf");
        const wa = url.includes("wa.me");
        
        if(n==true)
        {
          return false;
        }
        else if(pdf==true || wa==true)
        {
          window.open(url);
        }
        else
        {
          $(".loading").show()
          window.location.href=url;
        }
    });

    @if(session('success'))
      toastr.success('{{ session("success") }}')
    @endif

    @if(session('fail'))
      toastr.error('{{ session("fail") }}')
    @endif
  </script>
  @yield('script')
</html>