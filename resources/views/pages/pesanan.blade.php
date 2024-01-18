@extends('layouts.master')

@section("warnapesanan", "active")

@section("judul", "Pesanan")


@section('content')

<div class="container-fluid">
   <div class="row">
      
      <div class="col-md-8">
         <div class="card">
            <div class="card-header bg-danger">
               <div class="row">
                  <div class="col-md-4">
                     <h3 class="py-0 my-0">LIST MENU</h3>
                  </div>
                  <div class="col-md-8">
                     <form action="{{ route('cari.menu', []) }}" method="get">
                        <div class="row">
                           <div class="col-md-5">
                              <input type="text" hidden value="{{ $idmeja }}" name="idmeja">
                              <select id="menu" class="form-control" onchange="submit()" name="menu">
                                 <option value="">Semua Menu</option>
                                 @foreach ($datamenu as $dm)
                                     <option value="{{ $dm->namamenu }}" @if ($dm->namamenu == $menu)
                                         selected
                                     @endif>{{ ucwords($dm->namamenu) }}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="col-md-7">
                              <div class="input-group">
                                 <input class="form-control" type="text" name="keyword" placeholder="masukan nama list" value="{{ $keyword }}" aria-label="masukan nama list" aria-describedby="keyword">
                                 <div class="input-group-append">
                                    <button type="submit" class="input-group-text" id="keyword">
                                       <i class="fa fa-search"></i>
                                    </button>
                                 </div>
                              </div>
                           </div>
                        </div>

                     </form>
                  </div>
               </div>
            </div>
            <div class="card-body" style="height: 500px;overflow-y: scroll">
               <div class="row">
                  @foreach ($list as $item)
                      <div class="col-md-4">
                        <div class="card">
                           
                           <div class="card-body">
                              <img src="{{ url('gambar', [$item->gambar]) }}" width="100%"  alt="">
                           </div>
                           <div class="card-footer p-1">
                              <h4 class="px-3 text-bold">{{ $item->namalist }}</h4>
                              <h5 class="px-3">Rp{{ number_format($item->harga, 0,",",".") }}</h5>
   
                              @if (!empty($idmeja))
                                  <button class="btn btn-block btn-success" type="button" data-toggle="modal" data-target="#pesan{{ $item->idlist }}">TAMBAH PESANAN</button>
                              @else
                              <button type="button" disabled class="btn btn-block btn-danger">SILAHKAN MEMILIH MEJA</button>
                              @endif

                           </div>

                        </div>
                      </div>


                      <div id="pesan{{ $item->idlist }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title" id="my-modal-title">{{ $item->namalist }}</h5>
                                 <button class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <form action="{{ route('tambah.pesanan', []) }}" method="post">
                                 @csrf
                                 <div class="modal-body">
                                    <input type="number" name="idmeja" value="{{ $idmeja }}" hidden id="">
                                    <input type="number" name="idlist" value="{{ $item->idlist }}" hidden id="">
   
                                    <div class="form-group">
                                       <label for="jumlah">Masukan Jumlah</label>
                                       <input id="jumlah" class="form-control" type="number" value="1" name="jumlah">
                                    </div>
   
                                 </div>
                                 <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Tambah</button>
                                 </div>
                              </form>
                           </div>
                        </div>
                      </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>

      <div class="col-md-4">
         <div class="card">
            <div class="card-header bg-danger">
               <h3 class="my-0 py-0">PESANAN</h3>
            </div>
            <div class="card-body">
               <div class="form-group">
                  <label for="idmeja">Pilih Meja</label>
                  <form action="{{ url()->current() }}">
                     <select id="idmeja" class="form-control" onchange="submit()" name="idmeja">
                        <option value="">Pilih Meja</option>
                        @foreach ($meja as $m)
                            <option value="{{ $m->idmeja }}" @if ($m->idmeja == $idmeja)
                                selected
                            @endif>{{ $m->nomormeja }}</option>
                        @endforeach
                     </select>
                  </form>
               </div>
            

            
               
            <table class="table table-striped table-sm p-2">
               <thead>
                  <tr>
                     <th width="5px">No</th>
                     <th>Nama List</th>
                     <th>Jml</th>
                     <th>Harga</th>
                     <th>ubah</th>
                  </tr>
               </thead>
               @foreach ($pesanan as $pesan)
                   <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td>{{ $pesan->list->namalist }}</td>
                     <td>{{ $pesan->jumlah }}</td>
                     <td>Rp{{ number_format($pesan->total, 0, ",", ".") }}</td>
                     <td>
                        <button class="badge badge-btn py-1 border-0 badge-primary" type="button" data-toggle="modal" data-target="#editpemesanan{{ $pesan->idpesanan }}">
                           <i class="fa fa-edit"></i>
                        </button>

                        <form action='{{ route('hapus.pesanan', [$pesan->idpesanan]) }}' method='post' class='d-inline'>
                             @csrf
                             @method('DELETE')
                             <button type='submit' onclick="return confirm('Ingin menghapus data?')" class='badge badge-danger badge-btn border-0'>
                                 <i class="fa fa-trash"></i>
                             </button>
                        </form>

                        <form action="{{ route('bayarsatuan.pesanan', []) }}" method="post" class="d-inline">
                           @csrf
                           <input type="number" hidden value="{{ $pesan->idpesanan }}" name="idpesanan">
            
                           <button type="submit" class="badge badge-btn py-1 border-0 badge-success" onclick="return confirm('Bayar satuan?')">
                              <i class="fa fa-check"></i>
                           </button>
                        </form>
                     </td>
                   </tr>

                   <div id="editpemesanan{{ $pesan->idpesanan }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <form action="{{ route('ubah.jumlah', [$pesan->idpesanan]) }}" method="post">
                              @csrf
                              <div class="modal-body">
                                 <div class="form-group">
                                    <label for="jumlah">Jumlah Pesanan</label>
                                    <input id="jumlah" class="form-control" type="number" name="jumlah" value="{{ $pesan->jumlah }}">
                                 </div>
                              </div>
                              <div class="modal-footer">
                                 <button type="submit" class="btn btn-success">
                                    Ubah
                                 </button>
                              </div>
                           </form>
                        </div>
                     </div>
                   </div>
               @endforeach
               <tfoot>
                  <tr class="text-lg">
                     <th colspan="3">TOTAL</th>
                     <th colspan="1">Rp{{ number_format($pesanan->sum('total'), 0, ",", ".") }}</th>
                  </tr>
               </tfoot>
            </table>


         </div>
         <div class="card-footer">
            @if (!empty($idmeja))
            <a href="{{ url('pesanan', []) }}" class="btn btn-success btn-block my-2">SELESAI</a>

            <form action="{{ route('bayar.pesanan', []) }}" method="post">
               @csrf
               <input type="number" hidden value="{{ $idmeja }}" name="idmeja">

               <button type="submit" class="btn btn-block btn-secondary" onclick="return confirm('tekan ya untuk melanjutkan proses')">BAYAR LUNAS</button>
            </form>
                
            @endif
         </div>

         </div>
      </div>
   </div>
</div>










@endsection