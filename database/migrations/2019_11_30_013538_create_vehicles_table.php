<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateVehiclesTable.
 */
class CreateVehiclesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vehicles', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id');
            $table->integer('workshop_id');
            $table->integer('car_id');
            $table->string('color')->nullable();
            $table->string('license_plate')->nullable();
            $table->string('chassis')->nullable();
            $table->string('description')->nullable();
            $table->string('km')->nullable();
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
		Schema::drop('vehicles');
	}
}
