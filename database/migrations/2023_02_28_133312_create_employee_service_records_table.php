<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeServiceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_service_records', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('service_record_id');
            $table->foreign('service_record_id')
                ->references('id')
                ->on('service_records');
            $table->string('from');
            $table->string('to');
            $table->string('position');
            $table->string('status');
            $table->string('salary');
            $table->string('station');
            $table->string('branch');
            $table->string('pay');
            $table->string('remark');
            $table->string('date');
            $table->string('cause');
            $table->integer('orderNo');
            $table->softDeletes();
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
        Schema::dropIfExists('employee_service_records');
    }
}
