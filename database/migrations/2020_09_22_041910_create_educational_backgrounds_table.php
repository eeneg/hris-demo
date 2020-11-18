<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationalBackgroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educational_backgrounds', function (Blueprint $table) {
            $table->string('id', 100)->primary()->unique();
            $table->string('personal_information_id', 100);
            $table->foreign('personal_information_id')
                    ->references('id')
                    ->on('personal_informations')
                    ->onDelete('cascade');
            $table->string('elemSchoolName', 500)->nullable();
            $table->string('secSchoolName', 500)->nullable();
            $table->string('vocSchoolName', 500)->nullable();
            $table->string('collSchoolName1', 500)->nullable();
            $table->string('collSchoolName2', 500)->nullable();
            $table->string('gradSchoolName', 500)->nullable();
            $table->string('elemDegree', 500)->nullable();
            $table->string('secDegree', 500)->nullable();
            $table->string('vocDegree', 500)->nullable();
            $table->string('collDegree1', 500)->nullable();
            $table->string('collDegree2', 500)->nullable();
            $table->string('gradDegree', 500)->nullable();
            $table->string('elemYear', 45)->nullable();
            $table->string('secYear', 45)->nullable();
            $table->string('vocYear', 45)->nullable();
            $table->string('collYear1', 45)->nullable();
            $table->string('collYear2', 45)->nullable();
            $table->string('gradYear', 45)->nullable();
            $table->string('elemHighestLevel', 100)->nullable();
            $table->string('secHighestLevel', 100)->nullable();
            $table->string('vocHighestLevel', 100)->nullable();
            $table->string('collHighestLevel1', 100)->nullable();
            $table->string('collHighestLevel2', 100)->nullable();
            $table->string('gradHighestLevel', 100)->nullable();
            $table->string('elemFrom', 45)->nullable();
            $table->string('elemTo', 45)->nullable();
            $table->string('secFrom', 45)->nullable();
            $table->string('secTo', 45)->nullable();
            $table->string('vocFrom', 45)->nullable();
            $table->string('vocTo', 45)->nullable();
            $table->string('collFrom1', 45)->nullable();
            $table->string('collFrom2', 45)->nullable();
            $table->string('collTo1', 45)->nullable();
            $table->string('collTo2', 45)->nullable();
            $table->string('gradFrom', 45)->nullable();
            $table->string('gradTo', 45)->nullable();
            $table->string('elemSOA', 100)->nullable();
            $table->string('secSOA', 100)->nullable();
            $table->string('vocSOA', 100)->nullable();
            $table->string('collSOA1', 100)->nullable();
            $table->string('collSOA2', 100)->nullable();
            $table->string('gradSOA', 100)->nullable();
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
        Schema::dropIfExists('educational_backgrounds');
    }
}
