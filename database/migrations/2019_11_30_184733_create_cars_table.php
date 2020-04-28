<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCarsTable.
 */
class CreateCarsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cars', function(Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->string('brand')->nullable();
            $table->string('year')->nullable();
            $table->string('version')->nullable();
            $table->string('fuel')->nullable();
            $table->string('picture')->nullable();
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
		Schema::drop('cars');
	}
}
