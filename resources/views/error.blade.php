@extends('template', ['title' => 'Terjadi Kesalahan'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="text-center">
            <img src="https://storage.googleapis.com/assets-warungsegar/illustrations/500_Error.jpg" class="img-fluid p-3">
            <h5 class="font-weight-bold">Ups! Terjadi kesalahan</h5>
            <p>Maaf, terjadi kesalahan dalam pengambilan data dari server kami, mohon coba lagi. Jika kejadian berulang, hubungi Customer Service kami</p>
            @if($error)
                <p class="text-center text-danger font-weight-bold">
                    {{ $error }}    
                </p>
            @endif
        </div>
    </div>
</div>
<div class="position-fixed bg-light py-2 w-100" style="bottom: 0px; left: 0; padding-right: 12px; padding-left: 12px">
    <a href="#goToHome" class="btn btn-success btn-block btn-home">Kembali Ke Beranda</a>
</div>
@endsection