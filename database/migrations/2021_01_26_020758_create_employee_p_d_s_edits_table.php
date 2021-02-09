<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePDSEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_p_d_s_edits', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('employee_edit_request_id');
            $table->foreign('employee_edit_request_id')
                    ->references('id')
                    ->on('employee_p_d_s_edit_requests')
                    ->onDelete('cascade');
            $table->string('model_id')->nullable();
            $table->string('model')->nullable();
            $table->string('field')->nullable();
            $table->string('oldValue')->nullable();
            $table->string('newValue')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('employee_p_d_s_edits');
    }
}
