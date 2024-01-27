<?php

namespace App\Http\Controllers;

use App\Models\pesananM;
use App\Models\pendapatanM;
use App\Models\bayarsatuanM;
use App\Models\mejaM;
use App\Models\listM;
use App\Models\menuM;
use Illuminate\Http\Request;

class pesananC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jumlah(Request $request, $idpesanan)
    {
        try{
            $jumlah = $request->jumlah;

            if($jumlah > 0) {
                pesananM::where("idpesanan", $idpesanan)->first()->update([
                    "jumlah" => $jumlah,
                ]);
                return redirect()->back()->with('toast_success', 'Success');
            }else {
                return redirect()->back()->with('toast_error', 'error');
            }

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function lunasSatuan(Request $request)
    {
        try{
            $idpesanan = $request->idpesanan;
            $jumlahselesai = $request->jumlahselesai;
            $pesanan = pesananM::where('idpesanan', $idpesanan)->get();

            foreach ($pesanan as $item) {
                if($jumlahselesai < $item->jumlah  ) {
                    $tambah = new pendapatanM;
                    $tambah->idlist = $item->idlist;
                    $tambah->jumlah = $jumlahselesai;
                    $tambah->save();
                    if($tambah) {
                        $tambahsatuan = new bayarsatuanM;
                        $tambahsatuan->idmeja = $item->idmeja;
                        $tambahsatuan->jumlah = $jumlahselesai;
                        $tambahsatuan->idlist = $item->idlist;
                        $tambahsatuan->save();

                        pesananM::where("idpesanan", $item->idpesanan)->first()->update([
                            "jumlah" => $item->jumlah - $jumlahselesai,
                        ]);
                    }
                }else {
                    $tambah = new pendapatanM;
                    $tambah->idlist = $item->idlist;
                    $tambah->jumlah = $item->jumlah;
                    $tambah->save();
                    if($tambah) {
                        $ambil = bayarsatuanM::where("idlist", $item->idlist)->where("idmeja", $item->idmeja)->first();
                        
                        $ambil->update([
                            "jumlah" => $ambil->jumlah + $jumlahselesai,
                        ]);

                        pesananM::where("idpesanan", $item->idpesanan)->delete();
                    }
                }


                
            }

            return redirect()->back()->with('toast_success', 'Success');


        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
    
    public function lunas(Request $request)
    {
        try{
            $idmeja = $request->idmeja;
            $pesanan = pesananM::where('idmeja', $idmeja)->get();

            bayarsatuanM::where("idmeja", $idmeja)->delete();

            foreach ($pesanan as $item) {
                $tambah = new pendapatanM;
                $tambah->idlist = $item->idlist;
                $tambah->jumlah = $item->jumlah;
                $tambah->save();

                

                if($tambah) {
                    pesananM::where("idpesanan", $item->idpesanan)->delete();
                }
            }

            return redirect()->back()->with('toast_success', 'Success');


        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function hapus(Request $request, $idpesanan)
    {
        pesananM::destroy($idpesanan);
        return redirect()->back()->with('toast_success', 'Success');
    }

     public function cari(Request $request)
     {
         $idmeja = empty($request->idmeja)?'':$request->idmeja;
 
         $menu = empty($request->menu)?'':$request->menu;
         $keyword = empty($request->keyword)?'':$request->keyword;

         $links = url("pesanan")."?idmeja=$idmeja&menu=$menu&keyword=$keyword";

        //  dd($links);
         return redirect()->to($links);

     }

    public function meja(Request $request) {
        $idmeja = empty($request->idmeja)?'':$request->idmeja;

        $menu = empty($request->menu)?'':$request->menu;
        $keyword = empty($request->keyword)?'':$request->keyword;

        $meja = mejaM::get();
        
        $datamenu = menuM::get();

        $list = listM::whereHas("menu", function ($query) use ($menu) {
            if(!empty($menu)) {
                $query->where("menu.namamenu", $menu);
            }
        })
        ->where("list.namalist", "like", "%$keyword%")
        ->get();
        return view("pages.meja", [
            "meja" => $meja,
            "list" => $list,
            "datamenu" => $datamenu,
            
            "idmeja" => $idmeja,
            "menu" => $menu,
            "keyword" => $keyword,

        ]);
    }

    public function tambahmeja(Request $request)
    {
        try{
            $data = $request->all();
            mejaM::create($data);
            return redirect()->back()->with('toast_success', 'Success');
        
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function hapusmeja(Request $request, $idmeja)
    {
         try{
            mejaM::destroy($idmeja);
            return redirect()->back()->with('toast_success', 'Success');
         }catch(\Throwable $th){
             return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
         }
    }

    public function index(Request $request)
    {
        $idmeja = empty($request->idmeja)?'':$request->idmeja;

        $menu = empty($request->menu)?'':$request->menu;
        $keyword = empty($request->keyword)?'':$request->keyword;

        $meja = mejaM::get();
        $pesanan = pesananM::where("pesanan.idmeja", $idmeja)
        ->join("list", "list.idlist", "pesanan.idlist")
        ->select("pesanan.*")
        ->selectRaw("list.harga * pesanan.jumlah as total")
        ->get();

        $datamenu = menuM::get();

        $list = listM::whereHas("menu", function ($query) use ($menu) {
            if(!empty($menu)) {
                $query->where("menu.namamenu", $menu);
            }
        })
        ->where("list.namalist", "like", "%$keyword%")
        ->get();
        return view("pages.pesanan", [
            "meja" => $meja,
            "pesanan" => $pesanan,
            "list" => $list,
            "datamenu" => $datamenu,
            
            "idmeja" => $idmeja,
            "menu" => $menu,
            "keyword" => $keyword,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah(Request $request)
    {
        try{
            $data = $request->all();
            $idmeja = $request->idmeja;
            $idlist = $request->idlist;
            $cek = pesananM::where("idmeja", $idmeja)
            ->where("idlist", $idlist);

            if($cek->count() > 0) {
                $cek->first()->update([
                    "jumlah" => $request->jumlah + $cek->first()->jumlah,
                ]);
            }else {
                pesananM::create($data);
            }

            return redirect()->back()->with('toast_success', 'Pesanan Berhasil Ditambahkan');
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
     * @param  \App\Models\pesananM  $pesananM
     * @return \Illuminate\Http\Response
     */
    public function show(pesananM $pesananM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pesananM  $pesananM
     * @return \Illuminate\Http\Response
     */
    public function edit(pesananM $pesananM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pesananM  $pesananM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pesananM $pesananM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pesananM  $pesananM
     * @return \Illuminate\Http\Response
     */
    public function destroy(pesananM $pesananM)
    {
        //
    }
}
