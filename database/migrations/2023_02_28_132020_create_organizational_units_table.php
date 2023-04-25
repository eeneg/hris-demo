<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationalUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizational_units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('group')->nullable();
            $table->uuid('parent_id')->index()->nullable();
            $table->foreignUuid('plantilla_contents_id')->nullable();
            $table->foreignUuid('department_id')->nullable();
            $table->timestamps();
        });

        Schema::table('organizational_units', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('organizational_units')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizational_units');
    }
}
