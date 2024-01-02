<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mejaM;
use App\Models\listM;
use App\Models\pesananM;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $meja = mejaM::count();
        $pesanan = pesananM::count();
        $list = listM::count();
        return view('pages.home' ,[
            'meja' => $meja,
            'pesanan' => $pesanan,
            'list' => $list,
        ]);
    }
}
