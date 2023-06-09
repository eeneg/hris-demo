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
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('position')->nullable();
            $table->string('status')->nullable();
            $table->string('salary')->nullable();
            $table->string('station')->nullable();
            $table->string('branch')->nullable();
            $table->string('pay')->nullable();
            $table->string('remark')->nullable();
            $table->string('date')->nullable();
            $table->string('cause')->nullable();
            $table->integer('orderNo')->nullable();
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
