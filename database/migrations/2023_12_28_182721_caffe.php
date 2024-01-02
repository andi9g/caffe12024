<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Caffe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list', function (Blueprint $table) {
            $table->bigIncrements('idlist');
            $table->String("namalist");
            $table->integer("idmenu");
            $table->string("gambar");
            $table->double("harga");
            $table->timestamps();
        });
        
        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements('idmenu');
            $table->string("namamenu");
            $table->timestamps();
        });

        $menu = [
            "makanan",
            "minuman",
        ];

        foreach ($menu as $item) {
            DB::table("menu")->insert([
                "namamenu" => $item,
            ]);
        }

        Schema::create('pesanan', function (Blueprint $table) {
            $table->bigIncrements('idpesanan');
            $table->integer("idlist");
            $table->integer("idmeja");
            $table->integer("jumlah");
            $table->timestamps();
        });

        Schema::create('meja', function (Blueprint $table) {
            $table->bigIncrements('idmeja');
            $table->integer("nomormeja");
            $table->timestamps();
        });

        Schema::create('pendapatan', function (Blueprint $table) {
            $table->bigIncrements('idpendatan');
            $table->integer("idlist");
            $table->integer("jumlah");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
