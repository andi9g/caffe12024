<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>KWITANSI</title>
   <style>
      body {
         font-family: Arial, Helvetica, sans-serif;
      }
      h1 {
         margin: 0;
         padding: 0;
      }
      h2 {
         margin: 0;
         padding: 0;
      }
      h3 {
         margin: 0;
         padding: 0;
      }
      p {
         margin: 0;
         padding: 0;
      }

      table {
         border-collapse: collapse;
      }
      .bgku {
         background: rgb(219, 219, 219);
      }
   </style>
</head>
<body>
   <table width="100%">
      <tr>
         <td valign="top" width="70px">
            <img src="{{ url('gambar', ['logo.png']) }}" width="100%" alt="">
         </td>
         <td valign="top" style="padding: auto 10px">
            <h2>STRUCK PESANAN</h2>
            <h3>CAFFE WAROENG KOLU</h3>
         </td>
      </tr>
   </table>
   <br>


   <table width="100%" border="1">
      <thead>
         <tr>
            <th width="5px">No</th>
            <th>Nama List</th>
            <th>Jml</th>
            <th>Harga</th>
            <th>ket</th>
         </tr>
      </thead>

      @php
          $lunas = DB::table("bayarsatuan")->where("idmeja", $idmeja)
          ->join("list", "list.idlist", "bayarsatuan.idlist")
          ->select("list.namalist", "list.harga")
          ->selectRaw("sum(bayarsatuan.jumlah) as jumlah")
          ->groupBy("list.namalist", "list.harga","bayarsatuan.idlist")
          ->get()
      @endphp

      @foreach ($lunas as $ls)
          <tr>
            <td>#</td>
            <td>{{ $ls->namalist }}</td>
            <td>{{ $ls->jumlah }}</td>
            <td>{{ $ls->harga }}</td>
            <td>LUNAS</td>
          </tr>
      @endforeach

      @php
         $pesanan = App\Models\pesananM::where("pesanan.idmeja", $idmeja)
         ->join("list", "list.idlist", "pesanan.idlist")
         ->select("pesanan.*")
         ->selectRaw("list.harga * pesanan.jumlah as total")
         ->get();

      @endphp
      @foreach ($pesanan as $pesan)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $pesan->list->namalist }}</td>
            <td>{{ $pesan->jumlah }}</td>
            <td>Rp{{ number_format($pesan->total, 0, ",", ".") }}</td>
            <td>Belum Bayar</td>
          </tr>

          
      @endforeach
      <tfoot>
         <tr class="text-lg">
            <th colspan="4">TOTAL</th>
            <th colspan="1">Rp{{ number_format($pesanan->sum('total'), 0, ",", ".") }}</th>
         </tr>
      </tfoot>
   </table>

   <br>

   <table width="100%">
      <tr>
         <td width="70%"></td>
         <td width="" align="center">
            {{ \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('dddd, DD MMMM Y') }}
            <br>
            <br>
            <br>
            <br>
            ADMIN
         </td>
      </tr>
   </table>

</body>
</html>