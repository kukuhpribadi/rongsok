<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTransaksiJualTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transaksi_jual', function(Blueprint $table)
		{
			$table->foreign('barang_id', 'FK_transaksi_jual_barang')->references('id')->on('barang')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('transaksi_jual', function(Blueprint $table)
		{
			$table->dropForeign('FK_transaksi_jual_barang');
		});
	}

}
