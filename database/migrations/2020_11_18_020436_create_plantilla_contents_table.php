<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantillaContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantilla_contents', function (Blueprint $table) {
            $table->string('id')->primary()->unique();
            $table->string('plantilla_id', 100);
            $table->foreign('plantilla_id')->references('id')->on('plantillas')->onDelete('cascade');
            $table->string('salary_grade_auth_id', 100);
            $table->foreign('salary_grade_auth_id')->references('id')->on('salary_grades')->onDelete('cascade');
            $table->string('salary_grade_prop_id', 100);
            $table->foreign('salary_grade_prop_id')->references('id')->on('salary_grades')->onDelete('cascade');
            $table->string('position_id', 100);
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->string('personal_information_id', 100);
            $table->foreign('personal_information_id')->references('id')->on('personal_informations')->onDelete('cascade');
            $table->string('old_number', 100);
            $table->string('new_number', 100);
            $table->double('difference_amount');
            $table->string('working_time', 100);
            $table->string('appointment_status', 100);
            $table->integer('order_number');
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
        Schema::dropIfExists('plantilla_contents');
    }
}
