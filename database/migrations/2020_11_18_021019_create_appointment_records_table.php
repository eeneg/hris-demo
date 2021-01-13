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
            $table->uuid('id')->primary()->unique();
            $table->uuid('personal_information_id');
            $table->foreign('personal_information_id')
                  ->references('id')
                  ->on('personal_informations')
                  ->onDelete('cascade');
            $table->uuid('position_id');
            $table->foreign('position_id')
                  ->references('id')
                  ->on('positions');
            $table->uuid('salary_grade_id');
            $table->foreign('salary_grade_id')
                  ->references('id')
                  ->on('salary_grades');
            $table->string('status', 100)->nullable();
            $table->string('agency', 100)->nullable();
            $table->string('nature_of_appointment', 100)->nullable();
            $table->string('previous_employee', 100)->nullable();
            $table->string('previous_status', 100)->nullable();
            $table->integer('itemno')->nullable();
            $table->integer('page')->nullable();
            $table->date('reckoning_date')->nullable();
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
