@extends('template')

@section('css')
    
@endsection

@section('content')
<div class="row bg-success" style="height: 150px">
  <div class="col-12 text-center">
    @if ($driver->foto_driver)
      <img src="{{ $driver->foto_driver }}" class="fotoUser mt-3 rounded-circle img-thumbail border border-warning" width="100" height="auto" alt="FotoUser">
    @else
      <img src="https://storage.googleapis.com/assets-warungsegar/icons/man-6259832_640.png" class="fotoUser mt-3 rounded-circle img-thumbail border border-warning" width="100" height="auto" alt="FotoUser">
    @endif
    <span class="d-block h5 text-white nt-2">{{ $driver->nama_driver }}</span>
  </div>
  <div class="col-12 mt-3">
    <p class="text-center h5">
      Pengaturan Akun
    </p>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <a href="#" class="text-dark border-bottom d-block mt-3 btn-rubah-nama">Rubah Nama</a>
        <a href="#" class="text-dark border-bottom d-block mt-3 btn-rubah-password">Rubah Password</a>
        <a href="#" class="text-dark border-bottom d-block mt-3 btn-rubah-foto">Rubah Foto</a>
        <a href="/profile/informasi" class="text-dark border-bottom d-block mt-3">Informasi</a>
      </div>
    </div>
    <p class="mt-3 text-center">
      <a href="#" class="text-danger btn-logout">Logout</a>
    </p>
  </div>
</div>

{{-- Modal Rubah Password --}}
<div class="modal modal-rubah-password" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Rubah Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/profile/rubah-password/post" method="POST">
        @csrf
      <div class="modal-body">
          <div class="form-group">
            <label for="passwordBaru">Password Lama</label>
            <input type="password" name="password_lama" value="" class="form-control password-lama" placeholder="Masukan Password Lama" required>
          </div>
          <div class="form-group">
            <label for="passwordlama">Password Baru</label>
            <input type="password" name="password_baru" value="" class="form-control password-baru" placeholder="Masukan Password Baru" required>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Rubah Foto --}}
<div class="modal modal-rubah-foto" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Rubah Foto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/profile/upload-foto" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="custom-file">
            <input type="file" class="custom-file-input foto-driver" id="fotoDriver" aria-describedby="inputGroupFileAddon01" name="fotoDriver" accept="image/png, image/gif, image/jpeg">
            <label class="custom-file-label" for="inputGroupFile01">Pilih Foto</label>
          </div>
          <div class="text-center">
            <img src="https://storage.googleapis.com/assets-warungsegar/icons/man-6259832_640.png" class="fotoUser mt-3 rounded-circle img-thumbail border border-warning foto-driver" width="100" height="auto" alt="FotoUser" style="object-fit: contain">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-sm">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('script')
    <script>
      $(document).ready(function(){

      })

      $('.btn-logout').click(function(e){
        e.preventDefault()
        swal({
          title: "Apakah Kamu Yakin?",
          // text: "Once deleted, you will not be able to recover this imaginary file!",
          icon: "warning",
          buttons: true,
          dangerMode: true
        })
        .then((ok) => {
          if (ok) {
            swal("Berhasil Logout", {
              icon: "success",
            }).then((ok) => {
              location.href = '/profile/logout';
            });
          }
        });
      })

      $('.btn-rubah-nama').click(function(){
        swal("Rubah Nama:", {
          content: "input",
        })
        .then((value) => {
          if(value){
            $.ajax({
              method:'post',
              url: '/profile/rubah-nama/post',
              data: {
                _token: "{{ csrf_token() }}",
                nama_driver: value
              },success: function(data){
                if(data.status == 1){
                  swal({
                    text: data.message,
                    icon: "success",
                    button: true,
                  }).then((ok) => {
                    location.href = '/profile';
                  });
                }else{
                  swal({
                    text: "Gagal Merubah Nama",
                    icon: "warning",
                    button: true,
                    dangerMode: true
                  });
                }
              }
            })
          }else{
            swal({
              text: "Nama Tidak Boleh Kosong!",
              icon: "warning",
              button: true,
              dangerMode: true
            });
          }
        });
      })

      $('.btn-rubah-password').click(function(){
        $('.modal-rubah-password').modal('show')
      })

      $('.btn-rubah-foto').click(function(){
        $('.modal-rubah-foto').modal('show')
      })

      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('.foto-driver').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }

      $('#fotoDriver').change(function(){
        readURL(this)
      })
    </script>
@endsection