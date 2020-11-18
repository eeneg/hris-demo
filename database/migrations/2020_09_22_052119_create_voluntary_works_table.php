<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoluntaryWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voluntary_works', function (Blueprint $table) {
            $table->string('id', 100)->primary()->unique();
            $table->string('personal_information_id', 100);
            $table->foreign('personal_information_id')
                    ->references('id')
                    ->on('personal_informations')
                    ->onDelete('cascade');
            $table->string('nameAndAddress', 300)->nullable();
            $table->string('inclusiveDateFrom', 100)->nullable();
            $table->string('inclusiveDateTo', 100)->nullable();
            $table->string('hours', 100)->nullable();
            $table->string('position', 300)->nullable();
            $table->integer('orderNo');
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
        Schema::dropIfExists('voluntary_works');
    }
}
