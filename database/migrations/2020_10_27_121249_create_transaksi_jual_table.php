<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiJualTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transaksi_jual', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned();
			$table->date('tanggal_input');
			$table->char('transaksi_jual_id', 50);
			$table->bigInteger('barang_id')->unsigned()->index('FK_transaksi_jual_barang');
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
		Schema::drop('transaksi_jual');
	}
}
