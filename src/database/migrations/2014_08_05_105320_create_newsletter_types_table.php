<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsletterTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('newsletter_types', function(Blueprint $table)
		{

			$table->increments('id');
            $table->string('titre');
            $table->string('image');
            $table->string('partial');
            $table->string('template');
            $table->enum('elements', array('titre','titre,texte','titre,texte,image','texte','image','titre,image','arret','categorie'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('newsletter_types');
	}

}
