@extends('template')

@section('css')
    
@endsection

@section('content')
<div class="row bg-success py-3" style="height: 100px">
  <div class="col-6 text-center align-self-center">
    <p class="text-white font-weight-bold h6 mb-0">Aplikasi Driver</p>
    <p class="font-weight-bold text-white h5 ">WarungSegar</p>
  </div>
  <div class="col-6 text-center align-self-center">
    <img src="https://storage.googleapis.com/assets-warungsegar/icons/logo%20warungsegar.png" alt="Logo WarungSegar" width="75" height="75">
  </div>
</div>
@if ($level == 2)
  <div class="row mt-3">
    <div class="col-12 mt-2">
      <div class="card card-body">
        <div class="row">
          <div class="col-8">
            <span class="font-weight-bold">Siap Dikirim : 
              @php
                  $jumlah = 0;
                  foreach ($configWaktuPengiriman as $item) {
                    foreach ($item->configWaktuPengirimanLog as $configWaktuPengirimanLog) {
                      foreach ($configWaktuPengirimanLog->transaksiApps as $transaksiApps) {
                        if ($transaksiApps->status == 2 && $transaksiApps->tw2 >= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')) && $transaksiApps->tw2 <= date('Y-m-d H:i:s')) {
                          $jumlah++;
                        }
                      }
                    }
                  }
                  echo $jumlah;
              @endphp
            </span>
          </div>
          <div class="col-4 text-right">
            <a href="/pesanan/siap-dikirim" class="btn btn-primary btn-sm">Lihat <i class="fas fa-angle-double-right"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 mt-2">
      <div class="card card-body">
        <div class="row">
          <div class="col-8">
            <span class="font-weight-bold">Sedang Dikirim : 
              @php
                  $jumlah = 0;
                  foreach($configWaktuPengiriman as $item){
                    foreach($item->configWaktuPengirimanLog as $configWaktuPengirimanLog){
                      foreach ($configWaktuPengirimanLog->transaksiApps as $transaksiApps) {
                        if ($transaksiApps->status == 3 && $transaksiApps->tw3 >= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')) && $transaksiApps->tw3 <= date('Y-m-d H:i:s')) {
                          $jumlah++;
                        }
                      }
                    }
                  }
                  echo $jumlah;
              @endphp
            </span>
          </div>
          <div class="col-4 text-right">
            <a href="/pesanan/sedang-dikirim" class="btn btn-primary btn-sm">Lihat <i class="fas fa-angle-double-right"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 mt-2">
      <div class="card card-body">
        <div class="row">
          <div class="col-8">
            <span class="font-weight-bold">Selesai : 
              @php
                  $jumlah = 0;
                  foreach($configWaktuPengiriman as $item){
                    foreach($item->configWaktuPengirimanLog as $configWaktuPengirimanLog){
                      foreach ($configWaktuPengirimanLog->transaksiApps as $transaksiApps) {
                        if ($transaksiApps->status == 4 && $transaksiApps->tw4 >= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')) && $transaksiApps->tw4 <= date('Y-m-d H:i:s')) {
                          $jumlah++;
                        }
                      }
                    }
                  }
                  echo $jumlah;
              @endphp
            </span>
          </div>
          <div class="col-4 text-right">
            <a href="/pesanan/selesai" class="btn btn-primary btn-sm">Lihat <i class="fas fa-angle-double-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="card card-body">
    <div class="form-group">
      <label for="pencarian">Pencarian</label>
      <input type="text" class="form-control pencarian" name="pencarian" id="pencarian">
    </div>
  </div>
  <hr>
  <span class="font-weight-bold">Daftar Pesanan</span>
  <div class="row">
    <div class="col-12">
      <a href="/lokasi/semua-lokasi" class="btn btn-success btn-sm btn-map">
        <i class="fas fa-map-marked-alt"></i> Lihat Semua Lokasi
      </a>
    </div>
  </div>
  <div class="row listSearch">
    @if (count($configWaktuPengiriman) > 0)
        @foreach ($configWaktuPengiriman as $item)
        <div class="col-12 mt-1">
          <span class="h5">Sesi {{ $item->id_config_waktu_pengiriman }} ({{ date('H:i', strtotime($item->awal)) }} - {{ date('H:i', strtotime($item->akhir)) }})</span>
        </div>
        @foreach ($item->configWaktuPengirimanLog as $configWaktuPengirimanLog)
          @foreach ($configWaktuPengirimanLog->transaksiApps as $transaksiApps)
            @if (($transaksiApps->status == 2 || $transaksiApps->status == 3 || $transaksiApps->status == 4) && $transaksiApps->tw2 >= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')) && $transaksiApps->tw2 <= date('Y-m-d H:i:s'))
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
                              Siap Dikirim
                          @elseif($transaksiApps->status == 3)
                              Sedang Dikirim
                          @elseif($transaksiApps->status == 4)
                              Selesai
                          @endif
                        </span>
                      </div>
                      <div class="col-6 text-right">
                        <span class="d-block h6">
                          {{ $function->formatTanggal($transaksiApps->tw2) }}
                        </span>
                        <span class="d-block">
                          {{ date('H:i:s', strtotime($transaksiApps->tw2)) }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row mt-2">
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
                      <span class="d-block">
                        @if (count($transaksiApps->transaksiAppsDetail) > 1)
                            Dan {{ count($transaksiApps->transaksiAppsDetail) - 1 }} Lainnya
                        @endif
                      </span>
                    </div>
                    <div class="col-4 text-left font-weight-bold align-self-center">
                      <span class="text-primary h6 d-block mb-0">Total Jual</span>
                      <span>Rp {{ number_format($transaksiApps->total, 0, ',', '.') }}</span>
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
                      <span>Total Item : </span>
                      <span class="font-weight-bold">{{ count($transaksiApps->transaksiAppsDetail) }}</span>
                    </div>
                    <div class="col text-right">
                      <a href="/pesanan/detail?id={{ $crypt->crypt($transaksiApps->id_transaksi_apps) }}" class="btn btn-primary btn-sm">
                        Detail
                        <i class="fas fa-angle-double-right"></i>
                      </a>
                    </div>
                  </div>
                  @if ($transaksiApps->status == 2)
                  <div class="row mt-3">
                    <div class="col">
                      <a href="#" class="btn btn-info btn-sm btn-block btn-pilih-driver" data-id="{{ $transaksiApps->id_transaksi_apps }}" data-driver="{{ $transaksiApps->id_driver }}">
                        <i class="fas fa-biking"></i>
                        @if ($transaksiApps->driver)
                            Ganti Driver
                        @else
                            Pilih Driver
                        @endif
                      </a>
                    </div>
                  </div>
                  @endif
                  <div class="row mt-2">
                    @if ($transaksiApps->driver)
                      <div class="col">
                        <span>Diantar Oleh : </span> <span class="font-weight-bold">{{ $transaksiApps->driver->nama_driver }}</span>
                      </div>
                      @if ($transaksiApps->status == 2)
                        <div class="col-4 text-right">
                          <a href="#" class="btn btn-primary btn-sm btn-kirim" data-id="{{ $crypt->crypt($transaksiApps->id_transaksi_apps) }}">
                            <i class="fas fa-biking"></i> Kirim
                          </a>
                        </div>
                      @endif
                    @endif
                  </div>
                </div>
              </div>
            </div>
            @endif
          @endforeach
        @endforeach
      @endforeach
    @else
      <div class="col-12 text-center mt-3">
        <img src="https://storage.googleapis.com/assets-warungsegar/images/no%20data.gif" alt="Gambar" width="300" height="300" style="">
        <span class="d-block">Sedang tidak ada pesanan diproses</span>
      </div>
    @endif
  </div>

  {{-- Modal --}}
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
              {{-- @foreach ($driver as $item)
                <option value="{{ $item->id_driver }}">{{ $item->nama_driver }}</option>
              @endforeach --}}
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm"><i class="far fa-save"></i>Simpan</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="far fa-times-circle"></i> Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
@elseif($level == 1)
   <div class="row mt-2">
     <div class="col-12">
      <div class="card card-body h-100 align-self-">
        <div class="row">
          <div class="col align-self-center">
            <span class="font-weight-bold">Akan Dikirim</span>
            <span>: <b>
              @php
                $jumlah = 0;
                  foreach ($configWaktuPengiriman as $item) {
                    foreach ($item->configWaktuPengirimanLog as $configWaktuPengirimanLog) {
                      foreach ($configWaktuPengirimanLog->transaksiApps as $transaksiApps) {
                        if ($transaksiApps->status == 2 && $transaksiApps->id_driver == $driver->id_driver && $transaksiApps->tw2 >= date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '-' . $configHariPengiriman->hari . 'days')) && $transaksiApps->tw2 <= date('Y-m-d H:i:s') && $transaksiApps->id_kota == $driver->id_kota && $transaksiApps->tipe_keranjang == 1) {
                          $jumlah++;
                        }
                      }
                    }
                  }
                echo $jumlah;
               @endphp  
            </b></span>
          </div>
          <div class="col-4 text-right">
          <a href="/pesanan/siap-dikirim" class="btn btn-primary btn-sm btn-detail">
            Lihat
            <i class="fas fa-angle-double-right"></i>
          </a>
          </div>
        </div>
      </div>
     </div>
     <div class="col-12 mt-2">
       <div class="card card-body h-100">
         <div class="row">
           <div class="col align-self-center">
             <span class="font-weight-bold">Sedang Dikirim</span>
             <span>: <b>
               @php
                   $jumlah = 0;
                     foreach ($configWaktuPengiriman as $item) {
                       foreach ($item->configWaktuPengirimanLog as $configWaktuPengirimanLog) {
                         foreach ($configWaktuPengirimanLog->transaksiApps as $transaksiApps) {
                           if ($transaksiApps->status == 3 && $transaksiApps->id_driver == $driver->id_driver && $transaksiApps->tw3 >= date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '-' . $configHariPengiriman->hari . 'days')) && $transaksiApps->tw3 <= date('Y-m-d H:i:s') && $transaksiApps->id_kota == $driver->id_kota && $transaksiApps->tipe_keranjang == 1) {
                             $jumlah++;
                           }
                         }
                       }
                     }
                   echo $jumlah;
               @endphp  
             </b></span>
           </div>
           <div class="col-4 align-self-center text-right">
            <a href="/pesanan/sedang-dikirim" class="btn btn-primary btn-sm">Lihat <i class="fas fa-angle-double-right"></i></a>
           </div>
         </div>
       </div>
     </div>
     <div class="col-12 mt-2">
       <div class="card card-body">
         <div class="row">
           <div class="col align-self-center">
            <span class="font-weight-bold">Selesai</span>
            <span> : <b>
              @php
                $jumlah = 0;
                  foreach ($configWaktuPengiriman as $item) {
                    foreach ($item->configWaktuPengirimanLog as $configWaktuPengirimanLog) {
                      foreach ($configWaktuPengirimanLog->transaksiApps as $transaksiApps) {
                        if ($transaksiApps->status == 4 && $transaksiApps->id_driver == $driver->id_driver && $transaksiApps->tw4 >= date('Y-m-d H:i:s', strtotime(date('Y-m-d') . '-' . $configHariPengiriman->hari . 'days')) && $transaksiApps->tw4 <= date('Y-m-d H:i:s') && $transaksiApps->id_kota == $driver->id_kota && $transaksiApps->tipe_keranjang == 1) {
                          $jumlah++;
                        }
                      }
                    }
                  }
                echo $jumlah;
               @endphp   
            </b></span>
          </div>
          <div class="col-4 align-self-center text-right">
            <a href="/pesanan/selesai" class="btn btn-primary btn-sm">Lihat <i class="fas fa-angle-double-right"></i></a>
          </div>
         </div>
       </div>
     </div>
   </div>
   <hr>
   <div class="card card-body">
     <div class="form-group">
       <label for="pencarian">Pencarian</label>
       <input type="text" name="pencarian" id="pencarian" class="form-control pencarian" placeholder="Silahkan Cari Sesuatu">
     </div>
   </div>
   <hr>
   <span class="font-weight-bold">Pengiriman</span>
   <div class="row">
    <div class="col-12">
      <a href="/lokasi/semua-lokasi" class="btn btn-success btn-sm btn-map">
        <i class="fas fa-map-marked-alt"></i> Lihat Semua Lokasi
      </a>
    </div>
  </div>
   <div class="row listSearch">
      @foreach ($driverPengiriman as $item)
      <div class="col-12">
        <span class="h5">Sesi {{ $item->id_config_waktu_pengiriman }} ({{ date('H:i', strtotime($item->awal)) }} - {{ date('H:i', strtotime($item->akhir)) }})</span>
      </div>
        @foreach ($item->configWaktuPengirimanLog as $configWaktuPengirimanLog)
          @foreach ($configWaktuPengirimanLog->transaksiApps as $transaksiApps)
            @if (($transaksiApps->status == 2 || $transaksiApps->status == 3 || $transaksiApps->status == 4) && $transaksiApps->tw2 >= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '-' . $configHariPengiriman->hari . 'days')) && $transaksiApps->tw2 <= date('Y-m-d H:i:s') && $transaksiApps->id_driver == $driver->id_driver)
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
                              Siap Dikirim
                          @elseif($transaksiApps->status == 3)
                              Sedang Dikirim
                          @elseif($transaksiApps->status == 4)
                              Telah Sampai
                          @endif
                        </span>
                      </div>
                      <div class="col-6 text-right">
                        <span class="d-block h6">
                          {{ $function->formatTanggal($transaksiApps->tw2) }}
                        </span>
                        <span class="d-block">
                          {{ date('H:i:s', strtotime($transaksiApps->tw2)) }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row mt-2">
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
                      <span class="d-block">
                        @if (count($transaksiApps->transaksiAppsDetail) > 1)
                            Dan {{ count($transaksiApps->transaksiAppsDetail) - 1 }} Lainnya
                        @endif
                      </span>
                    </div>
                    <div class="col-4 text-left font-weight-bold align-self-center">
                      <span class="text-primary h6 d-block mb-0">Total Jual</span>
                      <span>Rp {{ number_format($transaksiApps->total, 0, ',', '.') }}</span>
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
                      <span>Total Item : </span>
                      <span class="font-weight-bold">{{ count($transaksiApps->transaksiAppsDetail) }}</span>
                    </div>
                    <div class="col text-right">
                      <a href="/pesanan/detail?id={{ $crypt->crypt($transaksiApps->id_transaksi_apps) }}" class="btn btn-primary btn-sm">
                        Detail
                        <i class="fas fa-angle-double-right"></i>
                      </a>
                    </div>
                  </div>
                  <div class="row mt-2">
                    @if ($transaksiApps->driver)
                      <div class="col">
                        <span>Diantar Oleh : </span> <span class="font-weight-bold">{{ $transaksiApps->driver->nama_driver }}</span>
                      </div>
                      @if ($transaksiApps->status == 2)
                        <div class="col-4 text-right">
                          <a href="#" class="btn btn-primary btn-sm btn-kirim" data-id="{{ $crypt->crypt($transaksiApps->id_transaksi_apps) }}">
                            <i class="fas fa-biking"></i> Kirim
                          </a>
                        </div>
                      @endif
                    @endif
                  </div>
                </div>
              </div>
            </div>
            @endif
          @endforeach
        @endforeach
      @endforeach
   </div>
@endif
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

    $('.btn-pilih-driver').click(function(e){
      e.preventDefault()
      var id_transaksi_apps = $(this).data('id')
      var id_driver = $(this).data('driver')
      $('.transaksi-apps').val(id_transaksi_apps)
      $('.modal-pilih-driver').modal('show')
    })
    $('.btn-kirim').click(function(e){
      e.preventDefault();
      id = $(this).data('id');
      console.log(id)
      swal({
        title: "Apakah kamu yakin?",
        text: "Kirim Pesanan",
        icon: "success",
        buttons: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          swal("Pesanan Sedang Dikirim", {
            icon: "success",
          }).then((ok) => {
            location.href = '/pesanan/kirim?id=' + id;
          });
        } 
      });
    })
  </script>
@endsection