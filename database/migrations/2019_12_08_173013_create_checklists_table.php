<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateChecklistsTable.
 */
class CreateChecklistsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('checklists', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id');
            $table->integer('vehicle_id')->nullable();
            $table->integer('workshop_id');
            $table->integer('status');
            $table->text('description')->nullable();
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
		Schema::drop('checklists');
	}
}
