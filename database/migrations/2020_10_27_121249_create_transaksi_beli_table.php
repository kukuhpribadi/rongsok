<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiBeliTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transaksi_beli', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned();
			$table->date('tanggal_input');
			$table->char('transaksi_beli_id', 50);
			$table->bigInteger('barang_id')->unsigned()->default(0)->index('FK_transaksi_beli_barang');
			$table->integer('harga');
			$table->float('qty', 10, 0)->default(0);
			$table->string('keterangan')->nullable();
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
		Schema::drop('transaksi_beli');
	}
}
