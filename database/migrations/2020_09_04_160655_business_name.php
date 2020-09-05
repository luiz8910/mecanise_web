<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BusinessName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workshops', function (Blueprint $table){
            $table->string('business_name')->nullable();
            $table->string('cpf')->nullable();
        });

        Schema::table('people', function (Blueprint $table){
            $table->string('business_name')->nullable();
            $table->string('cnpj')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workshops', function (Blueprint $table){
            $table->dropColumn('business_name');
            $table->dropColumn('cpf');
        });

        Schema::table('people', function (Blueprint $table){
            $table->dropColumn('business_name');
            $table->dropColumn('cnpj');
        });
    }
}
