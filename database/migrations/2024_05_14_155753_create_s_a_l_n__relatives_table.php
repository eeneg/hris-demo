<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSALNRelativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_a_l_n__relatives', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('saln_id');
            $table->foreign('saln_id')
                ->references('id')
                ->on('s_a_l_n_s')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('relationship');
            $table->string('postion');
            $table->string('agency_name_and_address');
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
        Schema::dropIfExists('s_a_l_n__relatives');
    }
}
