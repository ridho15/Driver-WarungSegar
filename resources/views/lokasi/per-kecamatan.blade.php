@extends('template')

@section('css')
    
@endsection

@section('content')
  <div class="card card-body mt-3">
    <div class="form-group">
      <label for="kota">Kota</label>
      <select class="form-control kota select2" name="id_kota" id="kota">
        <option value="">Pilih</option>
        @foreach ($kota as $item)
            <option value="{{ $item->id_kota }}">{{ $item->nama_kota }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="kecamatan">Kecamatan</label>
      <select name="id_kecamatan" id="kecamatan" class="form-control kecamatan select2">
        <option value="">Pilih</option>
      </select>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-12">
      <span class="font-weight-bold">Data Pesanan</span>
    </div>
  </div>
  <div class="row listSearch">
    <div class="col-12 text-center card-data">
      
    </div>
  </div>
@endsection

@section('script')
    <script>
      $(document).ready(function(){
        // fetchKecamatan()
        $('.select2').select2({
          theme: 'bootstrap4'
        })
      })

      $('.kota').change(function(){
        id_kota = $(this).val()
        fetchKecamatan(id_kota)
      })
      function fetchKecamatan(id_kota){
        $.ajax({
          method: 'GET',
          url : '/lokasi/fetch/get-kecamatan',
          data: {
            id_kota
          },success: function(data){
            $('.kecamatan').html('<option value="">Pilih</option>')
            for(let i=0; i<data.kecamatan.length; i++){
              $('.kecamatan').append('<option value="' + data.kecamatan[i].id_kecamatan + '">' + data.kecamatan[i].nama_kecamatan + '</option>')
            }
          }
        })
      }

      $('.kecamatan').change(function(){
        id_kecamatan = $(this).val()
        fetchDataPesanan(id_kecamatan)
      })

      function fetchDataPesanan(id_kecamatan){
        $.ajax({
          method: 'GET',
          url: '/pesanan/fetch/data-pesanan',
          data: {
            id_kecamatan,
            id_kota: $('.kota').val()
          },
          beforeSend: function(){
            $('.card-data').html('<span>Sedang Mengambil Data <i class="fas fa-sync fa-spin"></i></span>')
          }, success: function(){

          }
        })
      }
    </script>
@endsection