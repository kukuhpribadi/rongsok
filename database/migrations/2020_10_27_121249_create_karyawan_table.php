<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('karyawan', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned();
			$table->char('id_karyawan');
			$table->char('nama');
			$table->string('no_telp')->nullable();
			$table->string('alamat')->nullable();
			$table->integer('role')->nullable();
			$table->integer('status');
			$table->integer('upah')->nullable();
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
		Schema::drop('karyawan');
	}
}
