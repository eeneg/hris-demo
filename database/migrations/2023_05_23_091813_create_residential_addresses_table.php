<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResidentialAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residential_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary()->uniqid();
            $table->uuid('personal_information_id');
            $table->foreign('personal_information_id')
                ->references('id')
                ->on('personal_informations')
                ->onDelete('cascade');
            $table->string('house_lotNo');
            $table->string('street');
            $table->string('subdv_village');
            $table->string('barangay');
            $table->string('city_municipality');
            $table->string('province');
            $table->string('zipcode');
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
        Schema::dropIfExists('residential_addresses');
    }
}
