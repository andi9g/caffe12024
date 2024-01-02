@extends('layouts.master')

@section("warnahome", "active")

@section("judul", "Pesanan")


@section('content')

<div class="container-fluid">
   <div class="row">
    <div class="col-lg-3 col-6">

        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $meja }}</h3>
                <p>Jumlah Meja</p>
            </div>
            <div class="icon">
                {{-- <i class="ion ion-bag"></i> --}}
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">

        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $pesanan }}</h3>
                <p>Jumlah Pesanan</p>
            </div>
            <div class="icon">
                {{-- <i class="ion ion-bag"></i> --}}
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">

        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $list }}</h3>
                <p>Jumlah List Menu</p>
            </div>
            <div class="icon">
                {{-- <i class="ion ion-bag"></i> --}}
            </div>
        </div>
    </div>

</div>
</div>










@endsection