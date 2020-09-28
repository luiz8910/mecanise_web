<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('people', function (Blueprint $table){
            $table->integer('active')->default(1);
        });

        Schema::table('users', function (Blueprint $table){
            $table->integer('active')->default(1);
        });

        Schema::table('vehicles', function (Blueprint $table){
            $table->integer('active')->default(1);
        });

        Schema::table('parts', function (Blueprint $table){
            $table->integer('active')->default(1);
        });

        Schema::table('workshops', function (Blueprint $table){
            $table->integer('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('people', function (Blueprint $table){
            $table->dropColumn('active')->default(1);
        });

        Schema::table('users', function (Blueprint $table){
            $table->dropColumn('active')->default(1);
        });

        Schema::table('vehicles', function (Blueprint $table){
            $table->dropColumn('active')->default(1);
        });

        Schema::table('parts', function (Blueprint $table){
            $table->dropColumn('active')->default(1);
        });

        Schema::table('workshops', function (Blueprint $table){
            $table->dropColumn('active')->default(1);
        });
    }
}
