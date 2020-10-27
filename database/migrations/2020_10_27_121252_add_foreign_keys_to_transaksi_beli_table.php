<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTransaksiBeliTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transaksi_beli', function(Blueprint $table)
		{
			$table->foreign('barang_id', 'FK_transaksi_beli_barang')->references('id')->on('barang')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('transaksi_beli', function(Blueprint $table)
		{
			$table->dropForeign('FK_transaksi_beli_barang');
		});
	}

}
