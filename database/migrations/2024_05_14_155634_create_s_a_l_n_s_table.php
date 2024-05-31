<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSALNSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_a_l_n_s', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('personal_information_id');
            $table->foreign('personal_information_id')
                ->references('id')
                ->on('personal_informations')
                ->onDelete('cascade');
            $table->string('declarant_fn');
            $table->string('declarant_ln');
            $table->string('declarant_mi');
            $table->string('declarant_address');
            $table->string('declarant_position');
            $table->string('declarant_agency');
            $table->string('declarant_office_address');
            $table->string('spouse_fn')->nullable();
            $table->string('spouse_ln')->nullable();
            $table->string('spouse_mi')->nullable();
            $table->string('spouse_position')->nullable();
            $table->string('spouse_agency')->nullable();
            $table->string('spouse_agency_address')->nullable();
            $table->string('real_property_subtotal')->nullable();
            $table->string('personal_property_subtotal')->nullable();
            $table->string('total_asset')->nullable();
            $table->string('total_liability')->nullable();
            $table->string('net_worth')->nullable();
            $table->string('date');
            $table->string('gov_id1');
            $table->string('idNo_id1');
            $table->string('idDate_id1');
            $table->string('gov_id2')->nullable();
            $table->string('idNo_id2')->nullable();
            $table->string('idDate_id2')->nullable();
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
        Schema::dropIfExists('s_a_l_n_s');
    }
}
