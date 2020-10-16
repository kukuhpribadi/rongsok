<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiBebanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_beban', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('jenis_beban_id');
            $table->integer('harga');
            $table->string('no_nota')->nullable();
            $table->date('tanggal_pembayaran');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('transaksi_beban');
    }
}
