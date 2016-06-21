<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsletterUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('newsletter_users', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('email');
            $table->string('prenom')->nullable();
            $table->string('nom')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->string('activation_token', 100)->nullable();
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
		Schema::drop('newsletter_users');
	}

}
