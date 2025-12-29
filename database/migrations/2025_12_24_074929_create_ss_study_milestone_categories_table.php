<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsStudyMilestoneCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_study_milestone_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ss_study_id');
            $table->unsignedBigInteger('ss_organisation_id')->nullable();
            $table->unsignedBigInteger('ss_study_milestones_id')->nullable();
            $table->unsignedBigInteger('ss_milestone_category_id')->nullable();

            $table->string('study_category_name')->nullable();
            $table->text('description')->nullable();

            $table->integer('order')->default(1);
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('ss_study_id')->references('id')->on('ss_studies');
            $table->foreign('ss_organisation_id')->references('id')->on('ss_organizations');
            $table->foreign('ss_study_milestones_id')->references('id')->on('ss_study_milestones');
            $table->foreign('ss_milestone_category_id')->references('id')->on('ss_milestone_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ss_study_milestone_categories');
    }
}
