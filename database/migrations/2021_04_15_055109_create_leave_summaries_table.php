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
            $table->json('period')->nullable();
            $table->json('particulars')->nullable();
            $table->double('vl_earned')->nullable();
            $table->double('vl_withpay')->nullable();
            $table->double('vl_balance', 10, 3)->nullable();
            $table->double('vl_withoutpay')->nullable();
            $table->double('sl_earned')->nullable();
            $table->double('sl_withpay')->nullable();
            $table->double('sl_balance', 10, 3)->nullable();
            $table->double('sl_withoutpay')->nullable();
            $table->string('remarks', 500)->nullable();
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
