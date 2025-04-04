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
            $table->foreign('leave_type_id')->references('id')->on('leave_types');
            $table->string('department');
            $table->string('position');
            $table->string('salary');
            $table->date('date_of_filing');
            $table->double('working_days');
            $table->string('spent');
            $table->string('spent_specified')->nullable(); //spent_spec to spent_specified
            $table->string('commutation');
            $table->json('inclusive_dates');
            $table->date('credit_as_of')->nullable();
            $table->double('vacation_balance')->nullable();
            $table->double('vacation_less')->nullable();
            $table->double('sick_balance')->nullable();
            $table->double('sick_less')->nullable();
            $table->json('credit_officer')->nullable();
            $table->json('recommendation_officer')->nullable();
            $table->boolean('recommendation_approved')->nullable(); //string to boolean
            $table->string('recommendation_disapproved_due_to')->nullable();//recommendation_remark_approved to recommendation_remark
            $table->string('leave_type_others');
            $table->boolean('final');   //final or draft boolean
            $table->double('days_with_pay');
            $table->double('days_without_pay');
            $table->string('approved_for_others');
            $table->json('noted_by_officer'); // noted by officer details (name, position, date)
            $table->boolean('noted_by_approved'); //boolean
            $table->string('noted_disapproved_due_to')->nullable(); //noted_disapproved_due_to remark
            $table->json('governor_approval_officer'); // governor approval officer details (name, position, date)
            $table->boolean('governor_approved'); // boolean
            $table->string('gov_disapproved_due_to')->nullable(); //disapproved_due_to to gov_disapproved_due_to
            $table->string('application_stage'); //stage_status to application_stage
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
