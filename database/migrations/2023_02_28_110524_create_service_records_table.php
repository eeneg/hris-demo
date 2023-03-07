<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_records', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('personal_information_id');
            $table->foreign('personal_information_id')
                ->references('id')
                ->on('personal_informations');
            $table->string('dateCertified');
            $table->string('certifier_id');
            $table->string('ORNo');
            $table->date('dateIssued');
            $table->string('amount');
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
        Schema::dropIfExists('service_records');
    }
}
