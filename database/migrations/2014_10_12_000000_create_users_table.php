<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Contact extends Eloquent {
public static $timestamps = false;
}

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			Schema::table('Users', function ($table) {
   			/*$table->increments('id');
			$table->integer('id_owner');
			$table->integer('id_premise');
			$table->string('login')->unique();
			$table->string('password', 60);
			$table->string('email')->unique();
			
			$table->rememberToken();
			$table->timestamps();*/
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Users');
	}

}
