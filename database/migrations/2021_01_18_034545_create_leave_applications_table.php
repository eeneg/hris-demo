<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('personal_information_id');
            $table->foreign('personal_information_id')->references('id')->on('personal_informations')->onDelete('cascade');
            $table->uuid('leave_type_id');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');
            $table->date('date_of_filing');
            $table->string('working_days');
            $table->string('spent', 500)->nullable();
            $table->string('spent_spec', 500)->nullable();
            $table->string('commutation');
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->date('credit_as_of');
            $table->double('vacation_balance')->nullable();
            $table->double('sick_balance')->nullable();
            $table->double('vacation_less')->nullable();
            $table->double('sick_less')->nullable();
            $table->string('recommendation', 900);
            $table->double('days_with_pay')->nullable();
            $table->double('days_without_pay')->nullable();
            $table->string('others')->nullable();
            $table->string('disapproved_due_to', 900)->nullable();
            $table->string('status');

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
        Schema::dropIfExists('leave_applications');
    }
}
