<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalinformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_informations', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('surname', 100)->nullable();
            $table->string('firstname', 100)->nullable();
            $table->string('middlename', 100)->nullable();
            $table->string('nameextension', 100)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birthplace', 500)->nullable();
            $table->string('sex', 100)->nullable();
            $table->string('civilstatus', 100)->nullable();
            $table->string('citizenship', 100)->nullable();
            $table->string('height', 100)->nullable();
            $table->string('weight', 100)->nullable();
            $table->string('bloodtype', 100)->nullable();
            $table->string('gsis', 100)->nullable();
            $table->string('pagibig', 100)->nullable();
            $table->string('philhealth', 100)->nullable();
            $table->string('sss', 100)->nullable();
            $table->string('residentialaddress', 900)->nullable();
            $table->string('zipcode1', 100)->nullable();
            $table->string('telephone1', 100)->nullable();
            $table->string('permanentaddress', 900)->nullable();
            $table->string('zipcode2', 100)->nullable();
            $table->string('telephone2', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('cellphone', 100)->nullable();
            $table->string('agencynumber', 100)->nullable();
            $table->string('tin', 100)->nullable();
            $table->string('religion')->nullable();
            $table->string('other_religion')->nullable();
            $table->string('picture', 300)->nullable();
            $table->date('retirement_date')->nullable();
            $table->string('status', 100)->nullable();
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
        Schema::dropIfExists('personal_informations');
    }
}
