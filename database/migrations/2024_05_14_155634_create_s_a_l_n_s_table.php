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
            $table->string('declarant_fn');
            $table->string('declarant_ln');
            $table->string('declarant_mi');
            $table->string('declarant_address');
            $table->string('declarant_position');
            $table->string('declarant_agency');
            $table->string('declarant_office_address');
            $table->string('spouse_fn');
            $table->string('spouse_ln');
            $table->string('spouse_mi');
            $table->string('spouse_position');
            $table->string('spouse_agency');
            $table->string('spouse_agency_address');
            $table->string('real_property_subtotal');
            $table->string('personal_property_subtotal');
            $table->string('total_asset');
            $table->string('total_liability');
            $table->string('net_worth');
            $table->string('date');
            $table->string('gov_id1');
            $table->string('idNo_id1');
            $table->string('idDate_id1');
            $table->string('gov_id2');
            $table->string('idNo_id2');
            $table->string('idDate_id2');
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
