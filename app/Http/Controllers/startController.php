<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\SiswaExport;
use PDF;
use Excel;

class startController extends Controller
{

    public function gambar(Request $request)
    {
        $request->validate([
            'gambar' => 'required|mimes:doc,docx,PDF,pdf,jpg,jpeg,png|max:2000',
        ]);

        if ($request->hasfile('gambar')) {
            $gambar = $request->file('gambar');
            $extension = $gambar->getClientOriginalExtension();
            $filename = strtotime(date('Y-m-d H:i:s'))."-".uniqid().".".$extension;
            $size = $gambar->getSize();

            $ex = strtolower($extension);

            if ($size < 3000000 && ($ex == 'jpeg' || $ex == 'jpg' || $ex == 'png')) {
                $coba = $gambar->move(public_path('gambar/profil'), $filename);
                // dd($coba);
            }
            $lanjut = true;
        }else{
            $lanjut = false;
        }

        if ($lanjut) {
            $update = siswa::where('id', $id)->update([
                'gambar' => $filename,
            ]);

            return redirect()->back()->with('success', 'data berhasil ditambahkan')->withInput();
        }else {
            dd('error');
            return redirect()->back();
        }
    }


    public function pdf(Request $request)
    {
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        // dd($coba);
        return view('siswa')->with('success', 'berhasil');
    }


    public function export(Type $var = null)
    {
        // return Excel::download(new SiswaExport, 'users.xlsx');
        $data = new SiswaExport;
        dd($data);
    }



}
