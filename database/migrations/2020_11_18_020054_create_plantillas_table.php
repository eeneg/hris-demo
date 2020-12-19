<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantillas', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('salary_schedule_auth_id');
            $table->foreign('salary_schedule_auth_id')->references('id')->on('salary_schedules')->onDelete('cascade');
            $table->uuid('salary_schedule_prop_id');
            $table->foreign('salary_schedule_prop_id')->references('id')->on('salary_schedules')->onDelete('cascade');
            $table->string('year');
            $table->date('date_prepared')->nullable();
            $table->date('date_approved')->nullable();
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
        Schema::dropIfExists('plantillas');
    }
}
