<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsletterCampagnesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('newsletter_campagnes', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('sujet');
            $table->string('auteurs');
            $table->integer('newsletter_id');
            $table->integer('api_campagne_id');
            $table->enum('status', array('brouillon', 'envoyé'));
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
		Schema::drop('newsletter_campagnes');
	}

}
