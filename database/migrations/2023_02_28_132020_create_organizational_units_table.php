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
            $table->uuid('id');
            $table->string('name');
            $table->string('group');
            $table->foreignUuid('parent_id');
            $table->foreignUuid('plantilla_contents_id')->nullable();
            $table->foreignUuid('department_id')->nullable();
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
        Schema::dropIfExists('organizational_units');
    }
}
