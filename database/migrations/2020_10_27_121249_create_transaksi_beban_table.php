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
			$table->bigInteger('id', true)->unsigned();
			$table->integer('beban_usaha_id');
			$table->integer('harga')->nullable();
			$table->string('no_nota')->nullable();
			$table->date('tanggal_pembayaran')->nullable();
			$table->text('keterangan')->nullable();
			$table->timestamps(10);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transaksi_beban');
	}
}
