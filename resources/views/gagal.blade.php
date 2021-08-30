@extends('template', ['title' => $message])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="text-center">
            <img src="https://storage.googleapis.com/assets-warungsegar/illustrations/Gagal.jpg" class="img-fluid p-3">
            <h5 class="font-weight-bold">{{ $message }}</h5>
            <p>{{ $submessage }}</p>
        </div>
    </div>
</div>
<div class="position-fixed bg-light py-2 w-100" style="bottom: 0px; left: 0; padding-right: 12px; padding-left: 12px">
    <a href="#goToHome" class="btn btn-success btn-block btn-home">Kembali Ke Beranda</a>
</div>
@endsection