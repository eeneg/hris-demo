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
            $table->uuid('id')->primary()->unique();
            $table->uuid('plantilla_id');
            $table->foreign('plantilla_id')
                ->references('id')
                ->on('plantillas')
                ->onDelete('cascade');
            $table->uuid('salary_grade_auth_id')->nullable();
            $table->foreign('salary_grade_auth_id')
                ->references('id')
                ->on('salary_grades')
                ->onDelete('set null');
            $table->uuid('salary_grade_prop_id')->nullable();
            $table->foreign('salary_grade_prop_id')
                ->references('id')
                ->on('salary_grades')
                ->onDelete('set null');
            $table->uuid('position_id')->nullable();
            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onDelete('set null');
            $table->uuid('personal_information_id')->nullable();
            $table->foreign('personal_information_id')
                ->references('id')
                ->on('personal_informations')
                ->onDelete('set null');
            $table->string('old_number', 100)->nullable();
            $table->string('new_number', 100)->nullable();
            $table->decimal('difference_amount', 8, 2)->nullable();
            $table->string('working_time', 100)->nullable();

            $table->string('level', 100)->nullable();
            $table->date('original_appointment')->nullable();
            $table->date('last_promotion')->nullable();

            $table->string('appointment_status', 100)->nullable();
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
