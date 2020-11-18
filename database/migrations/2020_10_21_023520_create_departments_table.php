<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->string('id', 100)->primary()->unique();
            $table->string('title', 200)->nullable();
            $table->string('description', 500)->nullable();
            $table->string('address', 900)->nullable();
            $table->string('function', 500)->nullable();
            $table->string('projectactivity', 600)->nullable();
            $table->string('fund', 400)->nullable();
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
        Schema::dropIfExists('departments');
    }
}
