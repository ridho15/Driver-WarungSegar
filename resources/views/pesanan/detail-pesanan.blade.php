@extends('template2')

@section('css')
    
@endsection

@section('content')
<div class="row">
  <div class="col-12 mt-2 card-data">
    <div class="card">
      <div class="card-header bg-secondary text-white">
        <div class="card-title">
          <div class="row">
            <div class="col-6">
              <span class="title d-block h6">
                {{ $transaksiApps->user->nama_depan }} {{ $transaksiApps->user->nama_belakang }}
              </span>
              <span class="d-block">
                INV{{ sprintf('%08d', $transaksiApps->id_transaksi_apps) }}
              </span>
              <span class="badge @if ($transaksiApps->status == 1 || $transaksiApps->status == 2)badge-warning @elseif($transaksiApps->status == 3) badge-primary @elseif($transaksiApps->status == 4) badge-success @endif">
                @if ($transaksiApps->status == 1)
                    Check Out
                @elseif($transaksiApps->status == 2)
                    Sedang Diproses
                @elseif($transaksiApps->status == 3)
                    Sedang Dikirim
                @elseif($transaksiApps->status == 4)
                    Selesai
                @endif
              </span>
            </div>
            <div class="col-6 text-right">
              @if ($transaksiApps->status == 1)
              <span class="d-block h6">
                {{ $function->formatTanggal($transaksiApps->tw1) }}
              </span>
              <span class="d-block">
                {{ date('H:i:s', strtotime($transaksiApps->tw1)) }}
              </span>
              @elseif($transaksiApps->status == 2)
              <span class="d-block h6">
                {{ $function->formatTanggal($transaksiApps->tw2) }}
              </span>
              <span class="d-block">
                {{ date('H:i:s', strtotime($transaksiApps->tw2)) }}
              </span>
              @elseif($transaksiApps->status == 3)
              <span class="d-block h6">
                {{ $function->formatTanggal($transaksiApps->tw3) }}
              </span>
              <span class="d-block">
                {{ date('H:i:s', strtotime($transaksiApps->tw3)) }}
              </span>
              @elseif($transaksiApps->status == 4)
              <span class="d-block h6">
                {{ $function->formatTanggal($transaksiApps->tw4) }}
              </span>
              <span class="d-block">
                {{ date('H:i:s', strtotime($transaksiApps->tw4)) }}
              </span>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-3 align-self-center">
            @foreach ($transaksiApps->transaksiAppsDetail as $transaksiAppsDetail)
                @if (count($transaksiAppsDetail->produkB2CHarga->produkB2C->produkSub->produkMaster->produkMasterGambar) > 0)
                  <img src="{{ $transaksiAppsDetail->produkB2CHarga->produkB2C->produkSub->produkMaster->produkMasterGambar[0]->gambar }}" alt="Gambar Produk" width="60" height="60">
                @else
                  <img src="https://storage.googleapis.com/assets-warungsegar/images/defaultProduk.jpg" alt="Gambar Produk" width="60" height="60">
                @endif
                @php
                    break;
                @endphp
            @endforeach
          </div>
          <div class="col align-self-center">
            <span class="d-block h6 mb-0">
              @if (count($transaksiApps->transaksiAppsDetail) > 0)
                  {{ $transaksiApps->transaksiAppsDetail[0]->produkB2CHarga->produkB2C->produkSub->produkMaster->nama_produk }}
              @else
                  Nama Produk tidak ditemukan
              @endif
            </span>
            <small class="d-block">
              @if (count($transaksiApps->transaksiAppsDetail) > 1)
                  Dan {{ count($transaksiApps->transaksiAppsDetail) - 1 }} Lainnya
              @endif
            </small>
          </div>
          <div class="col-4 px-1 text-left font-weight-bold align-self-center">
            <span class="text-primary d-block mb-0">Total Jual</span>
            <span>Rp.
              @php
                  $total = 0;
                  foreach($transaksiApps->transaksiAppsDetail as $transaksiAppsDetail){
                    if ($transaksiAppsDetail->status_beli == 1) {
                      $total += $transaksiAppsDetail->jumlah * $transaksiAppsDetail->harga_jual;
                    }
                  }
                  echo number_format($total, 0,',','.');
              @endphp
            </span>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col">
            <span class="d-block font-weight-bold">Metode Pembayaran :</span> 
            @if ($transaksiApps->id_metode_pembayaran_waktu == 0)
                <span class="badge @if ($transaksiApps->status_pembayaran == 0) badge-warning @else badge-success @endif text-white">Bayar Ditempat</span>
            @else
                <span class="badge badge-warning">{{ $transaksiApps->transaksiJenisPembayaranWaktu->transaksiJenisPembayaranMulai->transaksiJenisPembayaranMetode->transaksiJenisPembayaran->nama }}</span>
            @endif
            @if ($transaksiApps->status_pembayaran == 1)
                <span class="badge badge-success text-white">Lunas</span>
            @else
                <span class="badge badge-warning text-white">Belum Lunas</span>
            @endif</span>
            <span class="d-block mt-2 font-weight-bold">Ongkir : Rp{{ number_format($transaksiApps->ongkir, 0, ',', '.') }}</span>
            <small class="mt-2 font-italic">{{ $transaksiApps->alamat->geolocation }}</small>
            <small class="font-weight-bold">({{ $transaksiApps->alamat->jarak }} Km)</small>
            <small class="font-weight-bold d-block"> => {{ $transaksiApps->alamat->nama_alamat }}</small>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col">
            <span>Total item : </span>
            <span class="font-weight-bold">{{ count($transaksiApps->transaksiAppsDetail) }}</span>
          </div>
        </div>
        <div class="row">
          @if ($level == 2)
          <div class="col-12">
            <a href="#" class="btn btn-info btn-sm btn-block btn-pilih-driver" data-id="{{ $transaksiApps->id_transaksi_apps }}" data-driver="{{ $transaksiApps->id_driver }}">
              <i class="fas fa-biking"></i>
              @if ($transaksiApps->driver)
                  Ganti Driver
              @else
                  Pilih Driver
              @endif
            </a>
          </div>
          @endif
          <div class="col-12 text-center">
            <span>Diantar Oleh : </span>
            @if ($transaksiApps->driver)
                <span class="font-weight-bold">{{ $transaksiApps->driver->nama_driver }}</span>
            @else
                <span class="font-weight-bold">Driver Belum Dipilih</span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>
<div class="card card-body">
  <div class="form-group">
    <label for="pencarian">Pencarian</label>
    <input type="text" class="form-control pencarian" name="pencarian" id="pencarian" placeholder="Silahkan Cari Produk">
  </div>
</div>
<hr>
<span class="font-weight-bold">Daftar Produk</span>
<div class="row listSearch">
  @foreach ($transaksiApps->transaksiAppsDetail as $transaksiAppsDetail)
    <div class="col-12 mt-3">
      <div class="card card-body card-data">
        <div class="row px-1">
          <div class="col-2 align-self-center text-left px-1">
            @if ($transaksiAppsDetail->produkB2CHarga->produkB2C->produkSub->produkMaster->produkMasterGambar)
                <img src="{{ $transaksiAppsDetail->produkB2CHarga->produkB2C->produkSub->produkMaster->produkMasterGambar[0]->gambar }}" alt="GambarProduk" width="50" height="50" class="rounded">
            @else
              <img src="https://storage.googleapis.com/assets-warungsegar/images/defaultProduk.jpg" alt="GambarProduk" width="50" height="50" class="rounded">
            @endif
          </div>
          <div class="col-6 text-left align-self-center">
            <span class="font-weight-bold">{{ $transaksiAppsDetail->produkB2CHarga->produkB2C->produkSub->produkMaster->nama_produk }}</span>
            <small class="font-weight-bold d-block">{{ $transaksiAppsDetail->satuan }} {{ $transaksiAppsDetail->satuanProdukLog->nama_satuan }} x {{ $transaksiAppsDetail->jumlah }} = {{ $transaksiAppsDetail->satuan * $transaksiAppsDetail->jumlah }} {{ $transaksiAppsDetail->satuanProdukLog->nama_satuan }}</small>
          </div>
          <div class="col text-right align-self-center px-1">
            <span class="font-weight-bold d-block text-primary">Total</span>
            <span class="font-weight-bold">Rp.{{ number_format($transaksiAppsDetail->subtotal,0,',','.') }}</span>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
<hr>
<div class="card card-body">
  <div class="row">
    <div class="col-5">
      <span class="font-weight-bold">Total Jual </span>
    </div>
    <div class="col-2 px-1">
      : Rp.
    </div>
    <div class="col text-right align-self-center">
      <span class="font-weight-bold text-primary">
        @php
            $total_jual = 0;
            foreach($transaksiApps->transaksiAppsDetail as $transaksiAppsDetail){
              if ($transaksiAppsDetail->status_beli == 1) {
                $total_jual += $transaksiAppsDetail->jumlah * $transaksiAppsDetail->harga_jual;
              }
            }
            echo number_format($total_jual, '0',',','.');
        @endphp
      </span>
    </div>
  </div>
  <div class="row">
    <div class="col-5">
      <span class="font-weight-bold">Ongkir </span>
    </div>
    <div class="col-2 px-1">
      : Rp.
    </div>
    <div class="col text-right align-self-center">
      <span class="font-weight-bold text-primary">
        {{ number_format($transaksiApps->ongkir,0,',','.') }}
      </span>
    </div>
  </div>
  <div class="row">
    <div class="col-5">
      <span class="font-weight-bold">Pot.Ongkir </span>
    </div>
    <div class="col-2 px-1">
      : Rp.
    </div>
    <div class="col text-right align-self-center">
      <span class="font-weight-bold text-primary">
        {{ number_format($transaksiApps->potongan_ongkir,0,',','.') }}
      </span>
    </div>
  </div>
  <div class="row">
    <div class="col-5">
      <span class="font-weight-bold">Pot.Belanja </span>
    </div>
    <div class="col-2 px-1">
      : Rp.
    </div>
    <div class="col text-right align-self-center">
      <span class="font-weight-bold text-primary">
        {{ number_format($transaksiApps->potongan_belanja,0,',','.') }}
      </span>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-5">
      <span class="font-weight-bold">Total Bayar </span>
    </div>
    <div class="col-2 px-1">
      : Rp.
    </div>
    <div class="col text-right align-self-center">
      <span class="font-weight-bold text-primary">
        @php
            $total_bayar = ($total_jual + $transaksiApps->total_ongkir) - ($transaksiApps->potongan_ongkir + $transaksiApps->potongan_belanja);
            echo number_format($total_bayar,0,',','.');
        @endphp
      </span>
    </div>
  </div>
</div>
<div class="card card-body mt-3">
  <span class="font-weight-bold">Ulasan</span>
  @foreach ($transaksiApps->transaksiAppsUlasan as $transaksiAppsUlasan)
      <div class="row">
        <div class="col-6">
          <span class="font-weight-bold">Saran : </span>
          <span>{{ $transaksiAppsUlasan->saran }}</span>
        </div>
        <div class="col-6">
          <span class="font-weight-bold">Balasan</span>
          <span>{{ $transaksiAppsUlasan->balasan }}</span>
        </div>
      </div>
  @endforeach
</div>
<div class="card card-body mt-3">
  <div class="row">
    <div class="col-12">
      <a href="https://www.google.com/maps/search/?api=1&query={{ $transaksiApps->alamat->latitude }}%2C{{ $transaksiApps->alamat->longitude }}" class="btn btn-success btn-sm btn-block">
        Lihat Peta
        <i class="fas fa-map-marked-alt"></i>
      </a>
    </div>
    <div class="col-12 mt-3">
      @if ($transaksiApps->status == 3)
        <button class="btn btn-danger btn-sm btn-block btn-batal-kirim">
          <i class="far fa-times-circle"></i> 
          Batal Kirim
        </button>
        <button class="btn btn-primary btn-sm btn-selesai btn-block mt-3" data-id="{{ $crypt->crypt($transaksiApps->id_transaksi_apps) }}">
          <i class="fas fa-check-circle"></i>
          Telah Sampai
        </button>
      @elseif($transaksiApps->status == 2)
        <button class="btn btn-primary btn-sm btn-block btn-kirim">
          <i class="fas fa-share-square"></i>
          Kirim
        </button>
      @endif
    </div>
  </div>
</div>
<div class="modal modal-sm modal-pilih-driver" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Driver</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/driver/simpan-driver" method="POST" class="form-pilih-driver">
        @csrf
      <div class="modal-body">
        <input type="hidden" name="id_transaksi_apps" class="form-control transaksi-apps">
        <div class="form-group">
          <label for="driver">Driver</label>
          <select name="id_driver" id="driver" class="form-control select2" required>
            <option value="">Pilih</option>
            @foreach ($driver as $item)
              <option value="{{ $item->id_driver }}">{{ $item->nama_driver }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm"><i class="far fa-save"></i> Simpan</button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="far fa-times-circle"></i> Close</button>
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

      $('.btn-pilih-driver').click(function(e){
        e.preventDefault()
        var id_transaksi_apps = $(this).data('id')
        var id_driver = $(this).data('driver')
        $('.transaksi-apps').val(id_transaksi_apps)
        $('.modal-pilih-driver').modal('show')
      })

      $('.pencarian').on('keyup', function(){
      var pencarian = $(this).val().toLowerCase()
      $('.listSearch .card-data').filter(function(){
        $(this).toggle($(this).text().toLowerCase().indexOf(pencarian) > -1)
      })
    })

      $('.btn-selesai').click(function(e){
        e.preventDefault()
        id = $(this).data('id')
        swal({
          text: "Apakah pesanan sudah diantar?",
          icon: "success",
          buttons: true,
        })
        .then((ok) => {
          if (ok) {
            swal("Pesanan Telah Sampai", {
              icon: "success",
            }).then((ok) => {
              location.href = '/pesanan/selesai?id=' + id
            });
          } 
        });
      })

      $('.btn-batal-kirim').click(function(){
        swal({
          text: "Apakah Kamu Yakin!?",
          icon: "warning",
          buttons: true,
        })
        .then((ok) => {
          if (ok) {
            swal("Pengantaran Dibatalkan!", {
              icon: "success",
            }).then((ok) => [
              location.href = "/pesanan/batal-kirim?id={{ $crypt->crypt($transaksiApps->id_transaksi_apps) }}"
            ]);
          }
        });
      })

      $('.btn-kirim').click(function(){
        swal({
          text: "Apakah Kamu Yakin!?",
          icon: "success",
          buttons: true,
        })
        .then((ok) => {
          if (ok) {
            swal("Pesanan Diantar!", {
              icon: "success",
            }).then((ok) => [
              location.href = "/pesanan/kirim?id={{ $crypt->crypt($transaksiApps->id_transaksi_apps) }}"
            ]);
          }
        });
      })
    </script>
@endsection