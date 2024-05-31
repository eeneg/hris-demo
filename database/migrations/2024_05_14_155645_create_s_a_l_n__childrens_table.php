<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSALNChildrensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_a_l_n__childrens', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('saln_id');
            $table->foreign('saln_id')
                ->references('id')
                ->on('s_a_l_n_s')
                ->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('dob')->nullable();
            $table->string('age')->nullable();
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
        Schema::dropIfExists('s_a_l_n__childrens');
    }
}
