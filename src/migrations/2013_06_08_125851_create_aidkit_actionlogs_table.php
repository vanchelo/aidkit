<?php

use Illuminate\Database\Migrations\Migration;

class CreateAidkitActionlogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('actionlogs', function($table)
		{
		    $table->increments('id');
		    $table->integer('userid');
		    $table->string('action');
		    $table->string('object');
		    $table->integer('object_id');
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
		Schema::dropIfExists('actionlogs');
	}

}