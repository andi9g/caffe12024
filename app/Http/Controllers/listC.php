<?php

namespace App\Http\Controllers;

use App\Models\listM;
use App\Models\menuM;
use Illuminate\Http\Request;

class listC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?'':$request->keyword;
        $menu = empty($request->menu)?'':$request->menu;
        $data = listM::whereHas("menu", function ($query) use ($menu) {
            $query->where("menu.namamenu", "like", "%$menu%");
        })->where("namalist", "like", "%$keyword%")
        ->paginate(20);

        $data->appends($request->only(["limit", "keyword", "menu"]));

        $datamenu = menuM::get();

        return view("pages.list", [
            "data" => $data,
            "datamenu" => $datamenu,
            "menu" => $menu,
            "keyword" => $keyword,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "namalist" => 'required',
            "idmenu" => 'required',
            "harga" => 'required',
            "gambar" => 'required',
        ]);

        try{
            $data = $request->all();

            if ($request->hasFile("gambar")) {
                $file = $request->gambar;
                $extensi = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $data["gambar"] = strtotime(now()).uniqid().".".$extensi;

                $ex = strtolower($extensi);

                if(($ex == "jpg" || $ex == "jpeg" || $ex == "png")) {
                    if($size > 512000) {
                        return redirect()->back()->with('error', 'Size maximal 500Kb');
                    }
                    $file->move(public_path("gambar"), $data["gambar"]);
                }else{
                    return redirect()->back()->with('error', 'Format bukan gambar');

                }
            }else {
                return redirect()->back()->with('error', 'Silahkan masukan gambar');
            }


            listM::create($data);
            return redirect()->back()->with('toast_success', 'Success');
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\listM  $listM
     * @return \Illuminate\Http\Response
     */
    public function show(listM $listM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\listM  $listM
     * @return \Illuminate\Http\Response
     */
    public function edit(listM $listM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\listM  $listM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, listM $listM, $idlist)
    {
        try{
            $data = $request->all();

            if ($request->hasFile("gambar")) {
                $file = $request->gambar;
                $extensi = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $data["gambar"] = strtotime(now()).uniqid().".".$extensi;

                $ex = strtolower($extensi);

                if($ex == "jpg" || $ex == "jpeg" || $ex == "png") {
                    $file->move(public_path("gambar"), $data["gambar"]);
                }else{
                    return redirect()->back()->with('error', 'Format bukan gambar');

                }
            }else {
                return redirect()->back()->with('error', 'Silahkan masukan gambar');
            }


            listM::where("idlist", $idlist)->first()->update($data);
            return redirect()->back()->with('toast_success', 'Success');
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\listM  $listM
     * @return \Illuminate\Http\Response
     */
    public function destroy(listM $listM)
    {
        //
    }
}
