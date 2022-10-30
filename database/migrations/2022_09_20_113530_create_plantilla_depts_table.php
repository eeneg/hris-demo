<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantillaDeptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantilla_depts', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('plantilla_id');
            $table->foreign('plantilla_id')
                ->references('id')
                ->on('plantillas')
                ->onDelete('cascade');
            $table->uuid('department_id')->nullable();
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('set null');
            $table->string('footnote', 1000)->nullable();
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
        Schema::dropIfExists('plantilla_depts');
    }
}
