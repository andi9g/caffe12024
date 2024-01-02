<?php

namespace App\Http\Controllers;

use App\Models\pendapatanM;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;

class laporanC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view("pages.laporan");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cetak(Request $request)
    {
        try{
            $tanggalAwal = Carbon::parse($request->tanggalawal." 01:00");
            $tanggalAkhir = Carbon::parse($request->tanggalakhir. "23:00");
            
            $laporan = pendapatanM::join("list", "list.idlist", 'pendapatan.idlist')
            ->select("pendapatan.*")
            ->selectRaw("list.harga * pendapatan.jumlah as total")
            ->whereBetween("pendapatan.created_at", [$tanggalAwal, $tanggalAkhir])->get();

            

            $pdf = PDF::loadView("pages.laporan.laporan", [
                "laporan" => $laporan,
                "tanggalAwal" => $tanggalAwal,
                "tanggalAkhir" => $tanggalAkhir,
            ]);

            return $pdf->stream("laporan.pdf");

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pendapatanM  $pendapatanM
     * @return \Illuminate\Http\Response
     */
    public function show(pendapatanM $pendapatanM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pendapatanM  $pendapatanM
     * @return \Illuminate\Http\Response
     */
    public function edit(pendapatanM $pendapatanM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pendapatanM  $pendapatanM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pendapatanM $pendapatanM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pendapatanM  $pendapatanM
     * @return \Illuminate\Http\Response
     */
    public function destroy(pendapatanM $pendapatanM)
    {
        //
    }
}
