<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_summaries', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('personal_information_id');
            $table->foreign('personal_information_id')
                    ->references('id')
                    ->on('personal_informations')
                    ->onDelete('cascade');
            $table->string('period')->nullable();
            $table->string('custom_leave')->nullable();
            $table->string('particulars')->nullable();
            $table->double('vl_earned')->nullable();
            $table->string('vl_withpay')->nullable();
            $table->double('vl_balance', 10, 3)->nullable();
            $table->string('vl_withoutpay')->nullable();
            $table->double('sl_earned')->nullable();
            $table->string('sl_withpay')->nullable();
            $table->double('sl_balance', 10, 3)->nullable();
            $table->string('sl_withoutpay')->nullable();
            $table->string('remarks', 500)->nullable();
            $table->integer('detail1')->nullable();
            $table->string('detail2')->nullable();
            $table->string('detail3')->nullable();
            $table->integer('sort')->nullable();
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
        Schema::dropIfExists('leave_summaries');
    }
}
