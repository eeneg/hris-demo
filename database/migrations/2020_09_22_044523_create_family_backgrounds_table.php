<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyBackgroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_backgrounds', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('personal_information_id', 100);
            $table->foreign('personal_information_id')
                    ->references('id')
                    ->on('personal_informations')
                    ->onDelete('cascade');
            $table->string('spouseSurname', 100);
            $table->string('spouseFirstname', 100);
            $table->string('spouseMiddlename', 100);
            $table->string('spouseOccupation', 100);
            $table->string('spouseBussiness', 100);
            $table->string('spouseBussinessAddress', 100);
            $table->string('spouseTelephone', 100);
            $table->string('fatherSurname', 100);
            $table->string('fatherFirstname', 100);
            $table->string('fatherMiddlename', 100);
            $table->string('motherSurname', 100);
            $table->string('motherFirstname', 100);
            $table->string('motherMiddlename', 100);
            $table->string('motherMaidenName', 100);
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
        Schema::dropIfExists('family_backgrounds');
    }
}
