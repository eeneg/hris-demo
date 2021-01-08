<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFootnotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footnotes', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('plantilla_id');
            $table->foreign('plantilla_id')
                  ->references('id')
                  ->on('plantillas')
                  ->onDelete('cascade');
            $table->uuid('department_id');
            $table->foreign('department_id')
                  ->references('id')
                  ->on('departments')
                  ->onDelete('cascade');
            $table->string('note', 1000);
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
        Schema::dropIfExists('footnotes');
    }
}
