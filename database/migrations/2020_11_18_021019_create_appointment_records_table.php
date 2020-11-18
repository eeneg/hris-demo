<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_records', function (Blueprint $table) {
            $table->string('id')->primary()->unique();
            $table->string('personal_information_id', 100);
            $table->foreign('personal_information_id')
                  ->references('id')
                  ->on('personal_informations')
                  ->onDelete('cascade');
            $table->string('position_id', 100);
            $table->foreign('position_id')
                  ->references('id')
                  ->on('positions')
                  ->onDelete('cascade');
            $table->string('salary_grade_id', 100);
            $table->foreign('salary_grade_id')
                  ->references('id')
                  ->on('salary_grades')
                  ->onDelete('cascade');
            $table->string('status', 100);
            $table->string('nature_of_appointment', 100);
            $table->date('reckoning_date');
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
        Schema::dropIfExists('appointment_records');
    }
}
