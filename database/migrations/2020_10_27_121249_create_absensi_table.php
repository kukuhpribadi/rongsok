<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('absensi', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned();
			$table->date('tanggal_absen');
			$table->bigInteger('karyawan_id')->unsigned()->default(0)->index('FK_absensi_karyawan');
			$table->integer('absensi');
			$table->string('keterangan')->nullable();
			$table->integer('upah');
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
		Schema::drop('absensi');
	}
}
