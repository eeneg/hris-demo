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
            $table->string('id', 100)->primary()->unique();
            $table->string('personal_information_id', 100);
            $table->foreign('personal_information_id')
                    ->references('id')
                    ->on('personal_informations')
                    ->onDelete('cascade');
            $table->string('spouseSurname', 100)->nullable();
            $table->string('spouseFirstname', 100)->nullable();
            $table->string('spouseMiddlename', 100)->nullable();
            $table->string('spouseOccupation', 100)->nullable();
            $table->string('spouseBussiness', 100)->nullable();
            $table->string('spouseBussinessAddress', 100)->nullable();
            $table->string('spouseTelephone', 100)->nullable();
            $table->string('fatherSurname', 100)->nullable();
            $table->string('fatherFirstname', 100)->nullable();
            $table->string('fatherMiddlename', 100)->nullable();
            $table->string('motherSurname', 100)->nullable();
            $table->string('motherFirstname', 100)->nullable();
            $table->string('motherMiddlename', 100)->nullable();
            $table->string('motherMaidenName', 100)->nullable();
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
