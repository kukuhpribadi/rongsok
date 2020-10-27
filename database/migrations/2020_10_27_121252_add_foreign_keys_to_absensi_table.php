<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAbsensiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('absensi', function(Blueprint $table)
		{
			$table->foreign('karyawan_id', 'FK_absensi_karyawan')->references('id')->on('karyawan')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('absensi', function(Blueprint $table)
		{
			$table->dropForeign('FK_absensi_karyawan');
		});
	}

}
