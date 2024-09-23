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
            $table->string('description')->nullable();
            $table->string('kind')->nullable();
            $table->string('location')->nullable();
            $table->string('assessed_value')->nullable();
            $table->string('market_value')->nullable();
            $table->string('acquisition_year')->nullable();
            $table->string('acquisition_mode')->nullable();
            $table->string('acquisition_cost')->nullable();
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
