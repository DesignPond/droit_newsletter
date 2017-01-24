<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsletterContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('newsletter_contents', function(Blueprint $table)
		{

			$table->increments('id');
            $table->integer('type_id');
            $table->string('titre')->nullable();
            $table->binary('contenu')->nullable();
            $table->string('image')->nullable();
            $table->string('lien')->nullable();
            $table->integer('arret_id')->nullable();
            $table->integer('groupe_id')->nullable();
			$table->integer('categorie_id')->nullable();
			$table->integer('product_id')->nullable();
			$table->integer('colloque_id')->nullable();
            $table->integer('newsletter_campagne_id');
            $table->integer('rang');
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
		Schema::drop('newsletter_contents');
	}

}
