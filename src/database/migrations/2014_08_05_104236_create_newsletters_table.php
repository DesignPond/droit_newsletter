<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewslettersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('newsletters', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('titre');
            $table->integer('site_id')->nullable();
			$table->integer('list_id');
            $table->string('from_name');
            $table->string('from_email');
            $table->string('return_email');
            $table->string('unsuscribe');
            $table->string('preview');
            $table->string('logos')->nullable();
            $table->string('header')->nullable();
			$table->string('soutien')->nullable();
            $table->string('color');
            $table->timestamps();
            $table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('newsletters');
	}

}
