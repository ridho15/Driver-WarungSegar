@extends('template')

@section('css')
    
@endsection

@section('content')
<div class="row bg-success py-3" style="height: 90px">
  <div class="col-6 text-center align-self-center">
    <p class="text-white font-weight-bold h6 mb-0">Daftar Driver</p>
    <p class="font-weight-bold text-white h6 ">WarungSegar</p>
  </div>
  <div class="col-6 text-center align-self-center">
    <img src="https://storage.googleapis.com/assets-warungsegar/icons/logo%20warungsegar.png" alt="Logo WarungSegar" width="60" height="60">
  </div>
</div>
<div class="card card-body mt-3">
  <div class="form-group">
    <label for="pencarian">Pencarian</label>
    <input type="text" class="form-control pencarian" name="pencarian" id="pencarian">
  </div>
</div>
<hr>
<span class="font-weight-bold">Daftar Driver</span>
<div class="row listSearch">
  @foreach ($driver as $item)
      <div class="col-12 card-data" data-id="{{ $crypt->crypt($item->id_driver) }}">
        <div class="card card-body mt-2">
          <div class="row">
            <div class="col-12">
              <span class="font-weight-bold">{{ $item->nama_driver }}</span>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              @php
                  $jumlah = 0;
                  if($item->transaksiApps){
                    foreach ($item->transaksiApps as $transaksiApps) {
                      if ($transaksiApps->status == 2 && $transaksiApps->tw2 >= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')) && $transaksiApps->tw2 <= date('Y-m-d H:i:s') && $transaksiApps->id_kota == 1 && $transaksiApps->tipe_keranjang == 1) {
                        $jumlah++;
                      }
                    }
                  }
              @endphp
              <small>Akan Dikirim <b>({{ $jumlah }})</b></small>
            </div>
            <div class="col">
              @php
                  $jumlah = 0;
                  if($item->transaksiApps){
                    foreach ($item->transaksiApps as $transaksiApps) {
                      if ($transaksiApps->status == 3 && $transaksiApps->tw3 >= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-'  . $configHariPengiriman->hari . 'days')) && $transaksiApps->tw3 <= date('Y-m-d H:i:s') && $transaksiApps->id_kota == 1 && $transaksiApps->tipe_keranjang == 1) {
                        $jumlah++;
                      }
                    }
                  }
              @endphp
              <small>Sedang Dikirim <b>({{ $jumlah }})</b></small>
            </div>
            <div class="col">
              @php
                  $jumlah = 0;
                  if($item->transaksiApps){
                    foreach ($item->transaksiApps as $transaksiApps) {
                      if ($transaksiApps->status == 4 && $transaksiApps->tw4 >= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-'  . $configHariPengiriman->hari . 'days')) && $transaksiApps->tw4 <= date('Y-m-d H:i:s') && $transaksiApps->id_kota == 1 && $transaksiApps->tipe_keranjang == 1) {
                        $jumlah++;
                      }
                    }
                  }
              @endphp
              <small>Selesai Dikirim <b>({{ $jumlah }})</b></small>
            </div>
          </div>
        </div>
      </div>
  @endforeach
</div>
@endsection

@section('script')
    <script>
      $(document).ready(function(){
        
      })

      $('.pencarian').on('keyup', function(){
        var pencarian = $(this).val().toLowerCase()
        $('.listSearch .card-data').filter(function(){
          $(this).toggle($(this).text().toLowerCase().indexOf(pencarian) > -1)
        })
      })

      $('.card-data').click(function(){
        id_driver = $(this).data('id')
        location.href = '/driver/detail?id=' + id_driver;
      })
    </script>
@endsection