<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <style type="text/css">
    #map {
      height: 100%;
    }

    /* Optional: Makes the sample page fill the window. */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
  </style>
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/custom.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" integrity="sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni" crossorigin="anonymous">
  <link href="/assets/css/fontawesome-free/css/all.css" rel="stylesheet">
  <script src="https://use.fontawesome.com/b97889cf08.js"></script>
  <title>{{ $title }}</title>
</head>
<body>
  <div class="row bg-success text-white align-items-center fixed-top px-3" style="height: 50px">
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
  <div id="map"></div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoJVz2pfpoBXSOY8RzMqvI8zhc4cr9C6g&callback=initMap&libraries=&v=weekly" async></script>
  <script>
    var map, lokasi, marker;
    
    function initMap() {
      lokasi = { lat: {{ $transaksiApps->alamat->latitude }}, lng: {{ $transaksiApps->alamat->longitude }}}
      content = '<h5>{{ $transaksiApps->user->nama_depan }} {{ $transaksiApps->user->nama_belakang }}</h5><br><h6>{{ $transaksiApps->alamat->nama_alamat }}<br>{{ $transaksiApps->alamat->latitude }} - {{ $transaksiApps->alamat->longitude }}</h6><br><a href=""></a>'
      map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: lokasi,
      });
      penanda(lokasi, content)
    }
    
    function penanda(lokasi, content){
      var inforWindow = new google.maps.InfoWindow()
      marker = new google.maps.Marker({
        position: lokasi,
        map: map,
        icon: {
          url: 'https://storage.googleapis.com/assets-warungsegar/icons/customMarker.png',
          scaledSize: new google.maps.Size(50, 74)
        }
      })
      google.maps.event.addListener(marker, 'click', function () {
        inforWindow.setContent(content);
        inforWindow.open(map, this);
        location.href = 'https://www.google.com/maps/search/?api=1&query='+ lokasi.lat +'%2C' + lokasi.lng;
      });
    }
  </script>
</body>
</html>