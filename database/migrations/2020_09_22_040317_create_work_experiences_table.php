<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('personal_information_id');
            $table->foreign('personal_information_id')
                    ->references('id')
                    ->on('personal_informations')
                    ->onDelete('cascade');
            $table->string('inclusiveDateFrom', 100)->nullable();
            $table->string('inclusiveDateTo', 100)->nullable();
            $table->string('position', 300)->nullable();
            $table->string('department', 300)->nullable();
            $table->string('monthlySalary', 100)->nullable();
            $table->string('salaryGrade', 100)->nullable();
            $table->string('statusOfAppointment', 300)->nullable();
            $table->string('govService', 45)->nullable();
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
        Schema::dropIfExists('work_experiences');
    }
}
