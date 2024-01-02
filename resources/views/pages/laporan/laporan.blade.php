<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Laporan</title>
   <style>
      body {
         font-family: Arial, Helvetica, sans-serif;
      }
      h1 {
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
   <h1>LAPORAN PENDAPATAN</h1>
   <p>{{ $tanggalAwal->isoFormat("DD MMMM Y") }} s.d {{ $tanggalAkhir->isoFormat("DD MMMM Y") }}</p>


   <table border="1" width="100%">
      <tr class="bgku">
         <th width="5px">No</th>
         <th width="5px">Tanggal</th>
         <th>Nama Menu</th>
         <th>Jumlah</th>
         <th>Harga</th>
         <th>Total Harga</th>
      </tr>

      @foreach ($laporan as $item)
          <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td>{{ date("d/m/Y", strtotime($item->created_at)) }}</td>
            <td>{{ $item->list->namalist }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>Rp{{ number_format($item->list->harga, 0, ",", ".") }}</td>
            <td>Rp{{ number_format($item->total, 0, ",", ".") }}</td>
          </tr>
      @endforeach

      <tr>
         <th colspan="4">TOTAL PENDAPATAN</th>
         <th colspan="2">Rp{{ number_format($laporan->sum("total"), 0, ",", ".") }}</th>
      </tr>
   </table>

</body>
</html>