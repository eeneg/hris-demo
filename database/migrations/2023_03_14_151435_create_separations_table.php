<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeparationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('separations', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('personal_information_id');
            $table->foreign('personal_information_id')
                    ->references('id')
                    ->on('personal_informations')
                    ->onDelete('cascade');
            $table->string('mode', 100);
            $table->string('position', 500);
            $table->string('office', 999);
            $table->string('item_no', 100);
            $table->string('appointment_status', 300);
            $table->string('salary_grade', 10);
            $table->string('description', 999)->nullable();
            $table->date('effectivity_date');
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
        Schema::dropIfExists('separations');
    }
}
