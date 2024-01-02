@extends('layouts.master')

@section("warnalaporan", "active")

@section("judul", "Laporan")


@section('content')

<div class="container">
   <div class="card">
      <form action="{{ route('cetak', []) }}" method="post">
         @csrf
         @method("get")
         <div class="card-body">
            <div class="form-group">
               <label for="tanggalawal">Tanggal Awal</label>
               <input id="tanggalawal" class="form-control" type="date" value="{{ date('Y-m-d') }}" name="tanggalawal">
            </div>
   
            <div class="form-group">
               <label for="tanggalawal">Tanggal Akhir</label>
               <input id="tanggalawal" class="form-control" type="date" value="{{ date('Y-m-d') }}" name="tanggalakhir">
            </div>
         </div>
         <div class="card-footer">
            <button type="submit" class="btn btn-success">Cetak</button>
         </div>
      </form>
   </div>
</div>








@endsection