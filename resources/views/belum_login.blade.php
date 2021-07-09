@extends('template', ['title' => 'Kamu Belum Login'])

@section('content')
<div class="text-center">
    <img src="https://storage.googleapis.com/assets-warungsegar/illustrations/unauthorized.jpg" class="img-fluid p-5">
    <h5 class="font-weight-bold">Ups! Kamu Belum Login</h5>
    <p>Maaf sepertinya kamu belum login atau sesi login kamu sudah habis, silahkan login terlebih dahulu</p>
</div>
<div class="position-fixed bg-light py-2 w-100" style="bottom: 0px; left: 0; padding-right: 12px; padding-left: 12px">
    <a href="#goToHome" class="btn btn-success btn-block btn-home">Kembali Ke Beranda</a>
</div>
@endsection