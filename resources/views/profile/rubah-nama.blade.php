@extends('template2')
@section('css')
    
@endsection
@section('content')
    <div class="card card-body mt-3">
      <form action="/profile/rubah-nama/post" method="POST" class="form-rubah-nama">
        @csrf
        <div class="form-group">
          <label for="nama_driver">Nama Driver</label>
          <input type="text" class="form-control nama-driver" name="nama_driver" id='nama_driver' value="{{ $driver->nama_driver }}" placeholder="Silahkan Masukkan Nama" required>
        </div>
        <div class="text-right">
          <button class="btn btn-primary btn-sm btn-simpan" type="submit">Simpan</button>
        </div>
      </form>
    </div>
@endsection
@section('script')
    <script>
      $(document).ready(function(){

      })

      // $('.form-rubah-nama').submit(function(e){
      //   e.preventDefault()
      //   swal({
      //     title: "Apakaah Kamu Yakin?",
      //     text: "Nama Kamu Akan Dirubah",
      //     icon: "success",
      //     buttons: true,
      //   })
      //   .then((ok) => {
      //     if (ok) {
      //       swal("Kamu Telah Merubah Nama", {
      //         icon: "success",
      //       });
      //       return true;
      //     }else{
      //       return false;
      //     }
      //   });
      // })
    </script>
@endsection