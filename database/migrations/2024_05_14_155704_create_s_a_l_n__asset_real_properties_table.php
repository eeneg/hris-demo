<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSALNAssetRealPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_a_l_n__asset_real_properties', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('saln_id');
            $table->foreign('saln_id')
                ->references('id')
                ->on('s_a_l_n_s')
                ->onDelete('cascade');
            $table->string('description');
            $table->string('kind');
            $table->string('location');
            $table->string('assessed_value');
            $table->string('market_value');
            $table->string('acquisition_year');
            $table->string('acquisition_mode');
            $table->string('acquisition_cost');
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
        Schema::dropIfExists('s_a_l_n__asset_real_properties');
    }
}
