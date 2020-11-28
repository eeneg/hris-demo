<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePDSQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_d_s_questions', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('personal_information_id');
            $table->foreign('personal_information_id')
                  ->references('id')
                  ->on('personal_informations')
                  ->onDelete('cascade');
            $table->char('q34a')->nullable();
            $table->char('q34b')->nullable();
            $table->string('q34bdetails')->nullable();
            $table->char('q35a')->nullable();
            $table->string('q35adetails')->nullable();
            $table->char('q35b')->nullable();
            $table->date('q35bdatefiled')->nullable();
            $table->string('q35bcasestatus')->nullable();
            $table->char('q36a')->nullable();
            $table->string('q36adetails')->nullable();
            $table->char('q37a')->nullable();
            $table->string('q37adetails')->nullable();
            $table->char('q38a')->nullable();
            $table->string('q38adetails')->nullable();
            $table->char('q38b')->nullable();
            $table->string('q38bdetails')->nullable();
            $table->char('q39a')->nullable();
            $table->string('q39adetails')->nullable();
            $table->char('q40a')->nullable();
            $table->string('q40adetails')->nullable();
            $table->char('q40b')->nullable();
            $table->string('q40bdetails')->nullable();
            $table->char('q40c')->nullable();
            $table->string('q40cdetails')->nullable();
            $table->string('refname1')->nullable();
            $table->string('refaddress1')->nullable();
            $table->string('reftelephone1')->nullable();
            $table->string('refname2')->nullable();
            $table->string('refaddress2')->nullable();
            $table->string('reftelephone2')->nullable();
            $table->string('refname3')->nullable();
            $table->string('refaddress3')->nullable();
            $table->string('reftelephone3')->nullable();
            $table->string('govid')->nullable();
            $table->string('idnumber')->nullable();
            $table->string('dateissued')->nullable();
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
        Schema::dropIfExists('p_d_s_questions');
    }
}
