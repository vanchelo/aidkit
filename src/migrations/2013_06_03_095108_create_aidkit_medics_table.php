<?php

use Illuminate\Database\Migrations\Migration;

class CreateAidkitMedicsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('medics', function($table)
		{
		    $table->increments('id');
		    $table->string('name');
		    $table->string('username')->unique();
		    $table->string('password',60);
		    $table->string('email')->unique()->nullable()->default(null);
		    $table->integer('role')->nullable()->default(null);
		    $table->datetime('last_login')->nullable()->default(null);
		    $table->softDeletes();
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
		Schema::dropIfExists('medics');
	}

}