<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBebanUsahaTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beban_usaha', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned();
			$table->string('jenis_beban');
			$table->integer('harga');
			$table->string('keterangan')->nullable();
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
		Schema::drop('beban_usaha');
	}
}
