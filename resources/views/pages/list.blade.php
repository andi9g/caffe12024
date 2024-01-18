@extends('layouts.master')

@section("warnalist", "active")

@section("judul", "List Menu Induk")


@section('content')

<div class="container-fluid">
   <div class="card">
      <div class="card-header">
         <div class="row">
            
            <div class="col-md-7">
               <form action="{{ url()->current() }}">
                  <div class="row">
                     <div class="col-md-5">
                        <select id="menu" class="form-control" onchange="submit()" name="menu">
                           <option value="">Semua Menu</option>
                           @foreach ($datamenu as $dm)
                               <option value="{{ $dm->namamenu }}" @if ($menu == $dm->namamenu)
                                   selected
                               @endif>{{ $dm->namamenu }}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="col-md-7">
                        <div class="input-group">
                           <input class="form-control" type="text" name="keyword" placeholder="nama list menu" aria-label="nama list menu" value="{{ $keyword }}" aria-describedby="keyword">
                           <div class="input-group-append">
                              <button type="submit" class="input-group-text px-3 bg-danger" id="keyword"> Cari </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>

            <div class="col-md-5 text-right">
               <button class="btn btn-success" type="button" data-toggle="modal" data-target="#tambahmenu"><b>
                  <i class="fa fa-plus"></i>
               </b></button>
            </div>
         </div>
      </div>

      <div class="card-body">
         <table class="table table-bordered table-striped table-hover table-lg">
            <thead class="bg-danger">
               <tr>
                  <th width="5px">No</th>
                  <th width="100px">Gambar</th>
                  <th>Nama List Menu</th>
                  <th>Harga</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
               </tr>
            </thead>

            <tbody>
               @foreach ($data as $item)
                   <tr>
                     <td>{{ $loop->iteration + $data->firstItem() - 1 }}</td>
                     <td>
                        <img src="{{ url('gambar', [$item->gambar]) }}" width="100px" alt="">
                     </td>
                     <td class="text-bold">{{ strtoupper($item->namalist) }}</td>
                     <td>Rp{{ number_format($item->harga, 0, ",", ".") }}</td>
                     <td>{{ ucwords($item->menu->namamenu) }}</td>
                     <td>
                        <form action='{{ route('list.destroy', [$item->idlist]) }}' method='post' class=''>
                             @csrf
                             @method('DELETE')
                             <button type='submit' onclick="return confirm('hapus?')" class='badge badge-danger badge-btn border-0 py-1'>
                                 <i class="fa fa-trash"></i>
                             </button>
                        </form>

                        <button class="badge badge-btn py-1 border-0 badge-success" type="button" data-toggle="modal" data-target="#updatelist{{ $item->idlist }}">
                           <i class="fa fa-edit"></i> Ubah
                        </button>
                     </td>
                   </tr>

                   <div id="updatelist{{ $item->idlist }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="my-modal-title">Title</h5>
                              <button class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <form action="{{ route('list.update', [$item->idlist]) }}" method="POST" enctype="multipart/form-data"> 
                              @csrf
                              @method("PUT")
                              <div class="modal-body">
                                 <div class="form-group">
                                    <label for="namalist">Nama List Menu</label>
                                    <input id="namalist" class="form-control" type="text" name="namalist" value="{{ $item->namalist }}" placeholder="masukan nama list menu">
                                 </div>
                  
                                 <div class="form-group">
                                    <label for="idmenu">Menu</label>
                                    <select id="idmenu" class="form-control" name="idmenu">
                                       @foreach ($datamenu as $dm)
                                          <option value="{{ $dm->idmenu }}" @if ($item->idmenu == $dm->idmenu)
                                              selected
                                          @endif>{{ strtoupper($dm->namamenu) }}</option>
                                       @endforeach
                                    </select>
                                 </div>
                  
                                 <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input id="harga" class="form-control" type="number" name="harga" placeholder="masukan harga" value="{{ $item->harga }}">
                                 </div>
                  
                                 <div class="form-group">
                                    <label for="gambar">Pilih Gambar</label>
                                    <input id="gambar" class="form-control-file" type="file" name="gambar">
                                 </div>
                              </div>
                              <div class="modal-footer">
                                 <button type="submit" class="btn btn-success">
                                    UPDATE
                                 </button>
                              </div>
                           </form>
                        </div>
                     </div>
                   </div>
               @endforeach
            </tbody>
         </table>
      </div>

      <div class="card-footer">
         {{ $data->links("vendor.pagination.bootstrap-4") }}
      </div>
   </div>

</div>












<div id="tambahmenu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="my-modal-title">Tambah List Menu</h5>
            <button class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{ route('list.store', []) }}" method="POST" enctype="multipart/form-data"> 
            @csrf
            
            <div class="modal-body">
               <div class="form-group">
                  <label for="namalist">Nama List Menu</label>
                  <input id="namalist" class="form-control" type="text" name="namalist" placeholder="masukan nama list menu">
               </div>

               <div class="form-group">
                  <label for="idmenu">Menu</label>
                  <select id="idmenu" class="form-control" name="idmenu">
                     @foreach ($datamenu as $dm)
                        <option value="{{ $dm->idmenu }}">{{ strtoupper($dm->namamenu) }}</option>
                     @endforeach
                  </select>
               </div>

               <div class="form-group">
                  <label for="harga">Harga</label>
                  <input id="harga" class="form-control" type="number" name="harga" placeholder="masukan harga">
               </div>

               <div class="form-group">
                  <label for="gambar">Pilih Gambar</label>
                  <input id="gambar" class="form-control-file" type="file" name="gambar">
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-success">
                  Tambah
               </button>
            </div>
         </form>
      </div>
   </div>
</div>

@endsection