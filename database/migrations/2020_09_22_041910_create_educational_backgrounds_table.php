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
            $table->string('id', 100)->primary();
            $table->string('personal_information_id', 100);
            $table->foreign('personal_information_id')
                    ->references('id')
                    ->on('personal_informations')
                    ->onDelete('cascade');
            $table->string('elemSchoolName', 500);
            $table->string('secSchoolName', 500);
            $table->string('vocSchoolName', 500);
            $table->string('collSchoolName1', 500);
            $table->string('collSchoolName2', 500);
            $table->string('gradSchoolName', 500);
            $table->string('elemDegree', 500);
            $table->string('secDegree', 500);
            $table->string('vocDegree', 500);
            $table->string('collDegree1', 500);
            $table->string('collDegree2', 500);
            $table->string('gradDegree', 500);
            $table->string('elemYear', 45);
            $table->string('secYear', 45);
            $table->string('vocYear', 45);
            $table->string('collYear1', 45);
            $table->string('collYear2', 45);
            $table->string('gradYear', 45);
            $table->string('elemHighestLevel', 100);
            $table->string('secHighestLevel', 100);
            $table->string('vocHighestLevel', 100);
            $table->string('collHighestLevel1', 100);
            $table->string('collHighestLevel2', 100);
            $table->string('gradHighestLevel', 100);
            $table->string('elemFrom', 45);
            $table->string('elemTo', 45);
            $table->string('secFrom', 45);
            $table->string('secTo', 45);
            $table->string('vocFrom', 45);
            $table->string('vocTo', 45);
            $table->string('collFrom1', 45);
            $table->string('collFrom2', 45);
            $table->string('collTo1', 45);
            $table->string('collTo2', 45);
            $table->string('gradFrom', 45);
            $table->string('gradTo', 45);
            $table->string('elemSOA', 100);
            $table->string('secSOA', 100);
            $table->string('vocSOA', 100);
            $table->string('collSOA1', 100);
            $table->string('collSOA2', 100);
            $table->string('gradSOA', 100);
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
