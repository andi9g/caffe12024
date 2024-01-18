@extends('layouts.master')

@section("warnahome", "active")

@section("judul", "Home")

@section('mycss')
<style>
    .bgmenu {
       background: url('gambar/patern.jpg');
       background-repeat: no-repeat;
       background-size: auto;
    }
  </style>
@endsection

@section('content')

<div class="container-fluid">
   <div class="row">
    
    
    <div class="col-lg-12 col-12">

        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $pesanan }}</h3>
                <p>Jumlah Pesanan</p>
            </div>
            <div class="icon">
                {{-- <i class="ion ion-bag"></i> --}}
            </div>
        </div>
    </div>
    
    

</div>
</div>

<div class="container-fluid">
    <img src="{{ url('gambar', ['welcome.jpg']) }}" width="100%" alt="">
 
 </div>










@endsection