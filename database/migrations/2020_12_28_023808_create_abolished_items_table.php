<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbolishedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abolished_items', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('plantilla_content_id');
            $table->foreign('plantilla_content_id')
                    ->references('id')
                    ->on('plantilla_contents')
                    ->onDelete('cascade');
            $table->uuid('salary_grade_prop_id')->nullable();
            $table->foreign('salary_grade_prop_id')
                    ->references('id')
                    ->on('salary_grades')
                    ->onDelete('cascade');
            $table->string('new_number', 100)->nullable();
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
        Schema::dropIfExists('abolished_items');
    }
}
