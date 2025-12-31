<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsStudyStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_study_staffs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ss_organizations_id')->nullable();
            $table->unsignedBigInteger('ss_study_id');
            $table->unsignedBigInteger('ss_user_id');

            $table->integer('enum_staff_type_id');

            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by');
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('ss_organizations_id')->references('id')->on('ss_organizations')->onDelete('set null');
            $table->foreign('ss_study_id')->references('id')->on('ss_studies')->onDelete('cascade');
            $table->foreign('ss_user_id')->references('id')->on('ss_users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('ss_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ss_study_staffs');
    }
}
