@extends('template')
@section('css')
    
@endsection
@section('content')
  <div class="row bg-success py-3" style="height: 90px">
    <div class="col-6 text-center align-self-center">
      <p class="text-white font-weight-bold h6 mb-0">Riwayat Pengantaran</p>
    </div>
    <div class="col-6 text-center align-self-center">
      <img src="https://storage.googleapis.com/assets-warungsegar/icons/logo%20warungsegar.png" alt="Logo WarungSegar" width="60" height="60">
    </div>
  </div>
  <div class="card card-body mt-3">
    <div class="form-group">
      <label for="pencarian">Pencarian</label>
      <input type="text" name="pencarian" id="pencarian" class="form-control pencarian" placeholder="Silahkan Cari Sesuatu">
    </div>
  </div>
  <hr>
  <span class="font-weight-bold">Daftar Riwayat</span>
  <div class="row">
    <div class="col-12">
      <div class="form-group">
        <label for="">Tanggal</label>
        <input type="date" class="form-control tanggal" name="tanggal" id="tanggal">
      </div>
    </div>
  </div>
  <div class="row mt-3 listSearch">
    <div class="col-12 card-data text-center">
      <span>Silahkan Pilih Tanggal</span>
    </div>
  </div>
@endsection
@section('script')
    <script>
      $(document).ready(function(){
        $('.tanggal').val('{{ date("Y-m-d") }}')
        fetchDataPengiriman($('.tanggal').val())
      })

      $('.pencarian').on('keyup', function(){
          var pencarian = $(this).val().toLowerCase()
          $('.listSearch .card-data').filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(pencarian) > -1)
          })
        })

      $('.tanggal').change(function(){
        tanggal = $(this).val()
        fetchDataPengiriman(tanggal)
      })

      function fetchDataPengiriman(tanggal){
        $.ajax({
          method: 'GET',
          url: '/riwayat/fetch/data-pengiriman',
          data: {
            tanggal
          },beforeSend:function(){
            $('.card-data').html('<span>Sedang Mengambil Data <i class="fas fa-sync fa-spin"></i></span>');
          },success:function(data){
            $('.listSearch').html(data)
          }
        })
      }
    </script>
@endsection