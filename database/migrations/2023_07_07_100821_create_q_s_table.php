<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('q_s', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('position_id');
            $table->foreign('position_id')
                ->references('id')
                ->on('positions');
            $table->string('sg')->nullable();
            $table->string('education', 999)->nullable();
            $table->string('experience', 999)->nullable();
            $table->string('training', 999)->nullable();
            $table->string('eligibility', 999)->nullable();
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
        Schema::dropIfExists('q_s');
    }
}
